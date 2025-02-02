<?php


namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Seat;
use App\Models\Time;
use App\Models\Booking;
use App\Models\News;
use Stripe\Climate\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\User; // Assuming staff are stored in the users table

class UserController extends Controller
{
    public function dashboard()
    {
        $news = News::all();
        return view('user.dashboard',compact('news'));
    }

    public function booking() {
        $facilities = [
            ['id' => 1, 'slogan' => 'High-performance PCs for gaming enthusiasts.' , 'slug' => 'gaming-pc', 'name' => 'Gaming PC', 'image' => 'gamingpc.jpg'],
            ['id' => 2, 'slogan' => 'Enjoy the ultimate console gaming experience.' , 'slug' => 'playstation-5', 'name' => 'PlayStation 5', 'image' => 'ps5.jpg'],
            ['id' => 3, 'slogan' => 'Perfect your sills on a premium snooker table.' , 'slug' => 'snooker-table-a', 'name' => 'Snooker A', 'image' => 'snooker.png'],
            ['id' => 4, 'slogan' => 'Perfect your sills on a premium snooker table.' , 'slug' => 'snooker-table-b', 'name' => 'Snooker B', 'image' => 'snookerB.jpg'],
            ['id' => 5, 'slogan' => 'Feel the andrenaline of high-speed racing.' , 'slug' => 'racing-simulator', 'name' => 'Racing Simulator', 'image' => 'racing.jpg'],
        ];
        return view('user.booking', compact('facilities'));
    }



    public function history()
    {
        // return view('user.history');

        $userId = Auth::id();
        $carts = Cart::with(['user', 'time', 'facility', 'seat'])->where('user_id', $userId )->get();
        return view('user.history', compact('carts'));
    }

    public function datetime(Request $request) {
        $facilityId = $request->query('facility_id');
        $seatsCount = Seat::where('facility_id', $facilityId)->get();
        $timeRanges = Time::all();
        $time = '';
       //dd(compact('seatsCount', 'timeRanges', 'facilityId'));
        return view('user.date-time', compact('seatsCount', 'timeRanges', 'facilityId'));
        //dd(compact('seatsCount', 'timeRanges', 'facilityId', 'time'));
    }

    public function gamingpc(Request $request)
    {
        $facilityId = $request->query('facility_id');
        // $validated = $request->validate([
        //     'date' => 'required|date',
        //     'time' => 'required|string',
        // ]);

        // $selectedDate = $validated['date'];
        // $selectedTime = $validated['time'];


        $validated = $request->validate([
            'date' => 'required|date_format:d/m/Y',
            'time' => 'required|string',
        ]);

        $selectedDate = $validated['date'];
        $selectedTime = $validated['time'];

        // $selectedDate = $validated['date'];

        try {
            $dateObject = Carbon::createFromFormat('d/m/Y', $selectedDate);
            $formattedDate = $dateObject->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['date' => 'Invalid date format']);
        }

        $seatsCount = Seat::where('facility_id', $facilityId)->get();
        $timeRanges = Time::all();
        $timeRecord = Time::where('timerange', $selectedTime)->first();

        if (!$timeRecord) {
            return redirect()->back()->withErrors(['time' => 'Invalid time selected.']);
        }

        $timeId = $timeRecord->id;
        $userId = Auth::id();

        $bookedSeats = Cart::where('date', $formattedDate)
        ->where('time_id', $timeId)
        ->where('facility_id', $facilityId)
        ->pluck('seat_id');

        $seats = Seat::all(); // Assuming you have a Seat model



        return view('user.gamingpc', compact(
            'seatsCount', 'timeRanges', 'formattedDate', 'selectedDate',
            'selectedTime', 'facilityId', 'timeId', 'userId', 'bookedSeats' , 'seats' ,
        ));

        // return view('user.gamingpc', [
        //     'seatsCount' => $seatsCount, // Available seats
        //     'bookedSeats' => $bookedSeats, // Booked seats
        //     'selectedDate' => $selectedDate,
        //     'selectedTime' => $selectedTime,
        //     'formattedDate' => $formattedDate,
        //     'timeId' => $timeId,
        //     'facilityId' => $facilityId,
        // ]);
    }


    public function gamingpcStore(Request $request)
    {



        $validated = $request->validate([
            'user_id'=> 'required',
            'date'=> 'required',
            'time_id'=> 'required',
            'facility_id'=> 'required',
            'seat_id'=> 'required',
            'price'=> 'required',
        ]);

    // Create new Booking
        Booking::create([
        'user_id'=> $validated['user_id'],
        'date'=> $validated['date'],
        'time_id'=> $validated['time_id'],
        'facility_id'=> $validated['facility_id'],
        'seat_id '=> $validated['seat_id'],
        'price'=> $validated['price'],
        ]);
        return redirect()->route('user.history')->with('success', 'Booking added successfully!');

    }

    public function StoreCart(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time_id' => 'required|exists:times,id',
            'facility_id' => 'required|exists:facilities,id',
            'seat_id' => 'required|exists:seats,id',
            'price'=>'required|numeric',
            'booking_id_succesful'=> 'required|string',

        ]);

        // Save to Cart table
        Cart::create([
            'user_id' => $validated['user_id'],
            'date' => $validated['date'],
            'time_id' => $validated['time_id'],
            'facility_id' => $validated['facility_id'],
            'seat_id' => $validated['seat_id'],
            'price' => $validated['price'],
            'booking_id_succesful' => $validated['booking_id_succesful'],
        ]);

        return redirect()->route('user.booking')->with('success', 'Cart added successfully!');
        // return redirect()->back()->with('success', 'Cart added successfully!');
    }

    public function checkout(Request $request) //sini checkout nnatang
{
    // Validate the input
    $request->validate([
        'user_id' => 'required|integer',
        'date' => 'required|date',
        'time_id' => 'required|integer',
        'facility_id' => 'required|integer',
        'seat_id' => 'required|integer',
        'price' => 'required|numeric',
    ]);

    try {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

                // Retrieve input parameters
                $facilityId = $request->input('facility_id');
                $formattedDate = $request->input('date');
                $timeId = $request->input('time_id');
                $userId = Auth::id();
                $seatId = $request->input('seat_id');
                $seat = Seat::find($seatId); // Assuming 'id' is the primary key
                if ($seat) {
                    $price = $seat->price;
                } else {
                    $price = null; // Handle case if seat is not found
                }
                $email = Auth::user()->email;

        // Prepare line items for Stripe
        $LineItems = [
            [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => 'Facility Booking',
                    ],
                    'unit_amount' => $price * 100, // Price in cents
                ],
                'quantity' => 1,
            ]
        ];


        //dd(compact('facilityId', 'formattedDate', 'timeId', 'userId','seatId', 'price'));

        // Prepare the query parameters using compact() and http_build_query
        $queryParams = http_build_query(compact('facilityId', 'formattedDate', 'timeId', 'userId','seatId', 'price'));

        // Construct success_url with session_id placeholder
        $successUrl = route('user.checkout.success') . '?' . $queryParams . "&session_id={CHECKOUT_SESSION_ID}";

        // Create Stripe Checkout session
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $LineItems,
            'customer_email' => $email,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => route('user.checkout.cancel', [], true),
        ]);

        // Redirect to the Stripe Checkout page
        return redirect($session->url);

    } catch (\Exception $e) {
        // Handle exceptions (e.g., log error, display friendly message)
        return back()->with('error', $e->getMessage());
    }
}

public function success(Request $request) //sini bila tekan grab success
{


    // Retrieve input data from the request
    $facilityId = $request->input('facilityId');
    $formattedDate = $request->input('formattedDate');
    $timeId = $request->input('timeId');
    $userId = $request->input('userId');
    $seatId = $request->input('seatId');
    $price = $request->input('price');
    $sessionId = $request->input('session_id');

    //dd(compact('facilityId', 'formattedDate', 'timeId', 'userId','seatId', 'price'));

    // Validate the input data (optional, but recommended)
    $validated = $request->validate([
        'userId' => 'required|exists:users,id',
        'facilityId' => 'required|exists:facilities,id',
        'formattedDate' => 'required|date',
        'timeId' => 'required|exists:times,id',
        'seatId' => 'required|exists:seats,id',
        'price' => 'required|numeric',
    ]);

    \Stripe\Stripe::setApiKey(config('stripe.sk'));

    try {
        // Retrieve the Stripe session using the session ID
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        if (!$session) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
        }

        Cart::create([
            'user_id' => $validated['userId'],
            'date' => $validated['formattedDate'], // You might need to format it properly depending on the date format
            'time_id' => $validated['timeId'],
            'facility_id' => $validated['facilityId'],
            'seat_id' => $validated['seatId'],
            'price' => $validated['price'],
            'booking_id_succesful' => Str::random(10),
         ]);

        // Optionally, retrieve the customer info, e.g., $session->customer
        // $customer = \Stripe\Customer::retrieve($session->customer);

        // Retrieve the carts for the user to display the booking history or success page
        $userId = Auth::id();
        $carts = Cart::with(['user', 'time', 'facility', 'seat'])->where('user_id', $userId)->get();

        // Redirect to the history or booking page with a success message
        return redirect()->route('user.history')->with('success', 'Booking successful!');

    } catch (\Exception $e) {
        // Handle exceptions (e.g., session not found or other errors)
        // return redirect()->route('user.booking')->with('error', 'Booking failed! Please try again.');
        $facilities = [
            ['id' => 1, 'slogan' => 'High-performance PCs for gaming enthusiasts.' , 'slug' => 'gaming-pc', 'name' => 'Gaming PC', 'image' => 'gamingpc.jpg'],
            ['id' => 2, 'slogan' => 'Enjoy the ultimate console gaming experience.' , 'slug' => 'playstation-5', 'name' => 'PlayStation 5', 'image' => 'ps5.jpg'],
            ['id' => 3, 'slogan' => 'Perfect your skills on a premium snooker table.' , 'slug' => 'snooker-table-a', 'name' => 'Snooker A', 'image' => 'snooker.png'],
            ['id' => 4, 'slogan' => 'Perfect your skills on a premium snooker table.' , 'slug' => 'snooker-table-b', 'name' => 'Snooker B', 'image' => 'snooker.png'],
            ['id' => 5, 'slogan' => 'Feel the adrenaline of high-speed racing.' , 'slug' => 'racing-simulator', 'name' => 'Racing Simulator', 'image' => 'racing.jpg'],
        ];
        return redirect()->route('user.booking', compact('facilities'))->with('Cancelled', 'Booking failed! Please try again.');
    }
}

public function cancel() {
    $facilities = [
        ['id' => 1, 'slogan' => 'High-performance PCs for gaming enthusiasts.' , 'slug' => 'gaming-pc', 'name' => 'Gaming PC', 'image' => 'gamingpc.jpg'],
        ['id' => 2, 'slogan' => 'Enjoy the ultimate console gaming experience.' , 'slug' => 'playstation-5', 'name' => 'PlayStation 5', 'image' => 'ps5.jpg'],
        ['id' => 3, 'slogan' => 'Perfect your skills on a premium snooker table.' , 'slug' => 'snooker-table-a', 'name' => 'Snooker A', 'image' => 'snooker.png'],
        ['id' => 4, 'slogan' => 'Perfect your skills on a premium snooker table.' , 'slug' => 'snooker-table-b', 'name' => 'Snooker B', 'image' => 'snooker.png'],
        ['id' => 5, 'slogan' => 'Feel the adrenaline of high-speed racing.' , 'slug' => 'racing-simulator', 'name' => 'Racing Simulator', 'image' => 'racing.jpg'],
    ];
   // return view('user.booking', compact('facilities'))->with('Cancelled', 'You have canceled the booking.');
   return redirect()->route('user.booking', compact('facilities'))->with('Cancelled', 'You have canceled the booking.');

}


    public function webhook(){

            // This is your Stripe CLI webhook secret for testing your endpoint locally.
            $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

            $payload = @file_get_contents('php://input');
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            $event = null;

            try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
            } catch(\UnexpectedValueException $e) {
            // Invalid payload
            // http_response_code(400);
            // exit();
            return response('', 400);

            } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            // http_response_code(400);
            // exit();

            return response('', 400);

            }

            // Handle the event
            switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
            }

            // http_response_code(200);
            return response('');


    }

}

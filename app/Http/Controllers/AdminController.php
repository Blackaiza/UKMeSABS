<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming staff are stored in the users table
use App\Models\Seat;
use App\Models\Facility;
use App\Models\Cart;
use App\Models\Time;
use App\Models\News;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

/// DASHBOARD ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function dashboard()
{
   // sleep(3);
   $news = News::all();  // This fetches all the news records

    // return view('admin.dashboard',compact('news'));
    return view('admin.dashboard', compact('news'));
}

/// MANAGE FACILITY ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function managefacility()
    {
        return view('admin.managefacility');
    }

/// MANAGE ACCOUNT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function managestaff(Request $request)
    {
        $roleFilter = $request->input('role'); // Get role filter from the request
        $query = User::whereIn('role', ['admin', 'user']); // Exclude 'admin' role

        if ($roleFilter) {
            $query->where('role', $roleFilter); // Filter by role if provided
        }

        $staffMembers = $query->paginate(10); // Paginate results (10 per page)
    return view('admin.managestaff', compact('staffMembers', 'roleFilter'));
    }

/// REPORT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function report(Request $request)
{
    // Handle the filtering for month and year
    $selectedYear = $request->get('year', now()->year); // Default to current year if not provided
    $selectedMonth = $request->get('month', now()->month); // Default to current month if not provided

    // Fetch all facilities and calculate the total bookings (with month/year filter)
    $facilities = Facility::withCount(['carts' => function($query) use ($selectedMonth, $selectedYear) {
        $query->when($selectedMonth, function ($q) use ($selectedMonth) {
            return $q->whereMonth('created_at', $selectedMonth);
        })
        ->when($selectedYear, function ($q) use ($selectedYear) {
            return $q->whereYear('created_at', $selectedYear);
        });
    }])
    ->get();

    // Fetch roles and their user counts
    $roles = User::select('role', DB::raw('count(*) as count'))
        ->groupBy('role')
        ->get();

    // Fetch cart data and group by time_id to count bookings per time slot (with month/year filter)
    $timeBookingCounts = Cart::select('time_id', DB::raw('count(*) as bookings'))
        ->when($selectedMonth, function ($query) use ($selectedMonth) {
            return $query->whereMonth('created_at', $selectedMonth);
        })
        ->when($selectedYear, function ($query) use ($selectedYear) {
            return $query->whereYear('created_at', $selectedYear);
        })
        ->groupBy('time_id')
        ->get();

    // Fetch all time ranges from the 'times' table
    $timeRanges = Time::all(); // Get all time ranges
    $timeLabels = $timeRanges->pluck('timerange', 'id'); // Map ID to timerange

    // Calculate total revenue based on selected month and year (this will be affected by filter)
    $totalRevenue = Cart::whereYear('created_at', $selectedYear)
        ->whereMonth('created_at', $selectedMonth)
        ->sum('price'); // Assuming 'price' is the column name in 'carts' table

    // Calculate overall total revenue (not affected by filters)
    $overallTotalRevenue = Cart::sum('price'); // This is for the card showing total revenue, unaffected by filter

    // Initialize arrays for each chart
    $linelabels = [];
    $linedata = [];

    $timeLabelsArray = [];
    $bookingCounts = array_fill(0, count($timeLabels), 0);

    $fourthData = [];
    $fourthLabels = [];
    $totalUsers = 0;

    // Time Chart: Populate the booking counts for each time slot
    foreach ($timeBookingCounts as $timeBooking) {
        $bookingCounts[$timeBooking->time_id - 1] = $timeBooking->bookings; // Store booking count
    }
    $timeLabelsArray = $timeLabels->values()->toArray(); // Convert labels to array

    // User Registered Count Chart: Populate role data
    foreach ($roles as $role) {
        $fourthLabels[] = $role->role;
        $fourthData[] = $role->count;
        $totalUsers += $role->count; // Add up the total user count
    }

    // Most Booked Facilities Chart: Populate facility names and booking counts
    foreach ($facilities as $facility) {
        $linelabels[] = $facility->name; // The facility name
        $linedata[] = $facility->carts_count; // The number of bookings
    }

    // Find the most popular facility (affected by filter)
    $mostPopularFacility = $facilities->sortByDesc('carts_count')->first();

    // Calculate total revenue for the most popular facility (if available)
    $mostPopularFacilityRevenue = 0;
    if ($mostPopularFacility) {
        $mostPopularFacilityRevenue = Cart::where('facility_id', $mostPopularFacility->id)
                                          ->whereYear('created_at', $selectedYear)
                                          ->whereMonth('created_at', $selectedMonth)
                                          ->sum('price');
    }

    // Fetch all distinct years for the year filter
    $years = Cart::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->pluck('year');

    // Pass the data to the view for rendering
    return view('admin.report', [
        'totalUsers' => $totalUsers,
        'facilities' => $facilities,
        'roles' => $roles,
        'linelabels' => $linelabels,
        'linedata' => $linedata,
        'timeLabels' => $timeLabelsArray,
        'bookingCounts' => $bookingCounts,
        'fourthLabels' => $fourthLabels,
        'fourthData' => $fourthData,
        'totalRevenue' => $totalRevenue, // Total revenue based on the filter
        'overallTotalRevenue' => $overallTotalRevenue, // Overall total revenue for the card
        'mostPopularFacility' => $mostPopularFacility, // Most popular facility for the card
        'mostPopularFacilityRevenue' => $mostPopularFacilityRevenue, // Revenue of the most popular facility
        'years' => $years, // Pass distinct years to the view
        'selectedYear' => $selectedYear, // Pass the selected year to the view
        'selectedMonth' => $selectedMonth, // Pass the selected month to the view
    ]);
}
/// CRUD MANAGING ACCOUNT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/// CREATE ACCOUNT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function createStaff()
    {
        return view('admin.createStaff'); // View to add new account
    }

    public function storeStaff(Request $request){
        //sleep(4);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|string|in:user,admin',
        ]);

    // Create new user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($request->password),
            //'password' => bcrypt($request->password), // Set a default password or handle password creation differently
            'role' => $validated['role'],
        ]);
        return redirect()->route('admin.managestaff')->with('success', 'Added successfully!');
    }

/// EDIT ACCOUNT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function editStaff($id)
    {
        $staff = User::findOrFail($id); // Find staff by ID
        return view('admin.editStaff', compact('staff'));
    }

/// UPDATE ACCOUNT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function updateStaff(Request $request, $id)
    {
        $staff = User::findOrFail($id); // Find staff by ID

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'role' => 'required|string|in:user,admin',
        ]);

        $staff->update($validated); // Update staff details
       // session()->flash('success', 'Account updated successfully.');
       // return redirect()->route('admin.managestaff');
       return redirect()->route('admin.managestaff')->with('staffUpdateSuccess', 'Update Account Details Successful.');
        //return redirect()->back()->with('success', 'Account updated successfully.');
    }

/// DELETE ACCOUNT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function destroyStaff($id)
    {
        $staff = User::findOrFail($id); // Find staff by ID
        $user = User::findOrFail($id); // Find user by ID
        $user->delete(); // Delete user
        $staff->delete(); // Delete staff
        return redirect()->route('admin.managestaff')->with('success', 'Delete Successful.');
    }

/// EDIT SEAT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function editSeats($id)
    {
        $seats = Seat::findOrFail($id);
        return view('admin.editSeats', compact('seats'));
    }

/// UPDATE SEAT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function updateSeats(Request $request, $id)
{
    $seats = Seat::findOrFail($id);

    $validated = $request->validate([
        'status' => 'required|in:available,maintenance', // Validate as ENUM
        'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'], // Allows up to 2 decimal places
    ]);

    $seats->update($validated); // Update seat details

    // Retrieve the facility_id from the seat or wherever applicable
    $facility_id = $seats->facility_id;

    // Redirect based on the facility_id
    switch ($facility_id) {
        case 1:
            return redirect()->route('admin.gamingpc')->with('UpdateSuccessSeats', 'Seats updated successfully.');
        case 2:
            return redirect()->route('admin.playstation5')->with('UpdateSuccessSeats', 'Seats updated successfully.');
        case 3:
            return redirect()->route('admin.snookerA')->with('UpdateSuccessSeats', 'Seats updated successfully.');
        case 4:
            return redirect()->route('admin.snookerB')->with('UpdateSuccessSeats', 'Seats updated successfully.');
        case 5:
            return redirect()->route('admin.racingSimulator')->with('UpdateSuccessSeats', 'Seats updated successfully.');
        default:
            return redirect()->back()->with('UpdateSuccessSeats', 'Seats updated successfully.');
    }
}


// public function updateSeats(Request $request, $id){

    //     $seats = Seat::findOrFail($id);

    //     $validated = $request->validate([
    //        //'name' => 'required|string|max:255',
    //        'status' => 'required|in:available,maintenance', // Validate as ENUM
    //        //'status' => 'required|booleon|unique:users,email,' . $seats->id,
    //        'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'], // Allows up to 2 decimal places
    //     ]);

    //     $seats->update($validated); // Update staff details
    //     // return redirect()->route('admin.managefacility')->with('success', 'Seats updated successfully.');
    //    // return redirect()->back()->with('UpdateSuccessSeats', 'Seats updated successfully.');
    //     return redirect()->route('admin.gamingpc')->with('UpdateSuccessSeats', 'Seats updated successfully.');
    //     //session()->flash('success', 'Facility updated successfully.');
    //     //return redirect()->route('admin.managefacility');

    // }

/// DELETE SEAT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function destroySeats($id)
    {
        $seats = Seat::findOrFail($id);
        $seats->delete();
        return redirect()->route('admin.managefacility')->with('success', 'Seats deleted successfully.');
    }

/// MANAGE FACILITIES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function gamingpc()
    {
        $seatsCount = Seat::whereIn('facility_id', ['1'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('admin.gamingpc', compact('seatsCount'));
        // return view('admin.gamingpc');
    }

    public function playstation5()
    {
        $seatsCount = Seat::whereIn('facility_id', ['2'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('admin.playstation5', compact('seatsCount'));
        // return view('admin.playstation5');
    }

    public function snookerA()
    {
        $seatsCount = Seat::whereIn('facility_id', ['3'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('admin.snookerA', compact('seatsCount'));
        // return view('admin.snookerA');
    }

    public function snookerB()
    {
        $seatsCount = Seat::whereIn('facility_id', ['4'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('admin.snookerB', compact('seatsCount'));
        // return view('admin.snookerB');
    }

    public function racingSimulator()
    {
        $seatsCount = Seat::whereIn('facility_id', ['5'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('admin.racingSimulator', compact('seatsCount'));
       // return view('admin.racingSimulator');
    }

    /// MANAGE NEWS ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // View all news
    public function manageNews()
    {
        $news = News::all();
        return view('admin.manageNews', compact('news'));
    }

    // Show form to create a new news
    public function createNews()
    {
        return view('admin.createNews');
    }

    // Store new news
    public function storeNews(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validate picture upload
        ]);

        $newspicture=null;

        // Handle picture upload if a file is provided
        if ($request->hasFile('picture')) {
            // Store the picture in the 'public/news' folder
            $newspicture = $request->file('picture')->store('news', 'public');
        }

        // Create a new news record
        $news = News::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'picture' => $newspicture,  // Save the picture path
        ]);

        // Trigger any necessary events (optional, if required for your app)
        event(new Registered($news));

        // Redirect back to the manage news page with a success message
        return redirect()->route('admin.manageNews')->with('NewsCreate', 'News added successfully!');
    }

    // Show form to edit news
    public function editNews($id)
    {
        $news = News::findOrFail($id);
        return view('admin.editNews', compact('news'));
    }

    // Update news
    public function updateNews(Request $request, $id)
    {
        // Retrieve the existing news record
        $news = News::findOrFail($id);

        // Validate the input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare data for updating
        $newsData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
        ];

        // Handle the picture file upload only if a new picture is provided
        if ($request->hasFile('picture')) {
            // Delete the old picture if it exists
            if (!empty($news->picture)) {
                Storage::delete($news->picture); // Delete from storage
            }

            // Store the new picture and add its path to the news data
            $newspicture = Storage::disk('public')->put('/', $request->file('picture'));
            $newsData['picture'] = $newspicture;
        }

        // Update the news record with the new data
        $news->update($newsData);

        // Redirect back to the manage news page with a success message
        return redirect()->route('admin.manageNews')->with('NewsUpdate', 'News updated successfully!');
    }


    // Delete news
    public function destroyNews($id)
    {
        $news = News::findOrFail($id);

        // Delete picture if exists
        if ($news->picture) {
            Storage::delete($news->picture);
        }

        $news->delete();

        return redirect()->route('admin.manageNews')->with('NewsDelete', 'News deleted successfully!');
    }



}

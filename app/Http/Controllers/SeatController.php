<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class SeatController extends Controller
{
    // Other methods...

    // Method to manage seats for a specific facility
    public function manageSeats($facility)
    {
        // Fetch seats for the selected facility
        $seats = Seat::where('facility_id', $facility)->get();

        // Pass the seats and the facility name to the view
        return view('admin.manage-seats', compact('seats', 'facility'));
    }

    // // Update seat status method
    // public function updateSeatStatus(Request $request, $seatId)
    // {
    //     // Find the seat by ID
    //     $seat = Seat::findOrFail($seatId);

    //     // Update the status
    //     $seat->status = $request->status;  // Assume the 'status' is passed via a form or AJAX request

    //     // Save the updated seat status
    //     $seat->save();

    //     return back()->with('success', 'Seat status updated successfully!');
    // }

    public function updateSeats(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'seat_numbers' => 'required|array', // Ensure an array of seat numbers is provided
        'price' => 'required|numeric|min:0', // Validate the price
        'status' => 'required|boolean', // Validate the status
    ]);

    // Iterate through each seat and update it
    foreach ($validated['seat_numbers'] as $seatNumber) {
        $seat = Seat::where('seat_number', $seatNumber)->first();

        if ($seat) {
            $seat->price = $validated['price'];
            $seat->status = $validated['status'];
            $seat->save();
        }
    }

    return redirect()->back()->with('success', 'Seats updated successfully!');
}

}

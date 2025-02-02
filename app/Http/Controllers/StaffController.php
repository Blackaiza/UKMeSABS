<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming staff are stored in the users table
use App\Models\Seat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function dashboard()
    {
        return view('staff.dashboard');
    }

    public function managefacility()
    {
        return view('staff.managefacility');
    }

    public function managestaff()
    {
        $staffMembers = User::whereIn('role', ['user','staff'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('staff.managestaff', compact('staffMembers'));
    }

    public function report()
    {
        return view('staff.report');
    }

///EDIT SEAT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function editSeats($id)
    {
        $seats = Seat::findOrFail($id);
        return view('staff.editSeats', compact('seats'));
    }

///UPDATE SEAT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function updateSeats(Request $request, $id){

        $seats = Seat::findOrFail($id);

        $validated = $request->validate([
           //'name' => 'required|string|max:255',
           'status' => 'required|in:available,maintenance', // Validate as ENUM
           //'status' => 'required|booleon|unique:users,email,' . $seats->id,
           'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'], // Allows up to 2 decimal places
        ]);

        $seats->update($validated); // Update staff details
        // return redirect()->route('admin.managefacility')->with('success', 'Seats updated successfully.');
        return redirect()->back()->with('success', 'Seats updated successfully.');

    }

///DELETE SEAT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function destroySeats($id)
    {
        $seats = Seat::findOrFail($id);
        $seats->delete();
        return redirect()->route('staff.managefacility')->with('success', 'Seats deleted successfully.');
    }

///MANAGE FACILITIES////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function gamingpc()
    {
        $seatsCount = Seat::whereIn('facility_id', ['1'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('staff.gamingpc', compact('seatsCount'));
        // return view('admin.gamingpc');
    }

    public function playstation5()
    {
        $seatsCount = Seat::whereIn('facility_id', ['2'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('staff.playstation5', compact('seatsCount'));
        // return view('admin.playstation5');
    }

    public function snookerA()
    {
        $seatsCount = Seat::whereIn('facility_id', ['3'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('staff.snookerA', compact('seatsCount'));
        // return view('admin.snookerA');
    }

    public function snookerB()
    {
        $seatsCount = Seat::whereIn('facility_id', ['4'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('staff.snookerB', compact('seatsCount'));
        // return view('admin.snookerB');
    }

    public function racingSimulator()
    {
        $seatsCount = Seat::whereIn('facility_id', ['5'])->paginate(10); // Fetch staff with role 'staff' where('role', 'staff')
        return view('staff.racingSimulator', compact('seatsCount'));
       // return view('admin.racingSimulator');
    }

}

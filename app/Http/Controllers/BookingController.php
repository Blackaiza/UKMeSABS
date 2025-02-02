<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming staff are stored in the users table
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function showGamingPC()
    {
        return view('user.gamingpc');
    }

    public function showDateTime(Request $request)
    {
        // Pass selected facility ID to the view
        return view('user.date-time', ['facility' => $request->facility]);
    }

    public function showSeats(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'facility' => 'required|string',
            'datetime' => 'required|date',
        ]);


        // Determine the Blade file to render based on the facility
        $facility = $request->facility;
        $datetime = $request->datetime;

        // Map facility to corresponding Blade views
        $viewMap = [
            'gaming-pc' => 'user.gamingpc',
            'playstation-5' => 'user.playstation5',
            'racing-simulator' => 'user.racingSimulator',
            'snooker-table-a' => 'user.snookerA',
            'snooker-table-b' => 'user.snookerB'
            // Add more mappings as needed
        ];

        // Check if the facility exists in the mapping
        if (!array_key_exists($facility, $viewMap)) {
            abort(404, 'Facility not found.');
        }

        // Return the appropriate view
        return view($viewMap[$facility], [
            'datetime' => $datetime,
            'facility' => $facility,
        ]);
    }

}

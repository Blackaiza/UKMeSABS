<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;

class FacilityController extends Controller
{
    // Display a listing of the facilities.
    public function index()
    {
        $facilities = Facility::paginate(10); // Fetch facilities with pagination
        return view('admin.managefacility', compact('facilities'));
    }

    // Show the form for creating a new facility.
    public function create()
    {
        return view('admin.createFacility'); // View to add a new facility
    }

    // Store a newly created facility in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name',
        ]);

        Facility::create($validated); // Save the new facility

        return redirect()->route('admin.managefacility')->with('success', 'Facility added successfully!');
    }

    // Show the form for editing the specified facility.
    public function edit($id)
    {
        $facility = Facility::findOrFail($id); // Find facility by ID
        return view('admin.editFacility', compact('facility'));
    }

    // Update the specified facility in storage.
    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id); // Find facility by ID

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name,' . $facility->id,
        ]);

        $facility->update($validated); // Update the facility details

        return redirect()->route('admin.managefacility')->with('success', 'Facility updated successfully.');
    }

    // Remove the specified facility from storage.
    public function destroy($id)
    {
        $facility = Facility::findOrFail($id); // Find facility by ID
        $facility->delete(); // Delete the facility

        return redirect()->route('admin.managefacility')->with('success', 'Facility deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Higherup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HigherupController extends Controller
{
    public function index()
    {
        $higherups = Higherup::orderBy('ranking')->get();
        return view('higherups.index', compact('higherups'));
    }

    public function create()
    {
        return view('higherups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|in:Yang Dipertua,Naib Dipertua I,Naib Dipertua II,Naib Dipertua III,Setiausaha,Timbalan Setiausaha,Bendahari,Timbalan Bendahari',
            'picture' => 'required|image|max:2048',
            'ranking' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('higherups', 'public');
        }

        Higherup::create($validated);

        return redirect()->route('higherups.index')->with('success', 'Higher-up created successfully.');
    }

    public function edit(Higherup $higherup)
    {
        return view('higherups.edit', compact('higherup'));
    }

    public function update(Request $request, Higherup $higherup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|in:Yang Dipertua,Naib Dipertua I,Naib Dipertua II,Naib Dipertua III,Setiausaha,Timbalan Setiausaha,Bendahari,Timbalan Bendahari',
            'picture' => 'nullable|image|max:2048',
            'ranking' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('picture')) {
            Storage::delete('public/' . $higherup->picture);
            $validated['picture'] = $request->file('picture')->store('higherups', 'public');
        }

        $higherup->update($validated);

        return redirect()->route('higherups.index')->with('success', 'Higher-up updated successfully.');
    }

    public function destroy(Higherup $higherup)
    {
        Storage::delete('public/' . $higherup->picture);
        $higherup->delete();

        return redirect()->route('higherups.index')->with('success', 'Higher-up deleted successfully.');
    }
}

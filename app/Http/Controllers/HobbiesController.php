<?php

namespace App\Http\Controllers;

use App\Models\Hobbies;
use Illuminate\Http\Request;

class HobbiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hobbies = Hobbies::all();
        return view('hobbies.index', compact('hobbies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hobbies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Hobbies::create($request->all());

        return redirect()->route('hobbies.index')
                        ->with('success', 'Hobby created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hobbies $hobbies)
    {
        return view('hobbies.show', compact('hobbies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hobbies $hobbies)
    {
        return view('hobbies.edit', compact('hobbies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hobbies $hobbies)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hobbies->update($request->all());

        return redirect()->route('hobbies.index')
                        ->with('success', 'Hobby updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hobbies $hobbies)
    {
        $hobbies->delete();

        return redirect()->route('hobbies.index')
                        ->with('success', 'Hobby deleted successfully.');
    }
}

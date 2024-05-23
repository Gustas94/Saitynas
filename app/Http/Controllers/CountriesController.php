<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Countries::all();
        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Countries::create($request->all());

        return redirect()->route('countries.index')
                        ->with('success', 'Country created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Countries $countries)
    {
        return view('countries.show', compact('countries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Countries $countries)
    {
        return view('countries.edit', compact('countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Countries $countries)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $countries->update($request->all());

        return redirect()->route('countries.index')
                        ->with('success', 'Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Countries $countries)
    {
        $countries->delete();

        return redirect()->route('countries.index')
                        ->with('success', 'Country deleted successfully.');
    }
}

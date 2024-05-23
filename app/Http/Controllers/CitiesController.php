<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = Cities::with('country')->get();
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Countries::all();
        return view('cities.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        Cities::create($request->all());

        return redirect()->route('cities.index')
                        ->with('success', 'City created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cities $cities)
    {
        return view('cities.show', compact('cities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cities $cities)
    {
        $countries = Countries::all();
        return view('cities.edit', compact('cities', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cities $cities)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        $cities->update($request->all());

        return redirect()->route('cities.index')
                        ->with('success', 'City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cities $cities)
    {
        $cities->delete();

        return redirect()->route('cities.index')
                        ->with('success', 'City deleted successfully.');
    }
}

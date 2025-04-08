<?php

namespace App\Http\Controllers\sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::all();
        return view('sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'customer_id' => 'required|exists:customers,customer_id',
        'customer_name' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'closing_date' => 'required|date',
        'status' => 'required|string|max:255',
        ]);

        Site::create($request->all());
        return redirect()->route('sites.index')->with('success', 'Site created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'customer_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'closing_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $site->update($request->all());
        return redirect()->route('sites.index')->with('success', 'Site updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->route('sites.index')->with('success', 'Site deleted successfully');
    }
}

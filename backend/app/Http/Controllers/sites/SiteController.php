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
        $customers = \App\Models\Customer::select('customer_id', 'customer_name')->get();
        return view('sites.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'closing_date' => 'required|in:5,10,15,20,25,99',
            'status' => 'required|string|max:255',
        ]);

        // Lấy customer_name từ customer_id
        $customer = \App\Models\Customer::find($request->customer_id);
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found');
        }

        $data = $request->all();
        $data['customer_name'] = $customer->customer_name;

        Site::create($data);
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
        $customers = \App\Models\Customer::select('customer_id', 'customer_name')->get();
        return view('sites.edit', compact('site', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'closing_date' => 'required|in:5,10,15,20,25,99',
            'status' => 'required|string|max:255',
        ]);

        // Lấy customer_name từ customer_id
        $customer = \App\Models\Customer::find($request->customer_id);
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found');
        }

        $data = $request->all();
        $data['customer_name'] = $customer->customer_name;

        $site->update($data);
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

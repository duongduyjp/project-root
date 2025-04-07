<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $query = Customer::query();

        // Search by customer_id
        if (request()->has('customer_id') && !empty(request('customer_id'))) {
            $query->where('customer_id', '=', request('customer_id'));
        }

        // Search by customer_name
        if (request()->has('customer_name') && !empty(request('customer_name'))) {
            $query->where('customer_name', 'like', '%' . request('customer_name') . '%');
        }

        $customers = $query->get();

        return view('master.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('master.customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|unique:customers',
            'customer_name' => 'required',
            'address' => 'required',
            'customer_type' => 'required|in:1,2',
            'closing_date' => 'required|in:0,10,15,20,25,30',
        ]);

        Customer::create($validated);

        return redirect()->route('master.customer.index')
            ->with('success', __('messages.customer.create_success'));
    }

    public function edit(Customer $customer)
    {
        return view('master.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'customer_name' => 'required',
            'address' => 'required',
            'customer_type' => 'required|in:1,2',
            'closing_date' => 'required|in:0,10,15,20,25,30',
        ]);

        $customer->update($validated);

        return redirect()->route('master.customer.index')
            ->with('success', __('messages.customer.update_success'));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('master.customer.index')
            ->with('success', __('messages.customer.delete_success'));
    }
} 
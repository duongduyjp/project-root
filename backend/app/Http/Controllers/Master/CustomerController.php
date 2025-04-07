<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $query = Customer::query();

        // Search by customer_id (exact match)
        if (request()->has('customer_id') && !empty(request('customer_id'))) {
            $query->where('customer_id', request('customer_id'));
        }

        // Search by customer_name
        if (request()->has('customer_name') && !empty(request('customer_name'))) {
            $query->where('customer_name', 'like', '%' . request('customer_name') . '%');
        }

        $customers = $query->paginate(10);
        return view('master.customer.index', compact('customers'));
    }

    public function create()
    {
        $nextCustomerId = Customer::max('customer_id') + 1;
        return view('master.customer.create', compact('nextCustomerId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|max:255',
            'address' => 'required',
            'customer_type' => 'required|in:supplier,customer',
            'closing_date' => 'required|in:5,10,15,20,25,99',
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
            'customer_name' => 'required|max:255',
            'address' => 'required',
            'customer_type' => 'required|in:supplier,customer',
            'closing_date' => 'required|in:5,10,15,20,25,99',
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
<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Yard;
use Illuminate\Http\Request;

class YardController extends Controller
{
    public function index()
    {
        $query = Yard::query();

        // Search by yard_code
        if (request()->has('yard_code') && !empty(request('yard_code'))) {
            $query->where('yard_code', '=', request('yard_code'));
        }

        // Search by yard_name
        if (request()->has('yard_name') && !empty(request('yard_name'))) {
            $query->where('yard_name', 'like', '%' . request('yard_name') . '%');
        }

        $yards = $query->get();
        return view('master.yard.index', compact('yards'));
    }

    public function create()
    {
        return view('master.yard.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'yard_code' => 'required|unique:yards',
            'yard_name' => 'required',
            'yard_phone' => 'required',
            'yard_address' => 'required',
        ]);

        Yard::create($request->all());

        return redirect()->route('master.yard.index')
            ->with('success', __('messages.yard.created'));
    }

    public function edit(Yard $yard)
    {
        return view('master.yard.edit', compact('yard'));
    }

    public function update(Request $request, Yard $yard)
    {
        $request->validate([
            'yard_code' => 'required|unique:yards,yard_code,' . $yard->yard_code . ',yard_code',
            'yard_name' => 'required',
            'yard_phone' => 'required',
            'yard_address' => 'required',
        ]);

        $yard->update($request->all());

        return redirect()->route('master.yard.index')
            ->with('success', __('messages.yard.updated'));
    }

    public function destroy(Yard $yard)
    {
        $yard->delete();

        return redirect()->route('master.yard.index')
            ->with('success', __('messages.yard.deleted'));
    }
}

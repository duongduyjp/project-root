<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Shelf;
use App\Models\Yard;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    /**
     * Hiển thị danh sách các shelf
     */
    public function index()
    {
        $query = Shelf::query()->with('yard');

        // Tìm kiếm theo search (shelf_id hoặc shelf_name)
        if (request()->has('search') && !empty(request('search'))) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('shelf_id', 'like', '%' . $search . '%')
                    ->orWhere('shelf_name', 'like', '%' . $search . '%');
            });
        }

        // Tìm kiếm theo yard_code
        if (request()->has('yard_code') && !empty(request('yard_code'))) {
            $query->where('yard_code', request('yard_code'));
        }

        $shelves = $query->paginate(10);
        $yards = Yard::select('yard_code', 'yard_name')->get();
        return view('master.shelf.index', compact('shelves', 'yards'));
    }

    /**
     * Hiển thị form tạo shelf mới
     */
    public function create()
    {
        $yards = Yard::select('yard_code', 'yard_name')->get();
        return view('master.shelf.create', compact('yards'));
    }

    /**
     * Lưu shelf mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'shelf_id' => 'required|string|max:255|unique:shelves',
            'shelf_name' => 'required|string|max:255',
            'yard_code' => 'required|exists:yards,yard_code'
        ]);

        Shelf::create([
            'shelf_id' => $request->shelf_id,
            'shelf_name' => $request->shelf_name,
            'yard_code' => $request->yard_code
        ]);

        return redirect()->route('master.shelf.index')
            ->with('success', __('messages.shelf.create_success'));
    }

    /**
     * Hiển thị thông tin chi tiết của một shelf
     */
    public function show($id)
    {
        $shelf = Shelf::with('yard')->findOrFail($id);
        return view('master.shelf.show', compact('shelf'));
    }

    /**
     * Hiển thị form chỉnh sửa shelf
     */
    public function edit($id)
    {
        $shelf = Shelf::findOrFail($id);
        $yards = Yard::select('yard_code', 'yard_name')->get();
        return view('master.shelf.edit', compact('shelf', 'yards'));
    }

    /**
     * Cập nhật shelf trong database
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'shelf_name' => 'required|string|max:255',
            'yard_code' => 'required|exists:yards,yard_code'
        ]);

        $shelf = Shelf::findOrFail($id);
        $shelf->update([
            'shelf_name' => $request->shelf_name,
            'yard_code' => $request->yard_code
        ]);

        return redirect()->route('master.shelf.index')
            ->with('success', __('messages.shelf.update_success'));
    }

    /**
     * Xóa shelf khỏi database
     */
    public function destroy($id)
    {
        $shelf = Shelf::findOrFail($id);
        $shelf->delete();

        return redirect()->route('master.shelf.index')
            ->with('success', __('messages.shelf.delete_success'));
    }
}

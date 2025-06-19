<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller {
    public function index() {
        $topics = Topic::all();
        return view('topics.index', compact('topics'));
    }

    public function create() {
        return view('topics.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:topics,name'
        ]);
        
        Topic::create($request->only('name'));
        return redirect()->route('topics.index')->with('success', 'Chủ đề đã được tạo thành công!');
    }

    public function show(Topic $topic) {
        return view('topics.show', compact('topic'));
    }

    public function edit(Topic $topic) {
        return view('topics.edit', compact('topic'));
    }

    public function update(Request $request, Topic $topic) {
        $request->validate([
            'name' => 'required|string|max:255|unique:topics,name,' . $topic->id
        ]);
        
        $topic->update($request->only('name'));
        return redirect()->route('topics.index')->with('success', 'Chủ đề đã được cập nhật thành công!');
    }

    public function destroy(Topic $topic) {
        $topic->delete();
        return redirect()->route('topics.index')->with('success', 'Chủ đề đã được xóa thành công!');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;

class VocabularyController extends Controller {
    public function index() {
        $vocabularies = Vocabulary::with('topic')->orderBy('topic_id')->orderBy('word')->get();
        return view('vocabularies.index', compact('vocabularies'));
    }

    public function create(Request $request) {
        $topics = Topic::all();
        $selectedTopicId = $request->input('topic_id');
        return view('vocabularies.create', compact('topics', 'selectedTopicId'));
    }

    public function store(Request $request) {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'word' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sentences' => 'nullable|string',
        ]);

        $data = $request->only(['topic_id', 'word', 'sentences']);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vocabularies', 'public');
            $data['image_path'] = $imagePath;
        }

        Vocabulary::create($data);
        return redirect()->route('vocabularies.index')->with('success', 'Từ vựng đã được thêm thành công!');
    }

    public function show(Vocabulary $vocabulary) {
        return view('vocabularies.show', compact('vocabulary'));
    }

    public function edit(Vocabulary $vocabulary) {
        $topics = Topic::all();
        return view('vocabularies.edit', compact('vocabulary', 'topics'));
    }

    public function update(Request $request, Vocabulary $vocabulary) {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'word' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sentences' => 'nullable|string',
        ]);

        $data = $request->only(['topic_id', 'word', 'sentences']);
        
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($vocabulary->image_path) {
                Storage::disk('public')->delete($vocabulary->image_path);
            }
            $imagePath = $request->file('image')->store('vocabularies', 'public');
            $data['image_path'] = $imagePath;
        }

        $vocabulary->update($data);
        return redirect()->route('vocabularies.index')->with('success', 'Từ vựng đã được cập nhật thành công!');
    }

    public function destroy(Vocabulary $vocabulary) {
        // Xóa ảnh nếu có
        if ($vocabulary->image_path) {
            Storage::disk('public')->delete($vocabulary->image_path);
        }
        
        $vocabulary->delete();
        return redirect()->route('vocabularies.index')->with('success', 'Từ vựng đã được xóa thành công!');
    }

    public function practice($id) {
        $vocabulary = Vocabulary::findOrFail($id);
        $prev = Vocabulary::where('topic_id', $vocabulary->topic_id)->where('id', '<', $id)->orderBy('id', 'desc')->first();
        $next = Vocabulary::where('topic_id', $vocabulary->topic_id)->where('id', '>', $id)->orderBy('id')->first();
        return view('vocabularies.practice', compact('vocabulary', 'prev', 'next'));
    }

    public function byTopic($topicId) {
        $topic = Topic::findOrFail($topicId);
        $vocabularies = Vocabulary::where('topic_id', $topicId)->orderBy('word')->get();
        return view('vocabularies.by-topic', compact('topic', 'vocabularies'));
    }

    public function import(Request $request) {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $topicId = $request->input('topic_id');
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $rowCount = 0;
        $imported = 0;
        $errors = [];

        // Bỏ qua dòng tiêu đề nếu có
        $firstLine = trim(fgets($handle));
        if (strtolower($firstLine) == 'table 1' || strtolower($firstLine) == 'untitled') {
            // Do nothing, just skip the line
        } else {
            // Rewind if it's not a header
            rewind($handle);
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowCount++;
            // Bỏ qua dòng trống hoặc thiếu cột
            if (count($data) < 1 || empty($data[0])) {
                $errors[] = "Dòng $rowCount thiếu dữ liệu.";
                continue;
            }

            $word = trim($data[0]);
            $sentences = isset($data[1]) ? trim($data[1]) : null;

            // Loại bỏ tất cả các ký tự không phải chữ cái, số, hoặc khoảng trắng từ word
            $word = preg_replace('/[^\p{L}\p{N}\s]/u', '', $word);
            $word = trim($word); // Trim lại sau khi loại bỏ ký tự

            // Bỏ qua dòng trống sau khi làm sạch
            if (empty($word)) {
                $errors[] = "Dòng $rowCount trống sau khi làm sạch.";
                continue;
            }

            // Không thêm trùng từ trong cùng topic
            if (\App\Models\Vocabulary::where('topic_id', $topicId)->where('word', $word)->exists()) {
                $errors[] = "Từ '$word' đã tồn tại ở dòng $rowCount.";
                continue;
            }
            \App\Models\Vocabulary::create([
                'topic_id' => $topicId,
                'word' => $word,
                'sentences' => $sentences,
            ]);
            $imported++;
        }
        fclose($handle);
        $msg = "Đã import $imported từ vựng thành công.";
        if ($errors) {
            $msg .= "\nMột số dòng bị bỏ qua:\n" . implode("\n", $errors);
        }
        return redirect()->route('topics.vocabularies', $topicId)->with('success', $msg);
    }
}

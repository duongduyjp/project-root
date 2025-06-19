<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;

class MatchGameController extends Controller
{
    public function index()
    {
        $topics = \App\Models\Topic::withCount(['vocabularies' => function($q){ $q->whereNotNull('image_path'); }])->get();
        return view('match-game.index', compact('topics'));
    }

    public function play(Request $request)
    {
        $topicId = $request->input('topic_id');
        if ($topicId) {
            $vocabularies = Vocabulary::where('topic_id', $topicId)->whereNotNull('image_path')->inRandomOrder()->get();
            $words = $vocabularies->pluck('word')->shuffle();
            return view('match-game.play', compact('vocabularies', 'words', 'topicId'));
        } else {
            // Nếu không có topic_id thì chuyển về trang chọn chủ đề
            return redirect()->route('match-game.index');
        }
    }

    public function submit(Request $request)
    {
        $answers = $request->input('answers', []); // ['vocab_id' => 'word']
        $correct = 0;
        foreach ($answers as $vocabId => $word) {
            $vocab = Vocabulary::find($vocabId);
            if ($vocab && $vocab->word === $word) {
                $correct++;
            }
        }
        return response()->json(['correct' => $correct, 'total' => count($answers)]);
    }
} 
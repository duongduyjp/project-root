<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Vocabulary;

class MagicBoxGameController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('vocabularies')->get();
        return view('magic-box.index', compact('topics'));
    }

    public function play(Request $request)
    {
        $topicId = $request->input('topic_id');
        $topic = Topic::findOrFail($topicId);
        $vocabularies = Vocabulary::where('topic_id', $topicId)->inRandomOrder()->get();
        return view('magic-box.play', compact('topic', 'vocabularies'));
    }
} 
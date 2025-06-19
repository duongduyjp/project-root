<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use App\Models\Topic;
use Illuminate\Support\Facades\Session;

class ListenGameController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('vocabularies')->get();
        return view('listen-games.index', compact('topics'));
    }

    public function start(Request $request)
    {
        $topicId = $request->input('topic_id');
        $topic = Topic::findOrFail($topicId);
        
        // Lấy tất cả từ vựng trong chủ đề
        $vocabularies = Vocabulary::where('topic_id', $topicId)
            ->inRandomOrder()
            ->take(10) // Chơi 10 từ
            ->get();

        if ($vocabularies->isEmpty()) {
            return redirect()->back()->with('error', 'Chủ đề này chưa có từ vựng nào!');
        }

        // Khởi tạo game session
        Session::put('listen_game_data', [
            'topic_id' => $topicId,
            'topic_name' => $topic->name,
            'vocabularies' => $vocabularies->toArray(),
            'current_word_index' => 0,
            'score' => 0,
            'total_attempts' => 0,
            'correct_attempts' => 0,
            'game_started_at' => now()
        ]);

        return redirect()->route('listen-games.play');
    }

    public function play()
    {
        $gameData = Session::get('listen_game_data');
        
        if (!$gameData) {
            return redirect()->route('listen-games.index');
        }

        $currentWord = $gameData['vocabularies'][$gameData['current_word_index']];
        
        // Tạo 4 lựa chọn: 1 đúng + 3 sai
        $choices = $this->generateChoices($currentWord['word'], $gameData['vocabularies']);
        
        return view('listen-games.play', compact('currentWord', 'gameData', 'choices'));
    }

    public function guess(Request $request)
    {
        $gameData = Session::get('listen_game_data');
        
        if (!$gameData) {
            return redirect()->route('listen-games.index');
        }

        $guess = strtolower(trim($request->input('guess')));
        $currentWord = $gameData['vocabularies'][$gameData['current_word_index']];
        $correctWord = strtolower($currentWord['word']);
        
        $gameData['total_attempts']++;
        
        if ($guess === $correctWord) {
            $gameData['correct_attempts']++;
            $score = $this->calculateScore($gameData['total_attempts']);
            $gameData['score'] += $score;
            
            // Chuyển sang từ tiếp theo
            $gameData['current_word_index']++;
            $gameData['total_attempts'] = 0;
            
            Session::put('listen_game_data', $gameData);
            
            if ($gameData['current_word_index'] >= count($gameData['vocabularies'])) {
                // Kết thúc game
                return redirect()->route('listen-games.result');
            } else {
                // Chọn câu khích lệ ngẫu nhiên
                $praiseMessage = $this->getRandomPraiseMessage();
                return redirect()->route('listen-games.play')
                    ->with('success', 'Chính xác! +' . $score . ' điểm')
                    ->with('praise', true)
                    ->with('praise_message', $praiseMessage);
            }
        } else {
            Session::put('listen_game_data', $gameData);
            return redirect()->route('listen-games.play')->with('error', 'Sai rồi! Hãy thử lại.');
        }
    }

    public function result()
    {
        $gameData = Session::get('listen_game_data');
        
        if (!$gameData) {
            return redirect()->route('listen-games.index');
        }

        $totalWords = count($gameData['vocabularies']);
        $correctWords = $gameData['correct_attempts'];
        $accuracy = $totalWords > 0 ? round(($correctWords / $totalWords) * 100, 1) : 0;
        
        // Xóa session game
        Session::forget('listen_game_data');
        
        return view('listen-games.result', compact('gameData', 'totalWords', 'correctWords', 'accuracy'));
    }

    public function startAgain(Request $request)
    {
        $topicId = $request->input('topic_id');
        if (!$topicId) {
            return redirect()->route('listen-games.index');
        }
        
        $topic = Topic::findOrFail($topicId);
        
        // Lấy tất cả từ vựng trong chủ đề
        $vocabularies = Vocabulary::where('topic_id', $topicId)
            ->inRandomOrder()
            ->take(10) // Chơi 10 từ
            ->get();

        if ($vocabularies->isEmpty()) {
            return redirect()->back()->with('error', 'Chủ đề này chưa có từ vựng nào!');
        }

        // Khởi tạo game session
        Session::put('listen_game_data', [
            'topic_id' => $topicId,
            'topic_name' => $topic->name,
            'vocabularies' => $vocabularies->toArray(),
            'current_word_index' => 0,
            'score' => 0,
            'total_attempts' => 0,
            'correct_attempts' => 0,
            'game_started_at' => now()
        ]);

        return redirect()->route('listen-games.play');
    }

    private function generateChoices($correctWord, $allVocabularies)
    {
        $choices = [$correctWord];
        
        // Lấy tất cả từ khác trong cùng chủ đề để làm lựa chọn sai
        $otherWords = [];
        foreach ($allVocabularies as $vocab) {
            if (strtolower($vocab['word']) !== strtolower($correctWord)) {
                $otherWords[] = $vocab['word'];
            }
        }
        
        // Nếu không đủ từ khác, thêm một số từ phổ biến
        $commonWords = ['cat', 'dog', 'house', 'car', 'tree', 'book', 'ball', 'sun', 'moon', 'star', 'flower', 'bird', 'fish', 'apple', 'banana', 'orange', 'water', 'milk', 'bread', 'rice'];
        
        while (count($choices) < 4) {
            if (!empty($otherWords)) {
                $randomWord = $otherWords[array_rand($otherWords)];
                if (!in_array(strtolower($randomWord), array_map('strtolower', $choices))) {
                    $choices[] = $randomWord;
                }
            } else {
                $randomWord = $commonWords[array_rand($commonWords)];
                if (!in_array(strtolower($randomWord), array_map('strtolower', $choices))) {
                    $choices[] = $randomWord;
                }
            }
        }
        
        // Xáo trộn thứ tự các lựa chọn
        shuffle($choices);
        
        return $choices;
    }

    private function calculateScore($attempts)
    {
        // Điểm giảm dần theo số lần đoán
        $baseScore = 100;
        $penalty = ($attempts - 1) * 20;
        return max(10, $baseScore - $penalty);
    }

    private function getRandomPraiseMessage()
    {
        $praiseMessages = config('praise_messages.praise_messages');
        return $praiseMessages[array_rand($praiseMessages)];
    }
} 
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ListenGameController;
use App\Http\Controllers\MatchGameController;
use App\Http\Controllers\MagicBoxGameController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('home');
});

Route::resource('topics', TopicController::class);
Route::resource('vocabularies', VocabularyController::class);
Route::get('vocabularies/{id}/practice', [VocabularyController::class, 'practice'])->name('vocabularies.practice');
Route::get('topics/{topicId}/vocabularies', [VocabularyController::class, 'byTopic'])->name('topics.vocabularies');
Route::post('vocabularies/import', [VocabularyController::class, 'import'])->name('vocabularies.import');

// Game routes
Route::prefix('games')->name('games.')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('index');
    Route::post('/start', [GameController::class, 'start'])->name('start');
    Route::get('/play', [GameController::class, 'play'])->name('play');
    Route::post('/guess', [GameController::class, 'guess'])->name('guess');
    Route::get('/result', [GameController::class, 'result'])->name('result');
});

// Listen Game routes
Route::prefix('listen-games')->name('listen-games.')->group(function () {
    Route::get('/', [ListenGameController::class, 'index'])->name('index');
    Route::post('/start', [ListenGameController::class, 'start'])->name('start');
    Route::get('/play', [ListenGameController::class, 'play'])->name('play');
    Route::post('/guess', [ListenGameController::class, 'guess'])->name('guess');
    Route::get('/result', [ListenGameController::class, 'result'])->name('result');
});

// Match Game routes
Route::get('/match-game', [MatchGameController::class, 'index'])->name('match-game.index');
Route::get('/match-game/play', [MatchGameController::class, 'play'])->name('match-game.play');
Route::post('/match-game/submit', [MatchGameController::class, 'submit'])->name('match-game.submit');

// Magic Box Game routes
Route::prefix('magic-box')->name('magic-box.')->group(function () {
    Route::get('/', [\App\Http\Controllers\MagicBoxGameController::class, 'index'])->name('index');
    Route::post('/play', [\App\Http\Controllers\MagicBoxGameController::class, 'play'])->name('play');
});

// Auth routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/dashboard', function () {
    return 'Chào mừng bạn đến dashboard!';
})->middleware('auth');

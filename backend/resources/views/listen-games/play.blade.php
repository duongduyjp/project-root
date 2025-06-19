@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $gameData['topic_name'] }}</h4>
                            <small class="text-muted">Từ {{ $gameData['current_word_index'] + 1 }}/{{ count($gameData['vocabularies']) }}</small>
                        </div>
                        <div class="text-end">
                            <div class="h5 mb-0 text-success">
                                <i class="fas fa-star"></i> {{ $gameData['score'] }} điểm
                            </div>
                            <small class="text-muted">Đúng: {{ $gameData['correct_attempts'] }}/{{ count($gameData['vocabularies']) }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body text-center">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="text-muted">Nghe phát âm và chọn từ đúng!</h3>
                    </div>

                    <!-- Nút loa để nghe phát âm -->
                    <div class="mb-5">
                        <button id="speakButton" class="btn btn-primary btn-lg" style="width: 120px; height: 120px; border-radius: 50%;">
                            <i class="fas fa-volume-up fa-3x"></i>
                        </button>
                        <div class="mt-2">
                            <small class="text-muted">Click để nghe phát âm</small>
                        </div>
                    </div>

                    <!-- 4 lựa chọn -->
                    <div class="row">
                        @foreach($choices as $index => $choice)
                            <div class="col-md-6 mb-3">
                                <form action="{{ route('listen-games.guess') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="guess" value="{{ $choice }}">
                                    <button type="submit" class="btn btn-outline-primary btn-lg w-100 choice-btn" 
                                            style="height: 80px; font-size: 1.2rem; border-width: 3px;">
                                        {{ $choice }}
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('listen-games.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hiệu ứng pháo giấy và gấu bông -->
<div id="confetti-container"></div>

<style>
.choice-btn {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.choice-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.3);
    border-color: #007bff !important;
}

.choice-btn:active {
    transform: translateY(0);
}

#speakButton {
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
}

#speakButton:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(0,123,255,0.5);
}

#speakButton:active {
    transform: scale(0.95);
}

/* Hiệu ứng pháo giấy */
.confetti {
    position: fixed;
    width: 20px;
    height: 20px;
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57, #ff9ff3);
    border-radius: 50%;
    z-index: 9999;
    pointer-events: none;
    animation: confetti-fall 3s ease-out forwards;
}

.confetti.square {
    border-radius: 0;
}

.confetti.triangle {
    width: 0;
    height: 0;
    background: none;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 20px solid #ff6b6b;
}

/* Gấu bông */
.teddy-bear {
    position: fixed;
    font-size: 40px;
    z-index: 9999;
    pointer-events: none;
    animation: teddy-fly 3s ease-out forwards;
}

@keyframes confetti-fall {
    0% {
        transform: translateY(-100vh) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}

@keyframes teddy-fly {
    0% {
        transform: translateY(100vh) scale(0.5);
        opacity: 1;
    }
    50% {
        transform: translateY(-20vh) scale(1.2);
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh) scale(0.8);
        opacity: 0;
    }
}

/* Hiệu ứng glow cho nút đúng */
.correct-glow {
    animation: correctGlow 0.5s ease-in-out;
}

@keyframes correctGlow {
    0% { box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); }
    50% { box-shadow: 0 0 30px rgba(40, 167, 69, 0.8); }
    100% { box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); }
}
</style>

<script src="{{ asset('js/listen-game-v2.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initListenGame(
        '{{ $currentWord["word"] }}',
        {{ session('praise') ? 'true' : 'false' }},
        '{{ session("praise_message", "") }}'
    );
});
</script>
@endsection 
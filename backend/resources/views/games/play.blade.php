@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Progress Bar -->
            <div class="card mb-3 bg-glass">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Tiến độ: {{ $gameData['current_word_index'] + 1 }}/{{ count($gameData['vocabularies']) }}</span>
                        <span class="text-primary fw-bold">Điểm: {{ $gameData['score'] }}</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-primary" 
                             style="width: {{ (($gameData['current_word_index'] + 1) / count($gameData['vocabularies'])) * 100 }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">Chủ đề: {{ $gameData['topic_name'] }}</small>
                        <small class="text-muted">Lần đoán: {{ $gameData['total_attempts'] }}</small>
                    </div>
                </div>
            </div>

            <!-- Game Card -->
            <div class="card bg-glass ocean-card-bg">
                <div class="ocean-anim-bg">
                    <!-- Nhiều cá nhỏ bơi động -->
                    <svg class="fish-svg fish1" width="80" height="40" viewBox="0 0 80 40">
                        <ellipse cx="30" cy="20" rx="20" ry="10" fill="#ffb347"/>
                        <polygon points="50,20 70,10 70,30" fill="#ffb347"/>
                        <circle cx="22" cy="18" r="2" fill="#333"/>
                    </svg>
                    <svg class="fish-svg fish2" width="60" height="30" viewBox="0 0 60 30">
                        <g transform="scale(-1,1) translate(-60,0)">
                            <ellipse cx="20" cy="15" rx="15" ry="7" fill="#6ec6ff"/>
                            <polygon points="35,15 55,5 55,25" fill="#6ec6ff"/>
                            <circle cx="27" cy="13" r="1.5" fill="#333"/>
                        </g>
                    </svg>
                    <svg class="fish-svg fish3" width="50" height="25" viewBox="0 0 50 25">
                        <ellipse cx="15" cy="12" rx="10" ry="5" fill="#ff6f91"/>
                        <polygon points="25,12 45,2 45,22" fill="#ff6f91"/>
                        <circle cx="10" cy="10" r="1.2" fill="#333"/>
                    </svg>
                    <svg class="fish-svg fish4" width="40" height="20" viewBox="0 0 40 20">
                        <ellipse cx="12" cy="10" rx="8" ry="4" fill="#7fff7f"/>
                        <polygon points="20,10 38,2 38,18" fill="#7fff7f"/>
                        <circle cx="8" cy="8" r="1" fill="#333"/>
                    </svg>
                    <svg class="fish-svg fish5" width="30" height="15" viewBox="0 0 30 15">
                        <g transform="scale(-1,1) translate(-30,0)">
                            <ellipse cx="8" cy="7" rx="6" ry="3" fill="#ffd700"/>
                            <polygon points="14,7 28,2 28,13" fill="#ffd700"/>
                            <circle cx="11" cy="6" r="0.7" fill="#333"/>
                        </g>
                    </svg>
                    <svg class="fish-svg fish6" width="35" height="18" viewBox="0 0 35 18">
                        <ellipse cx="10" cy="9" rx="7" ry="3.5" fill="#00e6e6"/>
                        <polygon points="17,9 33,2 33,16" fill="#00e6e6"/>
                        <circle cx="7" cy="7" r="0.8" fill="#333"/>
                    </svg>
                    <!-- Cá mập lớn -->
                    <svg class="fish-svg shark" width="140" height="60" viewBox="0 0 140 60">
                        <!-- Thân cá mập -->
                        <ellipse cx="60" cy="30" rx="50" ry="20" fill="#4a90e2"/>
                        <!-- Đuôi -->
                        <polygon points="110,30 138,10 138,50" fill="#4a90e2"/>
                        <!-- Vây trên -->
                        <polygon points="60,10 70,0 80,10" fill="#357ab7"/>
                        <!-- Vây dưới -->
                        <polygon points="70,50 80,60 90,50" fill="#357ab7"/>
                        <!-- Mắt -->
                        <circle cx="45" cy="25" r="3" fill="#fff"/>
                        <circle cx="45" cy="25" r="1.2" fill="#222"/>
                        <!-- Miệng -->
                        <path d="M40 38 Q48 42 56 38" stroke="#222" stroke-width="2" fill="none"/>
                        <!-- Răng -->
                        <polygon points="44,38 45,41 46,38" fill="#fff"/>
                        <polygon points="47,39 48,41 49,39" fill="#fff"/>
                        <polygon points="50,38.5 51,41 52,38.5" fill="#fff"/>
                    </svg>
                </div>
                <div class="card-header text-center bg-transparent border-0">
                    <h3 class="mb-0">
                        <i class="fas fa-image text-primary"></i>
                        Đoán từ tiếng Anh
                    </h3>
                </div>
                <div class="card-body text-center">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            @if(session('praise'))
                                <div class="mt-2">
                                    <i class="fas fa-star text-warning"></i>
                                    <strong class="text-primary">{{ session('praise_message') }}</strong>
                                </div>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-times-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Image -->
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $currentWord['image_path']) }}" 
                             alt="Guess this word" 
                             class="img-fluid rounded shadow game-word-image big-illustration" >
                    </div>

                    <!-- Hint -->
                    <div class="mb-4">
                        <h4 class="text-primary mb-2">Gợi ý:</h4>
                        <div class="hint-display">
                            @for($i = 0; $i < strlen($hint); $i++)
                                <span class="hint-letter {{ $hint[$i] !== '_' ? 'revealed' : '' }}">
                                    {{ $hint[$i] !== '_' ? $hint[$i] : '_' }}
                                </span>
                            @endfor
                        </div>
                        <div class="mt-2">
                            <button onclick="speak('{{ $currentWord['word'] }}')" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-volume-up"></i> Nghe phát âm
                            </button>
                        </div>
                    </div>

                    <!-- Guess Form -->
                    <div class="mb-4">
                        <h4 class="text-primary mb-3">Chọn từ đúng:</h4>
                        <div class="row">
                            @foreach($choices as $choice)
                                <div class="col-md-6 mb-3">
                                    <form action="{{ route('games.guess') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="guess" value="{{ $choice }}">
                                        <button type="submit" class="btn btn-choice btn-lg w-100">
                                            <span class="choice-text">{{ $choice }}</span>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Help -->
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Mẹo:</strong> Nhìn vào ảnh và gợi ý chữ cái để chọn từ tiếng Anh đúng. 
                        Click vào từ bạn nghĩ là đúng!
                    </div>

                    <!-- Navigation -->
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('games.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home"></i> Về trang chủ
                        </a>
                        <button onclick="location.reload()" class="btn btn-outline-warning">
                            <i class="fas fa-redo"></i> Làm mới
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.confetti')
@endsection

<style>
.ocean-card-bg {
    background-size: cover;
    position: relative;
    overflow: hidden;
}
.ocean-anim-bg {
    position: absolute;
    left: 0; top: 0; width: 100%; height: 100%;
    pointer-events: none;
    z-index: 1;
}
.fish-svg {
    position: absolute;
    z-index: 2;
    opacity: 0.85;
}
.fish1 { top: 20%; left: -80px; animation: swim-right 12s linear infinite; }
.fish2 { top: 60%; left: 100%; animation: swim-left 16s linear infinite; }
.fish3 { top: 40%; left: -60px; animation: swim-right 20s linear infinite; }
.fish4 { top: 70%; left: -40px; animation: swim-right 18s linear infinite; }
.fish5 { top: 10%; left: 100%; animation: swim-left 14s linear infinite; }
.fish6 { top: 50%; left: -35px; animation: swim-right 22s linear infinite; }
.shark { top: 30%; left: -140px; animation: swim-right-shark 30s linear infinite; opacity: 0.95; }
@keyframes swim-right {
    0% { left: -80px; }
    100% { left: 100%; }
}
@keyframes swim-left {
    0% { left: 100%; }
    100% { left: -60px; }
}
@keyframes swim-right-shark {
    0% { left: -140px; }
    100% { left: 100%; }
}
.ocean-card-bg .card-body {
    background: rgba(255,255,255,0.7);
    border-radius: 20px;
    position: relative;
    z-index: 10;
}
.bg-glass {
    /* background: rgba(255,255,255,0.7) !important; */
    box-shadow: 0 8px 32px 0 rgba(31,38,135,0.15);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.18);
}
.hint-display {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin: 20px 0;
}

.hint-letter {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    font-weight: bold;
    font-size: 18px;
    background-color: #f8f9fa;
    color: #6c757d;
    transition: all 0.3s ease;
}

.hint-letter.revealed {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
    transform: scale(1.1);
}

.progress {
    border-radius: 10px;
    background-color: #e9ecef;
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.3s ease;
}

/* Styles cho nút lựa chọn */
.btn-choice {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-weight: bold;
    font-size: 2rem;
    padding: 32px 0;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
}

.btn-choice:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    color: white;
}

.btn-choice:active {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.choice-text {
    font-size: 2rem;
    letter-spacing: 1px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

/* Animation cho nút */
.btn-choice::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-choice:hover::before {
    left: 100%;
}

/* Responsive cho mobile */
@media (max-width: 768px) {
    .btn-choice {
        font-size: 1rem;
        padding: 15px;
    }
    
    .choice-text {
        font-size: 1.1rem;
    }
}

/* Animation cho lời khen */
@keyframes praiseGlow {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); color: #ff6b6b; }
    100% { transform: scale(1); }
}

.praise-animation {
    animation: praiseGlow 1s ease-in-out;
}

/* Hiệu ứng pháo giấy */
#fireworks-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 99999;
    overflow: hidden;
}

.firework {
    position: absolute;
    width: 30px;
    height: 30px;
    pointer-events: none;
    border-radius: 3px;
    box-shadow: 0 0 8px rgba(0,0,0,0.3);
}

.firework-1 { background: #ff0000; }
.firework-2 { background: #00ff00; }
.firework-3 { background: #0000ff; }
.firework-4 { background: #ffff00; }
.firework-5 { background: #ff00ff; }
.firework-6 { background: #00ffff; }
.firework-7 { background: #ff8800; }
.firework-8 { background: #8800ff; }

/* Gấu bông */
.teddy-bear {
    position: absolute;
    font-size: 50px;
    pointer-events: none;
    z-index: 99999;
    filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.4));
}

@keyframes teddyFloat {
    0% {
        transform: translate(0, 0) rotate(0deg) scale(0.5);
        opacity: 1;
    }
    25% {
        transform: translate(var(--x), var(--y)) rotate(90deg) scale(0.8);
        opacity: 1;
    }
    50% {
        transform: translate(calc(var(--x) * 2), calc(var(--y) * 2)) rotate(180deg) scale(1);
        opacity: 1;
    }
    75% {
        transform: translate(calc(var(--x) * 3), calc(var(--y) * 3)) rotate(270deg) scale(1.2);
        opacity: 1;
    }
    100% {
        transform: translate(calc(var(--x) * 4), calc(var(--y) * 4)) rotate(360deg) scale(1.5);
        opacity: 0;
    }
}

.teddy-animation {
    animation: teddyFloat 4s ease-out forwards;
}

@keyframes confetti {
    0% {
        transform: translate(0, 0) rotate(0deg);
        opacity: 1;
    }
    25% {
        transform: translate(var(--x), var(--y)) rotate(90deg);
        opacity: 1;
    }
    50% {
        transform: translate(calc(var(--x) * 2), calc(var(--y) * 2)) rotate(180deg);
        opacity: 1;
    }
    75% {
        transform: translate(calc(var(--x) * 3), calc(var(--y) * 3)) rotate(270deg);
        opacity: 1;
    }
    100% {
        transform: translate(calc(var(--x) * 4), calc(var(--y) * 4)) rotate(360deg);
        opacity: 0;
    }
}

.firework-animation {
    animation: confetti 3s ease-out forwards;
}

.game-word-image {
    display: block;
    margin-left: auto;
    margin-right: auto;
    max-width: 95%;
    max-height: 300px;
    border-radius: 16px;
    background: rgba(255,255,255,0.7);
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}

.big-illustration {
    max-width: 95%;
    max-height: 300px;
}
</style>

<script>
// Thêm hiệu ứng âm thanh khi click (tùy chọn)
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-choice');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Có thể thêm âm thanh click ở đây
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Đọc lời khen khi trả lời đúng
    @if(session('praise'))
        speakPraise();
    @endif
});

// Hàm đọc lời khen
function speakPraise() {
    if ('speechSynthesis' in window) {
        // Lấy câu khích lệ từ session hoặc dùng câu mặc định
        const praiseElement = document.querySelector('.alert-success .text-primary');
        const praiseText = praiseElement ? praiseElement.textContent.trim() : 'Wow! Nhím xinh trả lời đúng rồi';
        
        const utterance = new SpeechSynthesisUtterance(praiseText);
        utterance.lang = 'vi-VN'; // Tiếng Việt
        utterance.rate = 1.5; // Tốc độ bình thường
        utterance.pitch = 1.2; // Giọng cao hơn một chút để nghe vui vẻ
        utterance.volume = 1.0; // Âm lượng đầy đủ
        
        // Tìm voice tiếng Việt
        const voices = speechSynthesis.getVoices();
        const vietnameseVoice = voices.find(voice => 
            voice.lang.startsWith('vi') || 
            voice.name.includes('Vietnamese') ||
            voice.name.includes('Tiếng Việt')
        );
        
        if (vietnameseVoice) {
            utterance.voice = vietnameseVoice;
        }
        
        // Đọc lời khen
        speechSynthesis.speak(utterance);
        
        // Thêm hiệu ứng visual
        setTimeout(() => {
            if (praiseElement) {
                praiseElement.classList.add('praise-animation');
                setTimeout(() => {
                    praiseElement.classList.remove('praise-animation');
                }, 1000);
            }
        }, 500);
        
        // Tạo hiệu ứng pháo giấy và gấu bông
        window.createConfetti();
    }
}

// Hàm phát âm sử dụng cùng cấu hình như trang từ vựng
function speak(text) {
    console.log('Speak function called with text:', text);
    
    if ('speechSynthesis' in window) {
        const synth = window.speechSynthesis;
        let voices = synth.getVoices();
        
        if (!voices.length) {
            synth.onvoiceschanged = () => speak(text);
            synth.getVoices();
            return;
        }
        
        // Ưu tiên voice Google (giống Google Dịch)
        let googleVoice = voices.find(v => v.name.includes('Google') && v.lang.startsWith('en'));
        // Nếu không có, ưu tiên giọng nữ tiếng Anh
        let femaleVoice = voices.find(v => v.lang.startsWith('en') && v.name.match(/female|woman|girl|Samantha|Jenny|Linda|Susan|Zira|Emma|Amy|Joanna|Kendra|Kimberly|Salli|Ivy|Mia|Olivia|Tessa|Victoria|Fiona|Karen|Moira|Tessa/i) && v.gender !== 'male');
        if (!femaleVoice) {
            femaleVoice = voices.find(v => v.lang.startsWith('en') && v.gender !== 'male');
        }
        if (!femaleVoice) {
            femaleVoice = voices.find(v => v.lang.startsWith('en'));
        }
        
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US';
        utterance.rate = 0.7;
        
        if (googleVoice) {
            utterance.voice = googleVoice;
            console.log('Using Google voice:', googleVoice.name);
        } else if (femaleVoice) {
            utterance.voice = femaleVoice;
            console.log('Using female voice:', femaleVoice.name);
        } else {
            console.log('Using default voice');
        }
        
        synth.speak(utterance);
        console.log('Speech synthesis speak called');
    } else {
        console.error('Speech synthesis not supported');
        alert('Trình duyệt của bạn không hỗ trợ phát âm!');
    }
}
</script> 
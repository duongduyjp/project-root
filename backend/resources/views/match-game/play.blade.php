@extends('layouts.app')

@section('title', 'Trò chơi nối từ')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Trò chơi nối từ</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-glass">
                <div class="card-header text-center bg-transparent border-0">
                    <h4 class="mb-0">Nối ảnh với từ vựng đúng</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        @foreach($vocabularies as $idx => $vocab)
                            <div class="d-flex align-items-center mb-3 row-match-game">
                                <div class="image-item card p-2 text-center mb-0 me-3 col-img" data-id="{{ $vocab->id }}">
                                    <img src="{{ asset('storage/' . $vocab->image_path) }}" alt="{{ $vocab->word }}" style="max-width: 100%; max-height: 90px; border-radius: 10px; object-fit: contain; display: block; margin: 0 auto;">
                                </div>
                                <div class="col-word">
                                    @if(isset($words[$idx]))
                                        <div class="word-item card p-3 text-center mb-0 w-100" data-word="{{ $words[$idx] }}" style="font-size:1.5rem; cursor:pointer; border-radius:16px; border:2px solid #eee;">
                                            {{ $words[$idx] }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn btn-primary" id="submit-btn">Nộp bài</button>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container cho pháo giấy -->
<div id="fireworks-container"></div>

@include('partials.confetti')

<style>
.image-item.selected, .word-item.selected {
    border: 2px solid #007bff !important;
    background: #e3f0ff;
}
.image-item.matched, .word-item.matched {
    border: 2px solid #28a745 !important;
    background: #e6ffe6;
    color: #28a745;
}
.image-item.card, .word-item.card {
    transition: box-shadow 0.2s, border 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.row-match-game {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    min-height: 120px;
}
.col-img {
    width: 50%;
    max-width: 50%;
    min-width: 0;
    background: none;
    border: none;
    box-shadow: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
.col-word {
    width: 50%;
    max-width: 50%;
    min-width: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.word-item.card {
    width: 100%;
    max-width: 100%;
}
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
</style>

<script>
let selectedImage = null;
let selectedWord = null;
let matches = {};

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.image-item').forEach(item => {
        item.addEventListener('click', function() {
            if(this.classList.contains('matched')) return;
            document.querySelectorAll('.image-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            selectedImage = this;
        });
    });
    document.querySelectorAll('.word-item').forEach(item => {
        item.addEventListener('click', function() {
            if(this.classList.contains('matched')) return;
            document.querySelectorAll('.word-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            selectedWord = this;
            // Nếu đã chọn cả 2 thì nối
            if(selectedImage && selectedWord) {
                matches[selectedImage.dataset.id] = selectedWord.dataset.word;
                selectedImage.classList.add('matched');
                selectedWord.classList.add('matched');
                selectedImage.classList.remove('selected');
                selectedWord.classList.remove('selected');
                selectedImage = null;
                selectedWord = null;
            }
        });
    });
    document.getElementById('submit-btn').addEventListener('click', function() {
        fetch("{{ route('match-game.submit') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({answers: matches})
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('result').innerHTML = `<div class='alert alert-info'>Bạn nối đúng <b>${data.correct}/${data.total}</b> cặp!</div>`;
            window.createConfetti(); // Gọi hiệu ứng pháo giấy khi nộp bài
        });
    });
});
</script>
@endsection 
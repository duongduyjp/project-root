@extends('layouts.app')
@section('title', 'Chiếc hộp thần kì - Chơi game')
@section('content')
<div class="container text-center">
    <h2 class="mb-4">Chủ đề: {{ $topic->name }}</h2>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-center gap-4">
                @foreach($vocabularies as $index => $vocab)
                <div class="magic-box-box" style="width: 150px; height: 150px; position: relative;">
                    <button class="btn btn-light w-100 h-100 magic-box-btn" data-word="{{ $vocab->word }}" data-image="{{ $vocab->image_path ? asset('storage/' . $vocab->image_path) : '' }}" style="font-size:2rem; border:2px solid #6c63ff; border-radius:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); background: linear-gradient(135deg,#f8fafc 60%,#e0e7ff 100%);">
                        <i class="fas fa-gift fa-3x"></i>
                        <div class="magic-box-content" style="display:none; flex-direction:column; align-items:center; justify-content:center; height:100%;">
                            <img class="magic-box-image" src="{{ $vocab->image_path ? asset('storage/' . $vocab->image_path) : '' }}" alt="{{ $vocab->word }}" style="max-width:80px; max-height:60px; margin-bottom:8px; display:none;" />
                            <div class="magic-box-word" style="font-size:1.9rem; font-weight:bold; color:#6c63ff; margin-bottom:6px;"></div>
                        </div>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <a href="{{ route('magic-box.index') }}" class="btn btn-secondary mt-3">Chọn chủ đề khác</a>
</div>
<script>
function speak(text) {
    if ('speechSynthesis' in window) {
        const synth = window.speechSynthesis;
        let voices = synth.getVoices();
        if (!voices.length) {
            synth.onvoiceschanged = () => speak(text);
            synth.getVoices();
            return;
        }
        let googleVoice = voices.find(v => v.name.includes('Google') && v.lang.startsWith('en'));
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
        } else if (femaleVoice) {
            utterance.voice = femaleVoice;
        }
        synth.speak(utterance);
    } else {
        alert('Trình duyệt của bạn không hỗ trợ phát âm!');
    }
}
document.querySelectorAll('.magic-box-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
        if(btn.classList.contains('opened')) return;
        btn.classList.add('opened');
        btn.querySelector('i').style.display = 'none';
        const word = btn.getAttribute('data-word');
        const image = btn.getAttribute('data-image');
        const contentDiv = btn.querySelector('.magic-box-content');
        const wordDiv = btn.querySelector('.magic-box-word');
        const img = btn.querySelector('.magic-box-image');
        wordDiv.textContent = word;
        if(image) {
            img.src = image;
            img.style.display = 'block';
        }
        contentDiv.style.display = 'flex';
        // Gán sự kiện phát âm cho nút loa
        const speakBtn = btn.querySelector('.magic-box-speak');
        speakBtn.onclick = function(e) {
            e.stopPropagation();
            speak(word);
        };
    });
});
</script>
<style>
.magic-box-content {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    display: none;
}
.magic-box-image {
    max-width: 80px;
    max-height: 60px;
    margin-bottom: 8px;
    display: none;
}
.magic-box-word {
    font-size: 1.2rem;
    font-weight: bold;
    color: #6c63ff;
    margin-bottom: 6px;
}
.magic-box-speak {
    font-size: 1.5rem;
    color: #6c63ff;
    margin-top: 2px;
}
</style>
@endsection 
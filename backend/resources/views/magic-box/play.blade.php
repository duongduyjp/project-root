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
                    <button class="btn btn-light w-100 h-100 magic-box-btn" data-word="{{ $vocab->word }}" style="font-size:2rem; border:2px solid #6c63ff; border-radius:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); background: linear-gradient(135deg,#f8fafc 60%,#e0e7ff 100%);">
                        <i class="fas fa-gift fa-3x"></i>
                        <div class="magic-box-word" style="display:none; font-size:2rem; font-weight:bold; color:#6c63ff;"></div>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <a href="{{ route('magic-box.index') }}" class="btn btn-secondary mt-3">Chọn chủ đề khác</a>
</div>
<script>
document.querySelectorAll('.magic-box-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
        if(btn.classList.contains('opened')) return;
        btn.classList.add('opened');
        btn.querySelector('i').style.display = 'none';
        const word = btn.getAttribute('data-word');
        const wordDiv = btn.querySelector('.magic-box-word');
        wordDiv.textContent = word;
        wordDiv.style.display = 'block';
    });
});
</script>
@endsection 
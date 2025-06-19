@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(isset($vocabulary) && $vocabulary)
        <div class="card">
            <div class="card-body text-center">
                @if($vocabulary->image_path)
                    <img src="{{ asset($vocabulary->image_path) }}" width="200" class="img-fluid mb-3" alt="Vocabulary Image">
                @endif
                
                <p class="h4 mb-4">{{ $vocabulary->meaning }}</p>
                
                <div id="boxes" class="mb-4">
                    @for ($i = 0; $i < strlen($vocabulary->word); $i++)
                        <input type="text" maxlength="1" class="form-control d-inline-block mx-1" style="width: 40px; text-align: center; font-size: 18px;">
                    @endfor
                </div>
                
                <button onclick="speak('{{ $vocabulary->word }}')" class="btn btn-primary mb-3">
                    🔊 Nghe
                </button>
                
                <div class="mt-3">
                    @if($prev)
                        <a href="{{ route('vocabularies.practice', $prev->id) }}" class="btn btn-secondary">⬅️ Trước</a>
                    @endif
                    @if($next)
                        <a href="{{ route('vocabularies.practice', $next->id) }}" class="btn btn-secondary">Tiếp ➡️</a>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Không tìm thấy từ vựng này.
        </div>
    @endif
</div>

<script>
function speak(text) {
    try {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'en-US'; // Đặt ngôn ngữ tiếng Anh
            utterance.rate = 0.7; // Tốc độ nói chậm hơn một chút
            speechSynthesis.speak(utterance);
        } else {
            alert('Trình duyệt của bạn không hỗ trợ tính năng phát âm.');
        }
    } catch (error) {
        console.error('Lỗi khi phát âm:', error);
        alert('Có lỗi xảy ra khi phát âm.');
    }
}
</script>
@endsection
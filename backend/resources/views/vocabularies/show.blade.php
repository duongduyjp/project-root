@extends('layouts.app')

@section('content')
{{-- Đã loại bỏ container và row thừa để khớp với layout chính --}}
<div class="d-flex justify-content-center">
    <div class="card text-center shadow-lg" style="max-width: 700px; width: 100%; padding: 2.5rem 0;">
        <div class="card-body">
            <h1 class="display-3 mb-4" style="font-size: 6rem; font-weight: bold;">
                {{ $vocabulary->word }}
                <button onclick="speak('{{ $vocabulary->word }}')" class="btn btn-link p-0 align-baseline" style="font-size: 2.5rem; vertical-align: middle;" title="Phát âm">
                    🔊
                </button>
            </h1>
            @if($vocabulary->image_path)
                <img src="{{ asset('storage/' . $vocabulary->image_path) }}" alt="{{ $vocabulary->word }}" class="img-fluid rounded mb-4" style="max-height: 420px;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center mb-4" style="height: 250px;">
                    <i class="fas fa-image text-muted fa-4x"></i>
                </div>
            @endif

            @if($vocabulary->sentences)
                <div class="text-start mt-4" style="max-width: 600px; margin: 0 auto; font-size: 2.1rem; line-height: 1.6;">
                    <h4 class="text-primary mb-3">Các câu ví dụ:</h4>
                    <p>{!! nl2br(e($vocabulary->sentences)) !!}</p>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-3 flex-wrap" style="max-width: 700px; width: 100%; margin: 0 auto;">
    @php
        $prev = \App\Models\Vocabulary::where('topic_id', $vocabulary->topic_id)->where('id', '<', $vocabulary->id)->orderBy('id', 'desc')->first();
        $next = \App\Models\Vocabulary::where('topic_id', $vocabulary->topic_id)->where('id', '>', $vocabulary->id)->orderBy('id')->first();
    @endphp

    {{-- Nút điều hướng ẩn, chỉ dùng cho bàn phím --}}
    @if($prev)
        <a id="prev-link" href="{{ route('vocabularies.show', $prev) }}" class="d-none"></a>
    @endif
    @if($next)
        <a id="next-link" href="{{ route('vocabularies.show', $next) }}" class="d-none"></a>
    @endif

    {{-- Các nút chức năng hiển thị --}}
    <a href="{{ route('vocabularies.index') }}" class="btn btn-secondary btn-lg" title="Quay lại từ vựng">
        <i class="fas fa-arrow-left"></i>
    </a>
    <a href="{{ route('vocabularies.create', ['topic_id' => $vocabulary->topic_id]) }}" class="btn btn-success btn-lg" title="Thêm từ vựng">
        <i class="fas fa-plus"></i>
    </a>
    <a href="{{ route('topics.vocabularies', $vocabulary->topic_id) }}" class="btn btn-info btn-lg" title="Quay lại chủ đề">
        <i class="fas fa-arrow-left"></i>
    </a>
    <a href="{{ route('vocabularies.edit', $vocabulary) }}" class="btn btn-warning btn-lg" title="Sửa từ vựng">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('vocabularies.destroy', $vocabulary) }}" method="POST" class="d-inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-lg" title="Xóa từ vựng"
                onclick="return confirm('Bạn có chắc chắn muốn xóa từ vựng này không?');">
            <i class="fas fa-trash"></i>
        </button>
    </form>
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
        } else if (femaleVoice) {
            utterance.voice = femaleVoice;
        }
        synth.speak(utterance);
    } else {
        alert('Trình duyệt của bạn không hỗ trợ phát âm!');
    }
}
document.addEventListener('keydown', function(event) {
    if (event.key === 'ArrowLeft') {
        var prev = document.getElementById('prev-link');
        if (prev) prev.click();
    } else if (event.key === 'ArrowRight') {
        var next = document.getElementById('next-link');
        if (next) next.click();
    }
});
</script>
@endsection 
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2 class="mb-0">
                        <i class="fas fa-volume-up text-success"></i>
                        Trò Chơi Nghe Từ
                    </h2>
                    <p class="text-muted mb-0">Nghe phát âm và chọn từ tiếng Anh đúng!</p>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        @forelse($topics as $topic)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-headphones text-success fa-3x"></i>
                                        </div>
                                        <h5 class="card-title">{{ $topic->name }}</h5>
                                        <p class="card-text text-muted">
                                            {{ $topic->vocabularies_count }} từ vựng
                                        </p>
                                        
                                        @if($topic->vocabularies_count >= 5)
                                            <form action="{{ route('listen-games.start') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="fas fa-play"></i> Bắt đầu chơi
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-lg" disabled>
                                                <i class="fas fa-exclamation-triangle"></i> Cần ít nhất 5 từ
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    Chưa có chủ đề nào. Hãy tạo chủ đề và thêm từ vựng để chơi!
                                </div>
                                <a href="{{ route('topics.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tạo chủ đề đầu tiên
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div class="text-center mt-4">
                        <div class="alert alert-info">
                            <i class="fas fa-volume-up"></i>
                            <strong>Phù hợp cho trẻ em!</strong> Nghe phát âm và click chọn từ đúng, không cần nhập chữ.
                        </div>
                        <a href="{{ route('vocabularies.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại từ vựng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
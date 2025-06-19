@extends('layouts.app')
@section('title', 'Chọn chủ đề - Trò chơi nối từ')
@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Chọn chủ đề để bắt đầu trò chơi nối từ</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row g-4">
                @foreach($topics as $topic)
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm text-center" style="border-radius: 18px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title mb-3">{{ $topic->name }}</h5>
                                <span class="badge bg-info mb-3">{{ $topic->vocabularies_count }} từ vựng có ảnh</span>
                                <a href="{{ route('match-game.play', ['topic_id' => $topic->id]) }}" class="btn btn-success mt-auto">
                                    <i class="fas fa-play"></i> Bắt đầu chơi
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 
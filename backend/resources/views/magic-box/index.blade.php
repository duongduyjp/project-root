@extends('layouts.app')
@section('title', 'Chiếc hộp thần kì - Chọn chủ đề')
@section('content')
<div class="container">
    <h2 class="mb-4">Chọn chủ đề để chơi Chiếc hộp thần kì</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($topics as $topic)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">{{ $topic->name }}</h5>
                    <p class="card-text">{{ $topic->vocabularies_count }} từ vựng</p>
                    <form action="{{ route('magic-box.play') }}" method="POST">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        <button type="submit" class="btn btn-primary mt-2">Bắt đầu chơi</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection 
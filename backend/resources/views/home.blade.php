@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <img src="{{ asset('images/nhim.jpg') }}" alt="Avatar" class="rounded-circle shadow" style="width: 80px; height: 80px; object-fit: cover;">
        <h1 class="mt-3" style="font-weight: bold;">Chào mừng đến với Hĩn Hôi Học English!</h1>
        <p class="text-muted">Cùng học tiếng Anh thật vui và hiệu quả mỗi ngày!</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3 mb-4">
            <a href="{{ route('topics.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow card-hover" style="background: linear-gradient(135deg, #f8ffae 0%, #43c6ac 100%);">
                    <div class="card-body text-center">
                        <i class="bi bi-book" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title mt-3">Chủ đề</h5>
                        <p class="card-text">Khám phá các chủ đề tiếng Anh đa dạng.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('vocabularies.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow card-hover" style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);">
                    <div class="card-body text-center">
                        <i class="fas fa-language" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title mt-3">Từ vựng</h5>
                        <p class="card-text">Học và ôn tập từ vựng mỗi ngày.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('games.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow card-hover" style="background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);">
                    <div class="card-body text-center">
                        <i class="fas fa-gamepad" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title mt-3">Trò chơi đoán từ</h5>
                        <p class="card-text">Vừa chơi vừa học, tăng vốn từ vựng.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('listen-games.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow card-hover" style="background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);">
                    <div class="card-body text-center">
                        <i class="fas fa-volume-up" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title mt-3">Trò chơi nghe từ</h5>
                        <p class="card-text">Luyện nghe tiếng Anh qua trò chơi vui nhộn.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<style>
.card-hover {
    transition: transform 0.2s, box-shadow 0.2s;
}
.card-hover:hover {
    transform: translateY(-8px) scale(1.04);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    z-index: 2;
}
</style>
@endsection 
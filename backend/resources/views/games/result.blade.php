@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2 class="mb-0">
                        <i class="fas fa-trophy text-warning"></i>
                        Kết Quả Trò Chơi
                    </h2>
                </div>
                <div class="card-body text-center">
                    <!-- Score Display -->
                    <div class="mb-4">
                        <div class="display-4 text-primary fw-bold">{{ $gameData['score'] }}</div>
                        <div class="text-muted">Tổng điểm</div>
                    </div>

                    <!-- Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-number text-success">{{ $correctWords }}</div>
                                <div class="stat-label">Từ đúng</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-number text-info">{{ $totalWords }}</div>
                                <div class="stat-label">Tổng từ</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-number text-warning">{{ $accuracy }}%</div>
                                <div class="stat-label">Độ chính xác</div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Message -->
                    <div class="mb-4">
                        @if($accuracy >= 90)
                            <div class="alert alert-success">
                                <i class="fas fa-star"></i>
                                <strong>Xuất sắc!</strong> Bạn đã hoàn thành rất tốt!
                            </div>
                        @elseif($accuracy >= 70)
                            <div class="alert alert-info">
                                <i class="fas fa-thumbs-up"></i>
                                <strong>Tốt!</strong> Bạn đã làm rất tốt!
                            </div>
                        @elseif($accuracy >= 50)
                            <div class="alert alert-warning">
                                <i class="fas fa-hand-paper"></i>
                                <strong>Khá!</strong> Hãy cố gắng thêm!
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Cần cải thiện!</strong> Hãy luyện tập thêm!
                            </div>
                        @endif
                    </div>

                    <!-- Game Info -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-info-circle"></i>
                                Thông tin trò chơi
                            </h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <p><strong>Chủ đề:</strong> {{ $gameData['topic_name'] }}</p>
                                    <p><strong>Thời gian bắt đầu:</strong> {{ \Carbon\Carbon::parse($gameData['game_started_at'])->format('H:i:s d/m/Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Thời gian kết thúc:</strong> {{ now()->format('H:i:s d/m/Y') }}</p>
                                    <p><strong>Thời gian chơi:</strong> {{ \Carbon\Carbon::parse($gameData['game_started_at'])->diffForHumans(now(), true) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ route('games.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-gamepad"></i> Chơi lại
                        </a>
                        <a href="{{ route('topics.vocabularies', $gameData['topic_id']) }}" class="btn btn-info btn-lg">
                            <i class="fas fa-book"></i> Xem từ vựng
                        </a>
                        <a href="{{ route('vocabularies.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-home"></i> Về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-card {
    padding: 20px;
    border-radius: 10px;
    background-color: #f8f9fa;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.display-4 {
    font-size: 4rem;
    font-weight: 300;
    line-height: 1.2;
}
</style>
@endsection 
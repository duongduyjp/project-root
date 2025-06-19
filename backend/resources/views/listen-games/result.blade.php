@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2 class="mb-0">
                        <i class="fas fa-trophy text-warning"></i>
                        Kết Quả Trò Chơi Nghe Từ
                    </h2>
                </div>
                
                <div class="card-body text-center">
                    <div class="mb-4">
                        <h4 class="text-primary">{{ $gameData['topic_name'] }}</h4>
                        <p class="text-muted">Hoàn thành lúc {{ \Carbon\Carbon::parse($gameData['game_started_at'])->format('H:i:s') }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h3 class="mb-0">{{ $gameData['score'] }}</h3>
                                    <small>Điểm số</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h3 class="mb-0">{{ $correctWords }}/{{ $totalWords }}</h3>
                                    <small>Từ đúng</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h3 class="mb-0">{{ $accuracy }}%</h3>
                                    <small>Độ chính xác</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông báo kết quả -->
                    <div class="mb-4">
                        @if($accuracy >= 90)
                            <div class="alert alert-success">
                                <h4><i class="fas fa-star"></i> Xuất sắc!</h4>
                                <p class="mb-0">Nhím xinh học rất giỏi! Hãy tiếp tục phát huy nhé!</p>
                            </div>
                        @elseif($accuracy >= 70)
                            <div class="alert alert-info">
                                <h4><i class="fas fa-thumbs-up"></i> Tốt lắm!</h4>
                                <p class="mb-0">Nhím xinh làm rất tốt! Hãy cố gắng thêm một chút nữa!</p>
                            </div>
                        @elseif($accuracy >= 50)
                            <div class="alert alert-warning">
                                <h4><i class="fas fa-hand-holding-heart"></i> Khá tốt!</h4>
                                <p class="mb-0">Nhím xinh đã cố gắng! Hãy ôn tập thêm để làm tốt hơn!</p>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <h4><i class="fas fa-heart"></i> Cố gắng!</h4>
                                <p class="mb-0">Đừng buồn nhé! Hãy ôn tập lại và thử lại!</p>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <form action="{{ route('listen-games.start') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="topic_id" value="{{ $gameData['topic_id'] }}">
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-redo"></i> Chơi lại
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('listen-games.index') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-list"></i> Chọn chủ đề khác
                            </a>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('vocabularies.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại từ vựng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.alert {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn {
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}
</style>
@endsection 
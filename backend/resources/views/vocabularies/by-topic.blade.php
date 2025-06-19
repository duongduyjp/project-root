@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">
                            <i class="fas fa-folder"></i> 
                            Từ vựng chủ đề: {{ $topic->name }}
                        </h4>
                        <small class="text-muted">{{ $vocabularies->count() }} từ vựng</small>
                    </div>
                    <div>
                        <a href="{{ route('vocabularies.create', ['topic_id' => $topic->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm từ vựng
                        </a>
                        <a href="{{ route('topics.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại chủ đề
                        </a>
                        <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-import"></i> Import từ vựng
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! nl2br(e(session('success'))) !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! nl2br(e(session('error'))) !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($vocabularies->count() > 0)
                        <div class="row">
                            @foreach($vocabularies as $vocabulary)
                                <div class="col-md-4 col-lg-3 mb-4">
                                    <div class="card h-100">
                                        @if($vocabulary->image_path)
                                            <a href="{{ route('vocabularies.show', $vocabulary) }}">
                                                <img src="{{ asset('storage/' . $vocabulary->image_path) }}" 
                                                     class="card-img-top" alt="{{ $vocabulary->word }}"
                                                     style="height: 200px; object-fit: cover;">
                                            </a>
                                        @else
                                            <a href="{{ route('vocabularies.show', $vocabulary) }}">
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                     style="height: 200px;">
                                                    <i class="fas fa-image text-muted fa-3x"></i>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">{{ $vocabulary->word }}</h5>
                                            <p class="card-text">{{ $vocabulary->meaning }}</p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('vocabularies.practice', $vocabulary->id) }}" 
                                                   class="btn btn-outline-success">
                                                    <i class="fas fa-play"></i> Luyện tập
                                                </a>
                                                <a href="{{ route('vocabularies.edit', $vocabulary) }}" 
                                                   class="btn btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('vocabularies.destroy', $vocabulary) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            onclick="return confirm('Bạn có chắc muốn xóa từ vựng này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">Chưa có từ vựng nào trong chủ đề này.</p>
                            <a href="{{ route('vocabularies.create') }}" class="btn btn-primary">Thêm từ vựng đầu tiên</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('vocabularies.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import từ vựng vào chủ đề: <b>{{ $topic->name }}</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="topic_id" value="{{ $topic->id }}">
          <div class="mb-3">
            <label for="csv_file" class="form-label">Chọn file CSV</label>
            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
            <div class="form-text">File mẫu gồm 2 cột: <b>word, meaning</b> (không có header cũng được)</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-success">Import</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection 
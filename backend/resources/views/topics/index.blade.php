@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Quản lý Topic</h4>
                    <a href="{{ route('topics.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm topic mới
                    </a>
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

                    @if($topics->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên topic</th>
                                        <th>Số từ vựng</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topics as $topic)
                                        <tr>
                                            <td>{{ $topic->id }}</td>
                                            <td>{{ $topic->name }}</td>
                                            <td>{{ $topic->vocabularies->count() }}</td>
                                            <td>{{ $topic->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('topics.edit', $topic) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="{{ $topic->vocabularies->first() ? route('vocabularies.show', $topic->vocabularies->first()) : '#' }}" class="btn btn-sm btn-info {{ $topic->vocabularies->isEmpty() ? 'disabled' : '' }}">
                                                    <i class="fas fa-info-circle"></i> Chi tiết
                                                </a>
                                                <a href="{{ route('vocabularies.create', ['topic_id' => $topic->id]) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-plus"></i> Thêm từ vựng
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModalTopic{{ $topic->id }}" title="Import từ vựng">
                                                    <i class="fas fa-file-import"></i>
                                                </a>
                                                <form action="{{ route('topics.destroy', $topic) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa chủ đề này?')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <!-- Modal Import cho từng topic -->
                                        <div class="modal fade" id="importModalTopic{{ $topic->id }}" tabindex="-1" aria-labelledby="importModalLabel{{ $topic->id }}" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <form action="{{ route('vocabularies.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="importModalLabel{{ $topic->id }}">Import từ vựng vào chủ đề: <b>{{ $topic->name }}</b></h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                  <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                                                  <div class="mb-3">
                                                    <label for="csv_file_{{ $topic->id }}" class="form-label">Chọn file CSV</label>
                                                    <input type="file" class="form-control" id="csv_file_{{ $topic->id }}" name="csv_file" accept=".csv" required>
                                                    <div class="form-text">File mẫu gồm 2 cột: <b>word, sentences</b> (không có header cũng được)</div>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">Chưa có chủ đề nào.</p>
                            <a href="{{ route('topics.create') }}" class="btn btn-primary">Tạo chủ đề đầu tiên</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
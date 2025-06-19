@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Chi tiết chủ đề</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID:</strong>
                            <p>{{ $topic->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tên chủ đề:</strong>
                            <p>{{ $topic->name }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Số từ vựng:</strong>
                            <p>{{ $topic->vocabularies->count() }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Ngày tạo:</strong>
                            <p>{{ $topic->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    @if($topic->vocabularies->count() > 0)
                        <div class="mt-4">
                            <h5>Danh sách từ vựng:</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Từ</th>
                                            <th>Nghĩa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topic->vocabularies as $vocabulary)
                                            <tr>
                                                <td>{{ $vocabulary->word }}</td>
                                                <td>{{ $vocabulary->meaning }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('topics.edit', $topic) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <a href="{{ route('topics.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
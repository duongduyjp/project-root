@extends('layouts.app')

@section('title', '棚一覧')

@section('content')
<style>
    .pagination {
        margin-bottom: 0;
        justify-content: center;
    }

    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        color: #0d6efd;
        background-color: #fff;
        border: 1px solid #dee2e6;
        min-width: 38px;
        text-align: center;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0a58ca;
    }

    .pagination-info {
        color: #6c757d;
        font-size: 0.875rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    .pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 1.5rem;
    }
</style>

<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1>棚一覧</h1>
        <a href="{{ route('master.shelf.create') }}" class="btn btn-primary">{{ __('messages.common.new') }}</a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('master.shelf.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">検索</label>
                    <input type="text" class="form-control" id="search" name="search"
                        value="{{ request('search') }}" placeholder="棚コード、棚名で検索">
                </div>
                <div class="col-md-4">
                    <label for="yard_code" class="form-label">ヤード</label>
                    <select class="form-select" id="yard_code" name="yard_code">
                        <option value="">すべて</option>
                        @foreach($yards as $yard)
                        <option value="{{ $yard->yard_code }}" {{ request('yard_code') == $yard->yard_code ? 'selected' : '' }}>
                            {{ $yard->yard_name }} ({{ $yard->yard_code }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">検索</button>
                    <a href="{{ route('master.shelf.index') }}" class="btn btn-secondary">リセット</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">棚リスト</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>棚コード</th>
                            <th>棚名</th>
                            <th>ヤード</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shelves as $shelf)
                        <tr>
                            <td>{{ $shelf->shelf_id }}</td>
                            <td>{{ $shelf->shelf_name }}</td>
                            <td>{{ $shelf->yard->yard_name }} ({{ $shelf->yard->yard_code }})</td>
                            <td>
                                <a href="{{ route('master.shelf.edit', $shelf) }}" class="btn btn-sm btn-primary">編集</a>
                                <form action="{{ route('master.shelf.destroy', $shelf) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('削除してもよろしいですか？')">削除</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">データがありません</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $shelves->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
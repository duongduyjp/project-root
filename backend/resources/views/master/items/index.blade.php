@extends('layouts.app')

@section('title', __('messages.item.title'))

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1>{{ __('messages.item.title') }}</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-file-earmark-excel me-1"></i>CSVインポート
            </button>
            <a href="{{ route('master.items.create') }}" class="btn btn-primary">{{ __('messages.common.new') }}</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">CSVインポート</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('master.items.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">CSVファイルを選択</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                        </div>
                        <div class="text-muted small">
                            <p class="mb-1">※ CSVファイルの形式:</p>
                            <p class="mb-1">商品コード,商品名,契約種別(1:日極, 2:販売),重量</p>
                            <p class="mb-0">例: ITEM001,商品A,1,100</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                        <button type="submit" class="btn btn-primary">インポート</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('master.items.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="item_no" class="form-label">{{ __('messages.item.item_no') }}</label>
                    <input type="text" class="form-control" id="item_no" name="item_no" value="{{ request('item_no') }}">
                </div>
                <div class="col-md-4">
                    <label for="item_name" class="form-label">{{ __('messages.item.item_name') }}</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="{{ request('item_name') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.search') }}</button>
                        <a href="{{ route('master.items.index') }}" class="btn btn-secondary">{{ __('messages.common.clear_search') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('messages.item.item_no') }}</th>
                            <th>{{ __('messages.item.item_name') }}</th>
                            <th>{{ __('messages.item.contract_type') }}</th>
                            <th>{{ __('messages.item.weight') }}</th>
                            <th>{{ __('messages.common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->item_no }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>
                                    @if($item->contract_type == '1')
                                        {{ __('messages.item.contract_type_rental') }}
                                    @else
                                        {{ __('messages.item.contract_type_sale') }}
                                    @endif
                                </td>
                                <td>{{ $item->weight }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('master.items.edit', $item->item_no) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil text-white"></i>
                                        </a>
                                        <form action="{{ route('master.items.destroy', $item->item_no) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('{{ __('messages.item.delete_confirm') }}');"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-container">
                <div class="pagination-info">
                    表示中 {{ $items->firstItem() }}～{{ $items->lastItem() }}件目 / 全{{ $items->total() }}件
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>

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
@endsection 
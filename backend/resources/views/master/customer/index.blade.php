@extends('layouts.app')

@section('title', __('messages.customer.title'))

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
        <h1>{{ __('messages.customer.title') }}</h1>
        <a href="{{ route('master.customer.create') }}" class="btn btn-primary">{{ __('messages.common.new') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('master.customer.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="customer_id" class="form-label">{{ __('messages.customer.customer_id') }}</label>
                    <input type="text" class="form-control" id="customer_id" name="customer_id" value="{{ request('customer_id') }}">
                </div>
                <div class="col-md-4">
                    <label for="customer_name" class="form-label">{{ __('messages.customer.customer_name') }}</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ request('customer_name') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.search') }}</button>
                        <a href="{{ route('master.customer.index') }}" class="btn btn-secondary">{{ __('messages.common.clear_search') }}</a>
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
                            <th>{{ __('messages.customer.customer_id') }}</th>
                            <th>{{ __('messages.customer.customer_name') }}</th>
                            <th>{{ __('messages.customer.address') }}</th>
                            <th>{{ __('messages.customer.customer_type') }}</th>
                            <th>{{ __('messages.customer.closing_date') }}</th>
                            <th>{{ __('messages.common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->customer_id }}</td>
                                <td>{{ $customer->customer_name }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>
                                    @if($customer->customer_type == '1')
                                        {{ __('messages.customer.customer_type_supplier') }}
                                    @else
                                        {{ __('messages.customer.customer_type_client') }}
                                    @endif
                                </td>
                                <td>
                                    @if($customer->closing_date == '99')
                                        {{ __('messages.customer.closing_date_end') }}
                                    @else
                                        {{ $customer->closing_date }}{{ __('messages.customer.closing_date_day') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('master.customer.edit', $customer->customer_id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil text-white"></i>
                                        </a>
                                        <form action="{{ route('master.customer.destroy', $customer->customer_id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('{{ __('messages.customer.delete_confirm') }}');"
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
                    表示中 {{ $customers->firstItem() }}～{{ $customers->lastItem() }}件目 / 全{{ $customers->total() }}件
                </div>
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 
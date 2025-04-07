@extends('layouts.app')

@section('title', '取引先新規作成')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1>取引先新規作成</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('master.customer.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="customer_id" class="form-label">取引先コード</label>
                    <div class="input-group">
                        <input type="text" class="form-control bg-light" id="customer_id" name="customer_id" value="{{ $nextCustomerId }}" readonly style="cursor: not-allowed; color: #666;">
                        <span class="input-group-text bg-light" style="color: #666;">
                            <i class="bi bi-lock"></i>
                        </span>
                    </div>
                    <small class="text-muted">※自動採番されます</small>
                </div>

                <div class="mb-3">
                    <label for="customer_name" class="form-label">取引先名</label>
                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                           id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">住所</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="customer_type" class="form-label">取引先種別</label>
                    <select class="form-select @error('customer_type') is-invalid @enderror" 
                            id="customer_type" name="customer_type" required>
                        <option value="">選択してください</option>
                        <option value="supplier" {{ old('customer_type') == 'supplier' ? 'selected' : '' }}>仕入先</option>
                        <option value="customer" {{ old('customer_type') == 'customer' ? 'selected' : '' }}>得意先</option>
                    </select>
                    @error('customer_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="closing_date" class="form-label">締日</label>
                    <select class="form-select @error('closing_date') is-invalid @enderror" 
                            id="closing_date" name="closing_date" required>
                        <option value="">選択してください</option>
                        <option value="5" {{ old('closing_date') == 5 ? 'selected' : '' }}>5日</option>
                        <option value="10" {{ old('closing_date') == 10 ? 'selected' : '' }}>10日</option>
                        <option value="15" {{ old('closing_date') == 15 ? 'selected' : '' }}>15日</option>
                        <option value="20" {{ old('closing_date') == 20 ? 'selected' : '' }}>20日</option>
                        <option value="25" {{ old('closing_date') == 25 ? 'selected' : '' }}>25日</option>
                        <option value="99" {{ old('closing_date') == 99 ? 'selected' : '' }}>月末</option>
                    </select>
                    @error('closing_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.create') }}</button>
                    <a href="{{ route('master.customer') }}" class="btn btn-secondary">{{ __('messages.common.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
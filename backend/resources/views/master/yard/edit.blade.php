@extends('layouts.app')

@section('title', 'ヤード編集')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1>{{ __('messages.yard.edit_title') }}</h1>
        <form action="{{ route('master.yard.destroy', $yard->yard_code) }}" 
              method="POST" 
              onsubmit="return confirm('{{ __('messages.yard.delete_confirm') }}');"
              style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link text-danger p-0">
                <i class="bi bi-trash fs-4"></i>
            </button>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('master.yard.update', $yard->yard_code) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="customer_id" class="form-label">取引先コード</label>
                    <div class="input-group">
                        <input type="text" class="form-control bg-light" id="yard_code" value="{{ $yard->yard_code }}" readonly style="cursor: not-allowed; color: #666;">
                        <span class="input-group-text bg-light" style="color: #666;">
                            <i class="bi bi-lock"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="yard_name" class="form-label">{{ __('messages.yard.name') }}</label>
                    <input type="text" class="form-control @error('yard_name') is-invalid @enderror" 
                           id="yard_name" name="yard_name" 
                           value="{{ old('yard_name', $yard->yard_name) }}" required>
                    @error('yard_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="yard_phone" class="form-label">{{ __('messages.yard.phone') }}</label>
                    <input type="text" class="form-control @error('yard_phone') is-invalid @enderror" 
                           id="yard_phone" name="yard_phone" 
                           value="{{ old('yard_phone', $yard->yard_phone) }}" required>
                    @error('yard_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="yard_address" class="form-label">{{ __('messages.yard.address') }}</label>
                    <input type="text" class="form-control @error('yard_address') is-invalid @enderror" 
                           id="yard_address" name="yard_address" 
                           value="{{ old('yard_address', $yard->yard_address) }}" required>
                    @error('yard_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.update') }}</button>
                    <a href="{{ route('master.yard.index') }}" class="btn btn-secondary me-2">{{ __('messages.common.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('title', __('messages.yard.create_title'))

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1>{{ __('messages.yard.create_title') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('master.yard.store') }}">
                @csrf
                
                <h5 class="mb-3">{{ __('messages.yard.yard_info') }}</h5>
                <div class="mb-3">
                    <label for="yard_code" class="form-label">{{ __('messages.yard.code') }}</label>
                    <input type="text" class="form-control @error('yard_code') is-invalid @enderror" id="yard_code" name="yard_code" value="{{ old('yard_code') }}" required>
                    @error('yard_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="yard_name" class="form-label">{{ __('messages.yard.name') }}</label>
                    <input type="text" class="form-control @error('yard_name') is-invalid @enderror" id="yard_name" name="yard_name" value="{{ old('yard_name') }}" required>
                    @error('yard_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="yard_phone" class="form-label">{{ __('messages.yard.phone') }}</label>
                    <input type="text" class="form-control @error('yard_phone') is-invalid @enderror" id="yard_phone" name="yard_phone" value="{{ old('yard_phone') }}" required>
                    @error('yard_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="yard_address" class="form-label">{{ __('messages.yard.address') }}</label>
                    <input type="text" class="form-control @error('yard_address') is-invalid @enderror" id="yard_address" name="yard_address" value="{{ old('yard_address') }}" required>
                    @error('yard_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.create') }}</button>
                    <a href="{{ route('master.yard') }}" class="btn btn-secondary">{{ __('messages.common.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
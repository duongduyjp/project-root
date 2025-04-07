@extends('layouts.app')

@section('title', '棚新規作成')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1>棚新規作成</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('master.shelf.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="shelf_id" class="form-label">棚コード</label>
                    <input type="text" class="form-control @error('shelf_id') is-invalid @enderror"
                        id="shelf_id" name="shelf_id" value="{{ old('shelf_id') }}" required>
                    @error('shelf_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="shelf_name" class="form-label">棚名</label>
                    <input type="text" class="form-control @error('shelf_name') is-invalid @enderror"
                        id="shelf_name" name="shelf_name" value="{{ old('shelf_name') }}" required>
                    @error('shelf_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="yard_code" class="form-label">ヤード</label>
                    <select class="form-select @error('yard_code') is-invalid @enderror" id="yard_code" name="yard_code" required>
                        <option value="">選択してください</option>
                        @foreach($yards as $yard)
                        <option value="{{ $yard->yard_code }}" {{ old('yard_code') == $yard->yard_code ? 'selected' : '' }}>
                            {{ $yard->yard_name }} ({{ $yard->yard_code }})
                        </option>
                        @endforeach
                    </select>
                    @error('yard_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.create') }}</button>
                    <a href="{{ route('master.shelf.index') }}" class="btn btn-secondary">{{ __('messages.common.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
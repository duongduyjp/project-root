@extends('layouts.app')

@section('title', '現場編集')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1>{{ __('messages.site.edit_title') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('sites.update', $site->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="customer_id" class="form-label">{{ __('messages.site.customer_id') }}</label>
                    <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                        <option value="">選択してください</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ old('customer_id', $site->customer_id) == $customer->customer_id ? 'selected' : '' }}>
                            {{ $customer->customer_name }} ({{ $customer->customer_id }})
                        </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.site.name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $site->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">{{ __('messages.site.address') }}</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                        id="address" name="address" value="{{ old('address', $site->address) }}" required>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('messages.site.phone') }}</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                        id="phone" name="phone" value="{{ old('phone', $site->phone) }}" required>
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="closing_date" class="form-label">{{ __('messages.site.closing_date') }}</label>
                    <select class="form-select @error('closing_date') is-invalid @enderror"
                        id="closing_date" name="closing_date" required>
                        <option value="">選択してください</option>
                        <option value="5" {{ old('closing_date', $site->closing_date) == 5 ? 'selected' : '' }}>5日</option>
                        <option value="10" {{ old('closing_date', $site->closing_date) == 10 ? 'selected' : '' }}>10日</option>
                        <option value="15" {{ old('closing_date', $site->closing_date) == 15 ? 'selected' : '' }}>15日</option>
                        <option value="20" {{ old('closing_date', $site->closing_date) == 20 ? 'selected' : '' }}>20日</option>
                        <option value="25" {{ old('closing_date', $site->closing_date) == 25 ? 'selected' : '' }}>25日</option>
                        <option value="99" {{ old('closing_date', $site->closing_date) == 99 ? 'selected' : '' }}>月末</option>
                    </select>
                    @error('closing_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">{{ __('messages.site.status') }}</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="">選択してください</option>
                        <option value="active" {{ old('status', $site->status) == 'active' ? 'selected' : '' }}>{{ __('messages.site.status_active') }}</option>
                        <option value="inactive" {{ old('status', $site->status) == 'inactive' ? 'selected' : '' }}>{{ __('messages.site.status_inactive') }}</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.update') }}</button>
                    <a href="{{ route('sites.index') }}" class="btn btn-secondary">{{ __('messages.common.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
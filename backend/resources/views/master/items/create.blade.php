@extends('layouts.app')

@section('title', __('messages.item.create_title'))

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('messages.item.create_title') }}</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('master.items.store') }}">
                @csrf

                <h5 class="mb-3">{{ __('messages.item.item_info') }}</h5>
                <div class="mb-3">
                    <label for="item_no" class="form-label">{{ __('messages.item.item_no') }}</label>
                    <input type="text" class="form-control @error('item_no') is-invalid @enderror" id="item_no" name="item_no" value="{{ old('item_no') }}" required maxlength="10">
                    @error('item_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="item_name" class="form-label">{{ __('messages.item.item_name') }}</label>
                    <input type="text" class="form-control @error('item_name') is-invalid @enderror" id="item_name" name="item_name" value="{{ old('item_name') }}" required>
                    @error('item_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contract_type" class="form-label">{{ __('messages.item.contract_type') }}</label>
                    <select class="form-select @error('contract_type') is-invalid @enderror" id="contract_type" name="contract_type" required>
                        <option value="">{{ __('messages.common.select') }}</option>
                        <option value="1" {{ old('contract_type') == '1' ? 'selected' : '' }}>{{ __('messages.item.contract_type_rental') }}</option>
                        <option value="2" {{ old('contract_type') == '2' ? 'selected' : '' }}>{{ __('messages.item.contract_type_sale') }}</option>
                    </select>
                    @error('contract_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="weight" class="form-label">{{ __('messages.item.weight') }}</label>
                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}" required>
                    @error('weight')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mb-3 mt-4">{{ __('messages.item.prices') }}</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('messages.item.rank') }}</th>
                                <th>{{ __('messages.item.prices_daily') }}</th>
                                <th>{{ __('messages.item.prices_sale') }}</th>
                                <th>{{ __('messages.item.prices_basic') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A</td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.A.daily') is-invalid @enderror" name="prices[A][daily]" value="{{ old('prices.A.daily') }}" required>
                                    @error('prices.A.daily')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.A.sale') is-invalid @enderror" name="prices[A][sale]" value="{{ old('prices.A.sale') }}" required>
                                    @error('prices.A.sale')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.A.basic_price') is-invalid @enderror" name="prices[A][basic_price]" value="{{ old('prices.A.basic_price') }}" required>
                                    @error('prices.A.basic_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>B</td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.B.daily') is-invalid @enderror" name="prices[B][daily]" value="{{ old('prices.B.daily') }}" required>
                                    @error('prices.B.daily')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.B.sale') is-invalid @enderror" name="prices[B][sale]" value="{{ old('prices.B.sale') }}" required>
                                    @error('prices.B.sale')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.B.basic_price') is-invalid @enderror" name="prices[B][basic_price]" value="{{ old('prices.B.basic_price') }}" required>
                                    @error('prices.B.basic_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>C</td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.C.daily') is-invalid @enderror" name="prices[C][daily]" value="{{ old('prices.C.daily') }}" required>
                                    @error('prices.C.daily')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.C.sale') is-invalid @enderror" name="prices[C][sale]" value="{{ old('prices.C.sale') }}" required>
                                    @error('prices.C.sale')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control @error('prices.C.basic_price') is-invalid @enderror" name="prices[C][basic_price]" value="{{ old('prices.C.basic_price') }}" required>
                                    @error('prices.C.basic_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.create') }}</button>
                    <a href="{{ route('master.items.index') }}" class="btn btn-secondary">{{ __('messages.common.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', __('messages.yard.title'))

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1>{{ __('messages.yard.title') }}</h1>
        <a href="{{ route('master.yard.create') }}" class="btn btn-primary">{{ __('messages.common.new') }}</a>
    </div>

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('master.yard.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="yard_code" class="form-label">{{ __('messages.yard.code') }}</label>
                    <input type="text" class="form-control" id="yard_code" name="yard_code" value="{{ request('yard_code') }}">
                </div>
                <div class="col-md-4">
                    <label for="yard_name" class="form-label">{{ __('messages.yard.name') }}</label>
                    <input type="text" class="form-control" id="yard_name" name="yard_name" value="{{ request('yard_name') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.search') }}</button>
                        <a href="{{ route('master.yard.index') }}" class="btn btn-secondary">{{ __('messages.common.clear_search') }}</a>
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
                            <th>{{ __('messages.yard.code') }}</th>
                            <th>{{ __('messages.yard.name') }}</th>
                            <th>{{ __('messages.yard.phone') }}</th>
                            <th>{{ __('messages.yard.address') }}</th>
                            <th>{{ __('messages.common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($yards as $yard)
                            <tr>
                                <td>{{ $yard->yard_code }}</td>
                                <td>{{ $yard->yard_name }}</td>
                                <td>{{ $yard->yard_phone }}</td>
                                <td>{{ $yard->yard_address }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('master.yard.edit', $yard->yard_code) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil text-white"></i>
                                        </a>
                                        <form action="{{ route('master.yard.destroy', $yard->yard_code) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('{{ __('messages.yard.delete_confirm') }}');"
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
        </div>
    </div>
</div>
@endsection 
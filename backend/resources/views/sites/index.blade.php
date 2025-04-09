@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1>{{ __('messages.site.title') }}</h1>
        <a href="{{ route('sites.create') }}" class="btn btn-primary">{{ __('messages.common.new') }}</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('messages.site.customer_name') }}</th>
                <th>{{ __('messages.site.site_name') }}</th>
                <th>{{ __('messages.site.address') }}</th>
                <th>{{ __('messages.site.phone') }}</th>
                <th>{{ __('messages.site.closing_date') }}</th>
                <th>{{ __('messages.site.status') }}</th>
                <th>{{ __('messages.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sites as $site)
            <tr>
                <td>{{ $site->customer->customer_name }}</td>
                <td>{{ $site->name }}</td>
                <td>{{ $site->address }}</td>
                <td>{{ $site->phone }}</td>
                <td>
                    @if($site->closing_date == 99)
                    月末
                    @else
                    {{ $site->closing_date }}日
                    @endif
                </td>
                <td>
                    @if($site->status == 'active')
                    {{ __('messages.site.status_active') }}
                    @else
                    {{ __('messages.site.status_inactive') }}
                    @endif
                </td>
                <td>
                    <a href="{{ route('sites.edit', $site->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil text-white"></i>
                    </a>
                    <form action="{{ route('sites.destroy', $site->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash text-white"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
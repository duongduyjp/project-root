@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Site Management</h1>
        <a href="{{ route('sites.create') }}" class="btn btn-primary">{{ __('messages.common.new') }}</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Site Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Closing Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sites as $site)
                    <tr>
                        <td>{{ $site->customer->customer_name }}</td>
                        <td>{{ $site->name }}</td>
                        <td>{{ $site->address }}</td>
                        <td>{{ $site->phone }}</td>
                        <td>{{ $site->closing_date }}</td>
                        <td>{{ $site->status }}</td>
                        <td>
                            <a href="{{ route('sites.edit', $site->id) }}" class="btn btn-warning">{{ __('messages.common.edit') }}</a>
                            <form action="{{ route('sites.destroy', $site->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">{{ __('messages.common.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
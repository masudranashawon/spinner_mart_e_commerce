@extends('admin.layouts.app')

@section('content')
{{-- All Customers --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>All Customers</h5>
    </div>

    <div class="card-footer">
        <table class="data-table table-hover table">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Verified</th>
                    <th>Registered Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users ?? [] as $key => $user)
                <tr>
                    <td><img src="{{ $user?->thumbnail }}" alt="{{ $user?->name }}" class="object-fit-cover" style="object-fit:cover;"></td>
                    <td>{{ $user?->name }}</td>
                    <td>{{ $user?->email }}</td>
                    <td>
                        @if ($user?->email_verified_at == null)
                        <span class="badge badge-danger">Not Verified</span>
                        @else
                        <span class="badge badge-success">Verified</span>
                        @endif
                    </td>
                    <td>{{ $user?->created_at?->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="7">No Customer Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

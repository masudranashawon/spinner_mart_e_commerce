@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Newsletter Subscribers</h5>
    </div>

    <div class="card-footer table-responsive">
        <table class="data-table table-hover table">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th>Email Address</th>
                    <th>Subscribed On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($subscribers as $key => $subscriber)
                <tr>
                    <td class="text-center align-middle">{{ $subscribers->firstItem() + $key }}</td>
                    <td class="align-middle fw-bold">{{ $subscriber->email }}</td>
                    <td class="align-middle text-muted">{{ $subscriber->created_at->format('d M, Y h:i A') }}</td>

                    <td class="text-center align-middle">
                        <form action="{{ route('admin.subscribers.status', $subscriber->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="badge {{ $subscriber->is_active ? 'badge-success' : 'badge-danger' }} border-0 px-3 py-2">
                                {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>

                    <td class="text-center align-middle">
                        <a href="{{ route('admin.subscribers.destroy',$subscriber->id) }}" class="delete-confirm btn btn-danger btn-icon btn-md">
                            <i data-feather="trash-2"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No subscribers yet!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

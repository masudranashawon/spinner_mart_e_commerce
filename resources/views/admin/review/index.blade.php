@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>All Reviews</h5>
    </div>

    <div class="card-footer table-responsive">
        <table class="data-table table-hover table">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th>Product</th>
                    <th>Customer</th>
                    <th class="text-center">Rating</th>
                    <th>Review</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reviews ?? [] as $key => $review)
                <tr>
                    <td class="text-center align-middle">{{ $reviews->firstItem() + $key }}</td>

                    <td class="align-middle">
                        <a href="{{ route('productDetails', $review->product->slug) }}" target="_blank" class="text-dark fw-bold text-decoration-none">
                            {{ Str::limit($review->product->name, 30) }}
                        </a>
                    </td>

                    <td class="align-middle">
                        <strong>{{ $review->user->name }}</strong><br>
                        <small class="text-muted">{{ $review->created_at->format('d M, Y') }}</small>
                    </td>

                    <td class="text-center align-middle text-warning">
                        @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)
                            ★
                            @else
                            <span class="text-muted">★</span>
                            @endif
                            @endfor
                    </td>

                    <td class="align-middle">
                        {{ Str::limit($review->review, 50, '...') ?? 'No text review' }}
                    </td>

                    <td class="text-center align-middle">
                        <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="badge {{ $review->is_approved ? 'badge-success' : 'badge-danger' }} border-0 px-3 py-2">
                                {{ $review->is_approved ? 'Approved' : 'Hidden' }}
                            </button>
                        </form>
                    </td>

                    <td class="text-center align-middle">
                        <a href="{{ route('admin.reviews.destroy', $review->id) }}"
                        class="delete-confirm btn btn-danger btn-icon btn-md">
                            <i data-feather="trash-2"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No reviews found!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

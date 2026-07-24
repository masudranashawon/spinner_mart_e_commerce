@extends('admin.layouts.app')

@section('content')
{{-- All Orders --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>All Orders</h5>
    </div>

    <div class="card-footer table-responsive">
        <table class="data-table table-hover table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Order Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders ?? [] as $key => $order)
                @php
                // Billing address
                $billingAddress = $order->addresses->where('address_type', 'billing')->first();
                @endphp

                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>#{{ $order?->order_number }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold">{{ $billingAddress?->name ?? $order->user?->name}}</span>
                            <small class="text-muted">{{ $billingAddress?->phone ?? $order->user?->email }}</small>
                        </div>
                    </td>
                    <td>{{ $order->created_at->format('d M, Y') }}<br><small class="text-muted">{{ $order->created_at->format('h:i A') }}</small></td>
                    <td>
                        <span class="badge badge-light text-dark">{{ $order->items->sum('quantity') }} Qty</span>
                    </td>
                    <td class="fw-bold text-dark">
                        ৳ {{ number_format($order->grand_total, 2) }}
                    </td>

                    {{-- Payment Status Badge --}}
                    <td>
                        <span class="badge 
                                    @if($order->payment_status === 'paid') badge-success 
                                    @elseif($order->payment_status === 'failed') badge-danger 
                                    @elseif($order->payment_status === 'refunded') badge-secondary 
                                    @else badge-warning @endif">
                            {{ $order->payment_status }}
                        </span>
                        <small class="d-block text-muted text-uppercase mt-1">{{ $order->payment_method }}</small>
                    </td>

                    {{-- Order Status Badge --}}
                    <td>
                        <span class="badge text-capitalize 
                                    @switch($order->order_status)
                                        @case('pending') badge-warning @break
                                        @case('confirmed') badge-primary @break
                                        @case('processing') badge-info @break
                                        @case('shipped') badge-dark @break
                                        @case('delivered') badge-success @break
                                        @case('cancelled') badge-danger @break
                                        @case('return_requested') badge-warning @break
                                        @case('returned') badge-secondary @break
                                        @default badge-light
                                    @endswitch
                                ">
                            {{str_replace('_', ' ', $order->order_status)}}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="text-center">
                        <a href="{{ route('admin.order.show',$order->id) }}"><button class="btn btn-secondary btn-icon btn-md"><i data-feather="eye"></i></button></a>
                        <a target="_blank" href="{{ route('admin.order.invoice', $order->order_number) }}"><button class="btn btn-primary btn-icon btn-md"><i data-feather="printer"></i></button></a>
                        <a href="{{ route('admin.order.destroy', $order->id) }}" class="delete-confirm btn btn-danger btn-icon btn-md">
                            <i data-feather="trash-2"></i>
                        </a>
                    </td>
                </tr>

                @empty
                <tr class="text-center">
                    <td colspan="9">No Orders Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

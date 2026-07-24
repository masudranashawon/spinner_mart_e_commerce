@extends('frontend.layouts.app')

@section('title', 'My Orders')

@section('content')

<!-- start wpo-page-title -->
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li>Order</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end page-title -->

<!-- order-area start -->
<div class="order-area section-padding">
    <div class="container">
        <div class="form">
            <div class="order-wrapper">
                <div class="row">
                    <div class="col-12">
                        <form action="#">
                            {{-- Order Table --}}
                            <table class="table align-middle text-nowrap order-wrap w-100">
                                <thead class="text-center w-full">
                                    <tr class="">
                                        <th class="fw-bold images images-b">Order ID</th>
                                        <th class="fw-bold product">Date</th>
                                        <th class="fw-bold ptice">Quantity</th>
                                        <th class="fw-bold ptice">Ship To</th>
                                        <th class="fw-bold">Total Price</th>
                                        <th class="fw-bold remove">Status</th>
                                        <th class="fw-bold action remove-b">Action</th>
                                    </tr>
                                </thead>

                                {{-- Loop through orders --}}
                                <tbody>
                                    @forelse ($orders as $order)
                                    @php
                                    // Safely handle Enum casts
                                    $statusValue = $order->order_status instanceof \BackedEnum ? $order->order_status->value : $order->order_status;
                                    @endphp
                                    <tr>
                                        <td class="images">
                                            #{{ $order->order_number }}
                                        </td>
                                        <td class="product">
                                            {{ $order->created_at->format('d-M-Y') }}
                                        </td>
                                        <td class="ptice">
                                            {{ $order->items->sum('quantity') }} Items
                                        </td>
                                        <td class="name text-truncate" style="max-width: 250px;">
                                            {{ $order->display_address?->address ?? 'N/A' }}
                                        </td>
                                        <td>
                                            ৳ {{ number_format($order->grand_total, 2) }}
                                        </td>

                                        {{-- Order Status --}}
                                        <td class="
                                        @switch($statusValue)
                                        @case('pending') stock @break
                                        @case('confirmed') stock @break
                                        @case('processing') pro @break
                                        @case('shipped') stocks @break
                                        @case('delivered') Del @break
                                        @case('cancelled') can @break
                                        @case('return_requested') can @break
                                        @case('returned') can @break
                                        @default stock
                                        @endswitch">
                                            <span class="text-capitalize" style="width: 140px;">
                                               {{ ucwords(str_replace('_', ' ', $statusValue)) }}
                                            </span>
                                        </td>

                                        <td class="action">
                                            <ul class="d-flex gap-2">
                                                <li class="w-btn-view">
                                                    <a href="{{route('order.show', $order->id)}}" data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fi ti-eye"></i>
                                                    </a>
                                                </li>
                                                <li class="w-btn-view">
                                                    <a target="_blank" href="{{ route('order.invoice', $order->order_number) }}" data-bs-toggle="tooltip" title="Print Invoice">
                                                        <i class="fi ti-printer"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3">
                                            No orders found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
</div>
<!-- order-area end -->
@endsection

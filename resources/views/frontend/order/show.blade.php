@extends('frontend.layouts.app')

@section('title', 'Orders Details')

@section('content')

<!-- start wpo-page-title -->
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="{{route('order.index')}}">Orders</a></li>
                        <li>Order Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end page-title -->

<!-- order detais area start -->
<div class="section-padding">
    <div class="container">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Order #{{ $order->order_number }}</h2>
                <p class="text-muted mb-0">{{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div>
                <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="theme-btn-s2 px-3 py-2 d-inline-block">
                    <i class="ti-printer"></i> Print Invoice
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Order Items Section -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4 border-bottom pb-2">Items Overview</h5>
                        <div>
                            <table class="table table-borderless align-middle">
                                <thead class="text-muted bg-light">
                                    <tr>
                                        <th scope="col" style="border-radius: 8px 0 0 8px;">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-end" style="border-radius: 0 8px 8px 0;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr class="border-bottom">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product?->thumbnail}}" alt="{{ $item->product_name }}" class="rounded" width="60">
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ $item->product_name }}</h6>
                                                    @if($item->variant->sku_code) <small class="text-muted">SKU: {{ $item->variant->sku_code }}</small> @endif
                                                    <p class="text-muted small">
                                                        @php
                                                        $attrs = [];
                                                        if ($item->variant->color?->name) $attrs[] = 'Color: ' . $item->variant->color->name;
                                                        if ($item->variant->size?->name) $attrs[] = 'Size: ' . $item->variant->size->name;
                                                        @endphp

                                                        {{ implode(' | ', $attrs) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>৳{{ number_format($item->price, 2) }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">৳{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        @php
                                        $subtotal = $order->items->sum('subtotal');
                                        @endphp

                                        <tr>
                                            <td class="text-muted">Subtotal:</td>
                                            <td class="text-end fw-bold">৳{{ number_format($subtotal, 2) }}</td>
                                        </tr>

                                        @if($order->has_coupon)
                                        <tr>
                                            <td class="text-muted">Coupon Discount:</td>
                                            <td class="text-end text-danger fw-bold">- ৳{{ number_format($subtotal - $order->grand_total, 2) }}</td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td class="text-muted">Shipping Charge:</td>
                                            <td class="text-success text-end fw-bold">+ ৳{{ number_format($order->shipping_charge, 2) }}</td>
                                        </tr>

                                        <tr class="border-top">
                                            <td class="fs-5 fw-bold text-dark pt-3">Grand Total:</td>
                                            <td class="text-end fs-5 fw-bold text-primary pt-3">৳{{ number_format($order->grand_total + $order->shipping_charge, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <!-- Order Status Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4 border-bottom pb-2">Order Information</h5>

                        <div class="mb-3">
                            <span class="text-muted d-block">Order Status</span>
                            <span class="badge px-3 py-2 text-uppercase rounded-pill
                                        @switch($order->order_status)
                                            @case('pending')
                                                bg-warning text-dark
                                                @break
                                            @case('confirmed')
                                                bg-primary
                                                @break
                                            @case('processing')
                                                bg-info
                                                @break
                                            @case('shipped')
                                                bg-dark
                                                @break
                                            @case('delivered')
                                                bg-success
                                                @break
                                            @case('cancelled')
                                                bg-secondary
                                                @break
                                            @case('returned')
                                                bg-danger
                                                @break
                                            @default
                                                bg-warning
                                        @endswitch
                                        ">
                                {{ $order->order_status }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span class="text-muted d-block">Payment Method</span>
                            <span class="fw-bold text-primary text-uppercase">{{ $order->payment_method }}</span>
                        </div>

                        <div>
                            <span class="text-muted d-block">Payment Status</span>
                            <span class="badge px-3 py-2 text-uppercase rounded-pill
                                        @switch($order->payment_status)
                                            @case('pending')
                                                bg-warning text-dark
                                                @break
                                            @case('paid')
                                                bg-success
                                                @break
                                            @case('failed')
                                                bg-danger
                                                @break
                                            @case('refunded')
                                                bg-danger
                                                @break
                                            @default
                                                bg-warning text-dark
                                        @endswitch
                                        ">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                 @if($order->note)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3 border-bottom pb-2">
                            Order Notes
                        </h5>

                        <blockquote class="border-start border-4 border-warning ps-2 mb-0 text-muted">
                            {{ $order->note }}
                        </blockquote>
                    </div>
                </div>
                @endif

                <!-- Addresses -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Billing Address -->
                        <h5 class="mb-3 border-bottom pb-2">Billing Address</h5>
                        <address class="text-muted mb-4">
                            <p class="d-flex justify-content-between m-0"><span>Name:</span> <strong>{{ $billingAddress->name }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>Address:</span> <strong>{{ $billingAddress->address }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>City:</span> <strong>{{ $billingAddress->city }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>Post Code:</span> <strong>{{ $billingAddress->post_code }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>Country:</span> <strong class="text-capitalize">{{ $billingAddress->country }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>Phone:</span> <strong>{{ $billingAddress->phone }}</strong></p>
                            @if($billingAddress->email)
                            <p class="d-flex justify-content-between m-0"><span>Email:</span> <strong>{{ $billingAddress->email }}</strong></p>
                            @endif
                        </address>

                        <!-- Shipping Address -->
                        <h5 class="mb-3 border-bottom pb-2">Shipping Address</h5>
                        @if($shippingAddress !== null)
                        <address class="text-muted mb-0">
                            <p class="d-flex justify-content-between m-0"><span>Name:</span> <strong>{{ $shippingAddress->name }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>Address:</span> <strong>{{ $shippingAddress->address }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>City:</span> <strong>{{ $shippingAddress->city }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>Post Code:</span> <strong>{{ $shippingAddress->post_code }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>Country:</span> <strong class="text-capitalize">{{ $shippingAddress->country }}</strong></p>
                            <p class="d-flex justify-content-between m-0"><span>Phone:</span> <strong>{{ $shippingAddress->phone }}</strong></p>
                            @if($shippingAddress->email)
                            <p class="d-flex justify-content-between m-0"><span>Email:</span> <strong>{{ $shippingAddress->email }}</strong></p>
                            @endif
                        </address>
                        @else
                        <p class="text-muted mb-0">Same as billing address.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- order detais area end -->

@endsection

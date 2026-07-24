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
                                                <img src="{{ $item?->product?->thumbnail}}" alt="{{ $item->product_name }}" class="rounded" width="60">
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ $item->product_name }}</h6>

                                                    @if($item->sku_code)
                                                    <small class="text-muted">SKU: {{ $item->sku_code }}</small>
                                                    @endif

                                                    <p class="text-muted small">
                                                        {{ $item->variant_name }}
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
                                        <tr>
                                            <td class="text-muted">Subtotal:</td>
                                            <td class="text-end fw-bold">৳{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>

                                        @if($order->coupon_code)
                                        <tr>
                                            <td class="text-muted">Coupon Discount:</td>
                                            <td class="text-end text-danger fw-bold">- ৳{{ number_format($order->discount_amount, 2) }}</td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td class="text-muted">Shipping Charge:</td>
                                            <td class="text-success text-end fw-bold">+ ৳{{ number_format($order->shipping_charge, 2) }}</td>
                                        </tr>

                                        <tr class="border-top">
                                            <td class="fs-5 fw-bold text-dark pt-3">Grand Total:</td>
                                            <td class="text-end fs-5 fw-bold text-primary pt-3">৳{{ number_format($order->grand_total, 2) }}</td>
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
                                            @case('return_requested')
                                                bg-primary
                                                @break
                                            @case('returned')
                                                bg-danger
                                                @break
                                            @default
                                                bg-warning text-dark
                                        @endswitch
                                        ">
                                {{ ucwords(str_replace('_', ' ',$order->order_status)) }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span class="text-muted d-block">Payment Method</span>
                            <span class="fw-bold text-primary text-uppercase"><i class="fa fa-money" aria-hidden="true"></i> {{ $order->payment_method }}</span>
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

                        <!-- Conditional Action Buttons -->
                        <div class="mt-4 border-top pt-3">
                            @if($order->order_status === 'pending')
                            <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                <i class="fa fa-ban" aria-hidden="true"></i> Cancel Order
                            </button>
                            <small class="text-muted d-block text-center mt-2">You can cancel the order before it is confirmed.</small>

                            @elseif($order->order_status === 'delivered')
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#returnOrderModal">
                                <i class="fa fa-undo" aria-hidden="true"></i> Request Return / Refund
                            </button>
                            <small class="text-muted d-block text-center mt-2">You can request a return for this delivered order.</small>

                            @elseif($order->order_status === 'return_requested')
                            <div class="alert alert-warning text-center mb-0">
                                Your return request is currently under review by our team.
                            </div>

                            @elseif($order->order_status === 'cancelled')
                            <div class="alert alert-danger text-center mb-0">
                                <strong>Cancel Reason:</strong><br>
                                {{ $order->cancel_reason ?? 'No reason provided.' }}
                            </div>
                            @endif
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

<!-- Return Request Modal -->
<div class="reason-input-modal modal fade" id="returnOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('order.return', $order->id) }}" method="POST" class="w-100">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Return/Refund</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="return_reason" class="form-label text-danger">What is the issue with your order? *</label>
                        <textarea class="form-control" name="return_reason" id="return_reason" rows="3" required placeholder="e.g. Product is damaged, wrong size..."></textarea>
                    </div>
                    <p class="text-muted small mb-0">Our support team will review your request and contact you soon.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Cancel Order Modal Start  -->
<div id="cancelOrderModal" class="reason-input-modal modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="w-100">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label text-info">Why are you cancelling this order? *</label>
                        <textarea class="form-control" name="cancel_reason" id="cancel_reason" rows="3" required placeholder="Please write a valid reason..."></textarea>
                    </div>
                    <p class="text-muted small mb-0">Note: Cancelling the order cannot be undone.</p>
                </div>

                <div class="modal-footer position-relative">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Confirm Cancellation</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Cancel Order Modal End -->
</div>

<style>
    .reason-input-modal button.btn-close {
        top: 15px !important;
        right: 15px !important;
        width: 28px !important;
        height: 28px !important;
        border-radius: 0.25rem !important;
        line-height: 0px !important;
    }
</style>

@endsection

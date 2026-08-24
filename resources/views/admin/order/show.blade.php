@extends('admin.layouts.app')

@php
use App\Enums\OrderStatusEnums;
use App\Enums\PaymentStatusEnums;
@endphp

@push('style')
<style>
    .order-summary-table td {
        border-top: none;
        padding: 0.5rem 0;
    }

    .order-summary-table .border-top td {
        border-top: 1px solid #dee2e6 !important;
    }

    .icon-sm {
        width: 14px;
        height: 14px;
    }

    .order-info-card {
        border-radius: 12px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #eef1f5;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row small {
        font-size: 12px;
        letter-spacing: .3px;
    }

    .badge {
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 30px;
    }

    .btn-outline-primary {
        min-width: 90px;
    }

    .order-note {
        background: #f8f9fc;
        border-left: 4px solid #727cf5;
        padding: 14px;
        border-radius: 8px;
    }

    .order-note p {
        color: #495057;
        margin: 0;
    }

</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Order Details #{{ $order->order_number }}</h4>
            <span class="text-muted">Placed on {{ $order->created_at->format('d M, Y h:i A') }}</span>
        </div>

        <div>
            <a href="{{ route('admin.order.index') }}" class="btn btn-secondary mr-2">
                <i data-feather="arrow-left" class="icon-sm mr-1"></i> Back to Orders
            </a>
            <a href="{{ route('admin.order.invoice', $order->order_number) }}" target="_blank" class="btn btn-primary">
                <i data-feather="printer" class="icon-sm mr-1"></i> Print Invoice
            </a>
        </div>
    </div>

    <!-- Warning/Info Alerts for Cancelled or Returned Orders -->
    @if($order->order_status === OrderStatusEnums::CANCELLED->value && $order->cancel_reason)
    <div class="alert alert-danger shadow-sm">
        <strong><i data-feather="alert-circle" class="icon-sm mr-1"></i> Cancel Reason:</strong> {{ $order->cancel_reason }}
    </div>
    @elseif($order->order_status === OrderStatusEnums::RETURN_REQUESTED->value)
    <div class="alert alert-danger shadow-sm">
        <strong><i data-feather="alert-triangle" class="icon-sm mr-1"></i> Return Requested! Reason:</strong> {{ $order->return_reason }}
    </div>
    @elseif($order->order_status === OrderStatusEnums::RETURNED->value)
    <div class="alert alert-danger shadow-sm">
        <strong><i data-feather="alert-triangle" class="icon-sm mr-1"></i> Return Reason:</strong> {{ $order->return_reason }}
    </div>
    @endif

    <!-- If admin changes order status to returned, show return reason -->
    @if ($order->return_reason !== null && $order->order_status !== OrderStatusEnums::RETURN_REQUESTED->value && $order->order_status !== OrderStatusEnums::RETURNED->value)
    <div class="alert alert-danger shadow-sm">
        <strong><i data-feather="alert-triangle" class="icon-sm mr-1"></i> Return Requested! Reason:</strong> {{ $order->return_reason }}
    </div>
    @endif

    <div class="row align-items-start">
        <!-- Order & Payment Status Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 order-info-card h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-bold">
                        <i data-feather="shopping-bag" class="icon-sm mr-2"></i>
                        Order & Payment
                    </h5>
                </div>

                <div class="card-body">
                    <div class="info-row">
                        <div>
                            <small class="text-muted d-block">Order Status</small>

                            <span class="badge text-capitalize
                        @switch($order->order_status)
                            @case('pending') badge-warning @break
                            @case('confirmed') badge-primary @break
                            @case('processing') badge-info @break
                            @case('shipped') badge-dark @break
                            @case('delivered') badge-success @break
                            @case('cancelled') badge-danger @break
                            @case('return_requested') badge-danger-muted text-white @break
                            @case('returned') badge-danger @break
                        @endswitch">
                                {{ str_replace('_',' ',$order->order_status) }}
                            </span>
                        </div>

                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#orderStatusModal">
                            <i data-feather="edit-2" class="icon-xs mr-1"></i>
                            Update
                        </button>
                    </div>

                    {{-- Payment Method --}}
                    <div class="info-row">
                        <div>
                            <small class="text-muted d-block">
                                Payment Method
                            </small>

                            <strong class="text-uppercase">
                                <i data-feather="shield" class="icon-xs mr-1"></i>
                                {{ $order->payment_method }}
                            </strong>
                        </div>
                    </div>

                    {{-- Payment Status --}}
                    <div class="info-row border-0 pb-0">
                        <div>
                            <small class="text-muted d-block">
                                Payment Status
                            </small>

                            <span class="badge text-capitalize
                        @if($order->payment_status=='paid')
                            badge-success
                        @elseif($order->payment_status=='failed')
                            badge-danger
                        @elseif($order->payment_status=='refunded')
                            badge-secondary
                        @else
                            badge-warning
                        @endif">
                                {{ $order->payment_status }}

                            </span>
                        </div>

                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#paymentStatusModal">
                            <i data-feather="edit-2" class="icon-xs mr-1"></i>
                            Update
                        </button>
                    </div>

                    <!-- Order Note -->
                    @if($order->note)
                    <div class="order-note mt-4">
                        <h6 class="fw-bold mb-2">
                            <i data-feather="file-text" class="icon-xs mr-1"></i>
                            Order Note
                        </h6>
                        <p class="mb-0">
                            {{ $order->note }}
                        </p>
                    </div>
                    @endif

                    <!-- Tracking Note -->
                    @if($order->tracking_note)
                    <div class="order-note mt-3" style="border-left-color: #17a2b8;">
                        <h6 class="fw-bold mb-2">
                            <i data-feather="truck" class="icon-xs mr-1"></i> Tracking Information
                        </h6>
                        <p class="mb-0">{{ $order->tracking_note }}</p>
                    </div>
                    @endif

                    <!-- Admin Note (Private) -->
                    @if($order->admin_note)
                    <div class="order-note mt-3" style="border-left-color: #dc3545; background: #fff5f5;">
                        <h6 class="fw-bold mb-2 text-danger">
                            <i data-feather="lock" class="icon-xs mr-1"></i> Admin Note (Private)
                        </h6>
                        <p class="mb-0 text-danger">{{ $order->admin_note }}</p>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Billing Address Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white pb-0 border-0 pt-4">
                    <h6 class="fw-bold mb-0"><i data-feather="map" class="icon-sm mr-2"></i> Billing Address</h6>
                </div>
                <div class="card-body text-muted">
                    <strong class="text-dark d-block mb-1">{{ $billingAddress?->name ?? 'N/A' }}</strong>
                    <p class="mb-1">{{ $billingAddress?->address }}</p>
                    <p class="mb-1">{{ $billingAddress?->city }}, {{ $billingAddress?->post_code }}</p>
                    <p class="mb-2 text-capitalize">{{ $billingAddress?->country }}</p>
                    <p class="mb-0"><a href="tel:{{$billingAddress?->phone}}"><i data-feather="phone" class="icon-sm mr-1"></i> {{ $billingAddress?->phone }}</a></p>
                    @if($billingAddress?->email)
                    <p class="mb-0"><a href="mailto:{{$billingAddress?->email}}"><i data-feather="mail" class="icon-sm mr-1"></i> {{ $billingAddress?->email }}</a></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Shipping Address Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white pb-0 border-0 pt-4">
                    <h6 class="fw-bold mb-0"><i data-feather="map-pin" class="icon-sm mr-2"></i> Shipping Address</h6>
                </div>
                <div class="card-body text-muted">
                    @if($shippingAddress)
                    <strong class="text-dark d-block mb-1">{{ $shippingAddress?->name ?? 'N/A' }}</strong>
                    <p class="mb-1">{{ $shippingAddress?->address }}</p>
                    <p class="mb-1">{{ $shippingAddress?->city }}, {{ $shippingAddress?->post_code }}</p>
                    <p class="mb-2 text-capitalize">{{ $shippingAddress?->country }}</p>
                    <p class="mb-0"><a href="tel:{{$shippingAddress?->phone}}"><i data-feather="phone" class="icon-sm mr-1"></i> {{ $shippingAddress?->phone }}</a></p>
                    @if($shippingAddress?->email)
                    <p class="mb-0"><a href="mailto:{{$shippingAddress?->email}}"><i data-feather="mail" class="icon-sm mr-1"></i> {{ $shippingAddress?->email }}</a></p>
                    @endif
                    @else
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <span class="text-muted font-italic">Same as Billing Address</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items & Calculation -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white pt-4 pb-3">
            <h6 class="fw-bold mb-0"><i data-feather="list" class="icon-sm mr-2"></i> Order Items</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="pl-4">Product Details</th>
                            <th scope="col" class="text-center">Price</th>
                            <th scope="col" class="text-center">Qty</th>
                            <th scope="col" class="text-right pr-4">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="pl-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->product?->thumbnail}}" alt="Product" class="rounded border" width="50" height="50" style="object-fit: cover;">
                                    <div class="ml-3">
                                        <h6 class="mb-1 text-dark">{{ $item->product_name }}</h6>
                                        @if($item->sku_code)
                                        <p class="text-muted d-block">SKU: {{ $item->sku_code }}</p>
                                        @endif
                                        @if($item->variant_name && $item->variant_name !== 'Default Variant')
                                        <p class="text-muted d-block">{{ $item->variant_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle">{{ format_price($item->price) }}</td>
                            <td class="text-center align-middle">{{ $item->quantity }}</td>
                            <td class="text-right pr-4 align-middle fw-bold">{{ format_price($item->subtotal) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white pt-4 pb-4">
            <div class="row justify-content-end">
                <div class="col-md-5 col-lg-4">
                    <table class="table order-summary-table mb-0 w-100">
                        <tbody>
                            <tr>
                                <td class="text-muted fw-bold">Subtotal:</td>
                                <td class="text-right text-dark">{{ format_price($order->subtotal) }}</td>
                            </tr>

                            @if($order->vat_amount > 0)
                            <tr>
                                <td class="text-muted fw-bold">Vat:</td>
                                <td class="text-right text-dark">+ {{ format_price($order->vat_amount) }}</td>
                            </tr>
                            @endif

                            @if($order->coupon_code)
                            <tr>
                                <td class="text-muted fw-bold">Coupon Discount ({{ $order->coupon_code }}):</td>
                                <td class="text-right text-danger">- {{ format_price($order->discount_amount) }}</td>
                            </tr>
                            @endif

                            <tr>
                                <td class="text-muted fw-bold">Shipping Charge:</td>
                                <td class="text-right text-success">+ {{ format_price($order->shipping_charge) }}</td>
                            </tr>
                            <tr class="border-top">
                                <td class="fw-bold text-dark pt-3 pb-0" style="font-size: 16px;">Grand Total:</td>
                                <td class="text-right fw-bold text-primary pt-3 pb-0" style="font-size: 18px;">{{ format_price($order->grand_total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Update Order Status -->
<div class="modal fade" id="orderStatusModal" tabindex="-1" role="dialog" aria-labelledby="orderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('admin.order.status.update', $order->id) }}" method="POST" class="w-100">
            @csrf
            @method('PUT')
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="orderStatusModalLabel">Update Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="form-group">
                        <label for="order_status" class="fw-bold text-muted">Select New Status</label>
                        <select name="order_status" id="order_status" class="form-control text-capitalize">
                            @foreach(OrderStatusEnums::cases() as $status)
                            <option value="{{ $status->value }}" {{ $order->order_status === $status->value ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', $status->value) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    @if($order->cancel_reason === null)
                    <div class="mb-3" id="cancel_reason_box" style="display:none;">
                        <label for="cancel_reason" class="form-label text-muted">Why are you cancelling this order?</label>
                        <textarea class="form-control" name="cancel_reason" id="cancel_reason" rows="3" placeholder="Please write a valid reason..."></textarea>
                    </div>
                    @endif

                    <div class="mb-3" id="tracking_note_box" style="display:none;">
                        <label for="tracking_note" class="form-label text-muted">Tracking Note / Courier Info</label>
                        <input type="text" class="form-control" name="tracking_note" id="tracking_note" value="{{ $order->tracking_note }}" placeholder="e.g. Pathao ID: 123456">
                    </div>

                    <div class="mb-3">
                        <label for="admin_note" class="form-label text-muted">Admin Note (Private)</label>
                        <textarea class="form-control" name="admin_note" id="admin_note" rows="2" placeholder="Private note for internal use only...">{{ $order->admin_note }}</textarea>
                    </div>

                    <p class="small text-muted mb-0"><i data-feather="info" class="icon-sm mr-1"></i> Note: Cancelling or Returning an order will automatically restore product inventory stock.</p>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Update Payment Status -->
<div class="modal fade" id="paymentStatusModal" tabindex="-1" role="dialog" aria-labelledby="paymentStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('admin.order.payment.update', $order->id) }}" method="POST" class="w-100">
            @csrf
            @method('PUT')
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="paymentStatusModalLabel">Update Payment Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="form-group">
                        <label for="payment_status" class="fw-bold text-muted">Select Payment Status</label>
                        <select name="payment_status" id="payment_status" class="form-control text-capitalize">
                            @foreach(PaymentStatusEnums::cases() as $payment)
                            <option value="{{ $payment->value }}" {{ $order->payment_status === $payment->value ? 'selected' : '' }}>
                                {{ $payment->value }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Toggle Cancel Reason Fields
        function toggleReasonFields() {
            let status = $('#order_status').val();

            $('#cancel_reason_box').hide();
            $('#tracking_note_box').hide();

            // Show cancel reason box for cancelled orders
            if (status === 'cancelled') {
                $('#cancel_reason_box').show();
            }

            // Show tracking note box for shipped and delivered orders
            if (status === 'shipped' || status === 'delivered') {
                $('#tracking_note_box').show();
            }
        }

        // Select change
        $(document).on('change', '#order_status', function() {
            toggleReasonFields();
        });

        // Change in Modal
        $('#orderStatusModal').on('shown.bs.modal', function() {
            toggleReasonFields();
        });
    });

</script>
@endpush

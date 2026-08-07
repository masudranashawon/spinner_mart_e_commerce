<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - #{{ $order?->order_number }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Base Styles */
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .invoice-container {
            max-width: 210mm; /* A4 Paper Width */
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-top: 5px solid #FED700;
            border-radius: 8px;
        }

        /* Monospace for amounts alignment */
        .amount-text {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 15px;
            font-weight: 500;
        }

        .company-logo {
            height: 54px;
            width: auto;
            object-fit: contain;
            margin-bottom: 20px;
        }

        /* Typography & Spacing */
        .invoice-title {
            font-size: 36px;
            font-weight: 300;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        /* Tables */
        .table th {
            background-color: #f8f9fa !important;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 13px;
        }

        .table td {
            vertical-align: middle;
        }

        /* Grand Total Styles - Print Safe */
        .grand-total-row {
            font-size: 18px;
            font-weight: 700;
        }

        .grand-total-row td {
            border-top: 1px solid #495057 !important;
            color: #000 !important;
            padding-top: 15px !important;
            font-weight: bold;
        }

        /* Order Note Styles */
        .order-note {
            background-color: #f8f9fa;
            border-left: 4px solid #FED700;
            padding: 15px;
            border-radius: 4px;
            font-size: 14px;
        }

        .order-note-title {
            font-weight: 700;
            color: #495057;
            text-transform: uppercase;
            font-size: 12px;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .footer {
            border-top: 1px solid #FED700;
        }

        /* Print Media Styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }

            body {
                background-color: #fff;
                margin: 0;
                padding: 0;
            }

            .invoice-container {
                margin: 0;
                padding: 10px;
                box-shadow: none;
                border: none;
                max-width: 100%;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            /* Force browsers to print background colors properly */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Hide URL links when printing */
            a[href]:after {
                content: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Action Buttons (Hidden on Print) -->
    <div class="no-print text-center mt-4 mb-3">
        <button onclick="window.print()" class="btn btn-warning px-4 me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-2" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
            </svg>
            Print Invoice
        </button>

        <button onclick="window.close()" class="btn btn-secondary px-4">Close Window</button>
    </div>

    <!-- Main Invoice Container -->
    <div class="invoice-container">

        <!-- Header Section -->
        <div class="row align-items-center mb-5">
            <!-- Company Info (Static for now) -->
            <div class="col-sm-7">
                <img class="company-logo" src="{{asset('frontend/assets/images/logo.svg')}}" alt="">
                <p class="mb-0 text-muted">Shop No 214, 1st Floor, Khulshi Town Center,</p>
                <p class="mb-0 text-muted">South Khulshi, Chittagong, Bangladesh, 4202.</p>
                <p class="mb-0 text-muted">Phone: +880 01805-996980</p>
                <p class="mb-0 text-muted">Email: spinnerfashionbd@gmail.com</p>
            </div>

            <!-- Invoice Details -->
            <div class="col-sm-5 text-sm-end mt-sm-0">
                <h2 class="invoice-title">Invoice</h2>
                <div class="text-muted">
                    <p class="mb-1"><strong class="text-dark text-uppercase">Order No:</strong> #{{ $order?->order_number }}</p>
                    <p class="mb-1"><strong class="text-dark text-uppercase">Date:</strong> {{ $order?->created_at->format('M d, Y h:i A') }}</p>
                    <p class="mb-1"><strong class="text-dark text-uppercase">Payment Method:</strong> <span class="text-uppercase">{{ $order?->payment_method }}</span></p>
                    <p class="mb-0"><strong class="text-dark text-uppercase">Payment Status:</strong>
                        <span class="fw-bold text-uppercase 
                            @if($order?->payment_status == 'paid') text-success 
                            @elseif($order?->payment_status == 'failed') text-danger 
                            @else text-warning @endif">
                            {{ $order?->payment_status }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Address Section -->
        <div class="row mb-5">
            <!-- Billing Info -->
            <div class="col-sm-6">
                <h5 class="section-title">Billing To:</h5>
                <p class="m-0"><strong>{{ $billingAddress?->name }}</strong></p>
                <p class="m-0">{{ $billingAddress?->address }}</p>
                <p class="m-0">{{ $billingAddress?->city }}, {{ $billingAddress?->post_code }}</p>
                <p class="m-0 text-capitalize">{{ $billingAddress?->country }}</p>
                <p class="m-0">Phone: {{ $billingAddress?->phone }}</p>
                @if($billingAddress?->email)
                <p class="mb-0">Email: {{ $billingAddress?->email }}</p>
                @endif
            </div>

            <!-- Shipping Info -->
            <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                <h5 class="section-title text-sm-end">Shipping To:</h5>
                @if($shippingAddress !== null)
                <p class="m-0"><strong>{{ $shippingAddress?->name }}</strong></p>
                <p class="m-0">{{ $shippingAddress?->address }}</p>
                <p class="m-0">{{ $shippingAddress?->city }}, {{ $shippingAddress?->post_code }}</p>
                <p class="m-0 text-capitalize">{{ $shippingAddress?->country }}</p>
                <p class="m-0">Phone: {{ $shippingAddress?->phone }}</p>
                @if($shippingAddress?->email)
                <p class="mb-0">Email: {{ $shippingAddress?->email }}</p>
                @endif
                @else
                <p class="mt-2 text-muted"><em>Same as billing address</em></p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-responsive mb-3">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="45%">Product Description</th>
                        <th width="15%" class="text-end">Unit Price</th>
                        <th width="15%" class="text-center">Qty</th>
                        <th width="20%" class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>

                    @php $subtotal = 0; @endphp
                    @foreach($order?->items as $index => $item)
                    @php $subtotal += $item?->subtotal; @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong class="d-block text-dark">{{ $item?->product_name }}</strong>

                            @if($item?->sku_code)
                            <small class="text-muted d-block">SKU: {{ $item?->sku_code }}</small>
                            @endif

                            @if($item?->variant_name && $item?->variant_name !== 'Default Variant')
                            <small class="text-muted">{{ $item?->variant_name }}</small>
                            @endif
                        </td>
                        <td class="text-end amount-text">{{ format_price($item?->price) }}</td>
                        <td class="text-center">{{ $item?->quantity }}</td>
                        <td class="text-end fw-bold amount-text">{{ format_price($item?->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="row mb-5">
            <!-- Order Note -->
            <div class="col-5">
                @if($order?->note)
                <div class="order-note mt-2">
                    <div class="order-note-title">Special Instructions:</div>
                    <p class="mb-0 text-muted">{{ $order?->note }}</p>
                </div>
                @endif
            </div>

            <!-- Grand Total -->
            <div class="col-7">
                <table class="table table-borderless table-sm mb-0">
                    <tbody>
                        <tr>
                            <td class="text-end text-muted"><strong>Subtotal:</strong></td>
                            <td class="text-end amount-text" width="35%">{{ format_price($order?->subtotal) }}</td>
                        </tr>
                        @if($order?->coupon_code)
                        <tr>
                            <td class="text-end text-muted"><strong>Coupon Discount ({{ $order->coupon_code }}):</strong></td>
                            <td class="text-end amount-text text-danger">- {{ format_price($order?->discount_amount) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-end text-muted"><strong>Shipping Charge:</strong></td>
                            <td class="text-end amount-text">+ {{ format_price($order?->shipping_charge) }}</td>
                        </tr>
                        <tr class="grand-total-row">
                            <td class="text-end">Grand Total:</td>
                            <td class="text-end amount-text">{{ format_price($order?->grand_total) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer row mt-5 pt-4">
            <div class="col-12 text-center text-muted">
                <h5 class="text-dark mb-1">Thank You For Your Business!</h5>
                <p class="small mb-0">If you have any questions about this invoice, please contact our support team.</p>
                <p class="small mt-1"><strong id="invoice-domain"></strong></p>
            </div>
        </div>

    </div>

    <!-- Auto Print Script -->
    <script>
        window.onload = function() {
            // Slight delay ensures styles and fonts load properly before print dialog triggers
            setTimeout(function() {
                document.getElementById("invoice-domain").textContent = window.location.host;

                window.print();
            }, 300);
        };

    </script>
</body>
</html>

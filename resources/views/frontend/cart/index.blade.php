@extends('frontend.layouts.app')

@section('title', 'Cart')

@section('content')

<!-- start wpo-page-title -->
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        @php
        $count = count($cartItems);
        @endphp

        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('shop') }}">Product Page</a></li>
                        <li>Cart</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end page-title -->

<!-- cart-area-s2 start -->
<div class="cart-area-s2 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Cart</h2>
                    <p>
                        @if($count > 0)
                        There {{ $count == 1 ? 'is' : 'are' }} {{ $count }}
                        {{ $count == 1 ? 'product' : 'products' }} in the cart.
                        @else
                        There is no product in the cart.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if($count > 0)
        <div class="cart-wrapper">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <form action="#">
                        <div class="cart-item">
                            <table class="table-responsive cart-wrap">
                                <thead>
                                    <tr>
                                        <th class="images images-b">Product</th>
                                        <th class="ptice">Price</th>
                                        <th class="stock">Quantity</th>
                                        <th class="ptice total">Subtotal</th>
                                        <th class="remove remove-b">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $cart)
                                    @php
                                    $price =
                                    $cart->variant->discount_price > 0
                                    ? $cart->variant->discount_price
                                    : $cart->variant->selling_price;
                                    $subTotal = $price * $cart->quantity;
                                    @endphp
                                    <tr class="wishlist-item">
                                        <td class="product-item-wish">
                                            <div class="check-box"><input type="checkbox" class="myproject-checkbox">
                                            </div>
                                            <div class="images">
                                                <a class="w-100 h-100 d-block" href="{{ route('productDetails', $cart->product->slug) }}">
                                                    <img src="{{ asset($cart->product->thumbnail) }}" alt="{{ $cart->product->name }}" class="img-fluid w-100 h-100 object-fit-contain">
                                                </a>
                                            </div>
                                            <div class="product" style="width: 14rem;">
                                                <ul>
                                                    <li class="first-cart">
                                                        <a style="color:#233D50;" href="{{ route('productDetails', $cart->product->slug) }}">
                                                            {{ $cart->product->name }}
                                                        </a>
                                                    </li>

                                                    <li class="text-muted d-block">
                                                        @php
                                                        $attrs = [];
                                                        if ($cart->variant->color?->name) $attrs[] = 'Color: ' . $cart->variant->color->name;
                                                        if ($cart->variant->size?->name) $attrs[] = 'Size: ' . $cart->variant->size->name;
                                                        @endphp

                                                        {{ implode(' | ', $attrs) }}
                                                    </li>

                                                    <li>
                                                        <div class="rating-product">
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <span>{{$cart->product->rating}}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="ptice">
                                            @if($cart->variant->discount_price)
                                            <del class="me-1">৳{{ number_format($cart->variant->selling_price,2) }}</del>
                                            ৳{{ number_format($cart->variant->discount_price,2) }}
                                            @else
                                            ৳{{ number_format($cart->variant->selling_price,2) }}
                                            @endif
                                        </td>

                                        <td class="td-quantity">
                                            <div class="quantity cart-plus-minus" data-cart-id="{{$cart->id}}" data-product-id="{{ $cart->product_id }}" data-variant-id="{{$cart->product_variant_id}}" data-product-price="{{ $cart->variant?->discount_price > 0 ? $cart->variant?->discount_price : $cart->variant?->selling_price }}">
                                                <input name="quantity" class="text-value" type="text" readonly value="{{ old('quantity', $cart->quantity) }}">
                                                <div class="dec qtybutton">-</div>
                                                <div class="inc qtybutton">+</div>
                                            </div>
                                        </td>

                                        {{-- <td class="ptice">
                                            @php
                                            $total = $cart->quantity * ($cart->variant->discount_price ?? $cart->variant->selling_price);
                                            @endphp
                                            ৳{{ number_format($total,2) }}
                                        </td> --}}
                                        <td class="ptice subtotal{{$cart->id}}">৳{{number_format($subTotal,2)}}</td>
                                        <td class="action">
                                            <ul>
                                                <li class="w-btn">
                                                    <button class="btn delete-cart" type="button" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Remove from Cart" aria-label="Remove from Cart" data-id="{{ $cart->id }}">
                                                        <i class="fi ti-trash fs-3"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-action">
                            <div class="apply-area">
                                <input type="text" class="form-control" placeholder="Enter your coupon" id="couponCodeInput">
                                <button type="button" class="theme-btn-s2" id="couponApplyBtn">Apply</button>
                            </div>
                            <a class="theme-btn-s2" href="{{route("cart.index")}}"><i class="fi flaticon-refresh"></i> Update Cart</a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="cart-total-wrap">
                        <h3>Cart Totals</h3>
                        <div class="sub-total">
                            <h4>Subtotal</h4>
                            <span>৳<span id="subTotalPrice">{{ $cartItems->sum('total') ?? 0 }}</span></span>
                        </div>
                        <div class="sub-total my-3">
                            <h4>Discount</h4>
                            <span id="couponDiscount">৳00.00</span>
                        </div>
                        <div class="total mb-3">
                            <h4>Total</h4>
                            <span id="totalPrice">৳{{ $cartItems->sum('total') ?? 0 }}</span>
                        </div>

                         {{-- Proceed to Checkout --}}
                        <a href="{{ route('checkout.index') }}" class="theme-btn-s2 btn">Proceed To CheckOut</a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center mt-5">
            <h2>No Product in the Cart</h2>
            <div class="shop-btn d-flex justify-content-center mt-3">
                <a class="theme-btn-s2" href="{{route('shop')}}">Shop Now</a>
            </div>
        </div>
        @endif

        <div class="cart-prodact">
            <h2>You May be Interested in…</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="assets/images/interest-product/1.png" alt="">
                            <div class="tag new">New</div>
                        </div>
                        <div class="text">
                            <h2><a href="product-single.html">Wireless Headphones</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>130</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$120.00</span>
                                <del class="old-price">$200.00</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="product.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="assets/images/interest-product/2.png" alt="">
                            <div class="tag sale">Sale</div>
                        </div>
                        <div class="text">
                            <h2><a href="product-single.html">Blue Bag with Lock</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>120</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$160.00</span>
                                <del class="old-price">$190.00</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="product.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="assets/images/interest-product/3.png" alt="">
                            <div class="tag new">New</div>
                        </div>
                        <div class="text">
                            <h2><a href="product-single.html">Stylish Pink Top</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>150</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$150.00</span>
                                <del class="old-price">$200.00</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="product.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="assets/images/interest-product/4.png" alt="">
                            <div class="tag sale">Sale</div>
                        </div>
                        <div class="text">
                            <h2><a href="product-single.html">Brown Com Boots</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>120</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$120.00</span>
                                <del class="old-price">$150.00</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="product.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-area end -->
@endsection

@push('script')
<script>
    let activeCoupon = null; 

    // Unified function to calculate and update the DOM
    function calculateCartTotals() {
        let currentSubtotal = 0;

        // Loop through .cart-plus-minus to correctly access the data attributes
        $('.cart-plus-minus').each(function() {
            let qty = parseInt($(this).find('input').val());
            let price = parseFloat($(this).data('product-price'));
            
            if (!isNaN(qty) && !isNaN(price)) {
                currentSubtotal += (qty * price);
            }
        });

        $("#subTotalPrice").text(currentSubtotal.toFixed(2));

        // Calculate Discount if a coupon is active
        let discountAmount = 0;
        if (activeCoupon) {
            if (currentSubtotal >= activeCoupon.min_amount) {
               if (activeCoupon.type === 'percentage') {
                    discountAmount = (currentSubtotal * activeCoupon.discount) / 100;
                } else { // FIXED
                    discountAmount = activeCoupon.discount;
                }
            } else {
                // If user reduces quantity and subtotal drops below coupon minimum
                Toast.fire({
                    icon: 'warning',
                    title: `Subtotal dropped below ৳${activeCoupon.min_amount}. Coupon removed.`
                });
                activeCoupon = null; 
                $("#couponCodeInput").val(""); 
            }
        }

        $("#couponDiscount").text("৳" + discountAmount.toFixed(2));

        // Calculate Final Total
        let finalTotal = currentSubtotal - discountAmount;
        $("#totalPrice").text("৳" + finalTotal.toFixed(2)); 
    }

    $(document).ready(function() {
        // Initial Calculation on Page Load just in case Blade total is out of sync
        calculateCartTotals();

        // Quantity Buttons
        $(".qtybutton").on("click", function() {
            const $button = $(this);
            const productId = $button.closest('[data-product-id]').data('product-id');
            const productPrice = parseFloat($button.closest('[data-product-price]').data('product-price'));
            const variantId = $button.closest('[data-variant-id]').data('variant-id');
            const cartId = $button.closest('[data-cart-id]').data('cart-id');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            // We use a tiny 50ms delay (setTimeout) to guarantee the Theme's JS 
            // finishes updating the input value before we try to read it.
            setTimeout(() => {
                let $input = $button.parent().find("input");
                let quantity = parseInt($input.val());

                // Failsafe: don't let it go below 1 for the database
                if (quantity <= 1) {
                    quantity = 1;
                    $input.val(1);
                }

                // Update the specific row's subtotal instantly
                const itemSubtotal = quantity * productPrice;
                $('.subtotal' + cartId).text('৳ ' + itemSubtotal.toFixed(2));

                // Recalculate full cart totals instantly
                calculateCartTotals();

                // Send AJAX to update the DB silently in the background
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "POST",
                    data: {
                        _token: csrfToken,
                        product_id: productId,
                        product_variant_id: variantId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (!response.status) {
                            Toast.fire({ icon: "error", title: response.message });
                        }
                    },
                    error: function() {
                        Toast.fire({ icon: "error", title: "Failed to update database!" });
                    }
                });
            }, 50); // 50ms is instant to the human eye, but gives the DOM enough time
        });

        
        // Coupon Code Apply
        $("#couponApplyBtn").on("click", function(e) {
            e.preventDefault();

            let couponCode = $("#couponCodeInput").val();

            if(couponCode == "" || couponCode.length <= 2) return;

            $.ajax({
                url: '{{route("cart.coupon.apply")}}',
                method: "POST",
                data: {
                    couponCode: couponCode,
                    _token: '{{ csrf_token() }}',
                }, 
                success: function(response) {
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });

                    // Store config to maintain real-time calculations on qty change
                    activeCoupon = {
                        id: response.coupon_id,
                        type: response.coupon_type,
                        discount: parseFloat(response.discount_value),
                        min_amount: parseFloat(response.min_amount)
                    };

                    // Trigger UI update
                    calculateCartTotals();

                    $("#couponCodeInput").val("");
                    $(".qtybutton").css("pointer-events", "none");
                    $(".delete-cart").css("pointer-events", "none");

                }, 
                error: function(error) {
                    Toast.fire({
                        icon: "error",
                        title: error?.responseJSON?.message || "Invalid Coupon"
                    });
                }
            });
        });
        
    });
</script>

<script>
    $(document).ready(function() {
        $('.delete-cart').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('cart.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cart item removed successfully!',
                        showConfirmButton: false,
                        timer: 1800,
                        timerProgressBar: true
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Failed to remove item!',
                        showConfirmButton: false,
                        timer: 2200
                    });
                }
            });
        });
    });

</script>
@endpush

@extends('frontend.layouts.app')

@section('title', 'Checkout')

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
                        <li><a href="{{route('cart.index')}}">Cart</a></li>
                        <li>Checkout</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- wpo-checkout-area start-->
<div class="wpo-checkout-area section-padding">
    <div class="container">
        @php
        $count = count($cartItems);
        @endphp

        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Checkout</h2>
                    <p>
                        @if($count > 0)
                        There {{ $count == 1 ? 'is' : 'are' }} {{ $count }}
                        {{ $count == 1 ? 'product' : 'products' }} in this list.
                        @else
                        There is no product for checkout.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if($count > 0)
        <form action="{{route('order.store')}}" method="POST">
            @csrf

            <div class="checkout-wrap">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="caupon-wrap s3">
                            <div class="biling-item">
                                <div class="coupon coupon-3">
                                    <h2>Billing Address</h2>
                                </div>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="billing-adress">
                                    <div class="contact-form form-style">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <input type="text" placeholder="Full Name*" id="fname1" name="name" value="{{old('name') ?? $user->name}}">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <select name="country" id="Country" class="form-control" value="{{old('country')}}">
                                                    <option disabled="" selected="">Country*</option>
                                                    <option value="united_state">United State</option>
                                                    <option value="bangladesh">Bangladesh</option>
                                                    <option value="india">India</option>
                                                    <option value="srilanka">Srilanka</option>
                                                    <option value="pakisthan">Pakisthan</option>
                                                    <option value="afgansthan">Afgansthan</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="City / Town*" id="City" name="city" value="{{old('city')}}">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Postcode / ZIP*" id="Post2" name="postCode" value="{{old('postCode')}}">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Company Name" id="Company" name="company" value="{{old('company')}}">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="email" placeholder="Email Address" id="email4" name="email" value="{{old('email') ?? $user->email}}">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="tel" placeholder="Phone*" id="email2" name="phone" value="{{old('phone')}}">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <input type="text" placeholder="Address*" id="Adress" name="address" value="{{old('address')}}">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <div class="note-area">
                                                    <textarea name="note" placeholder="Additional Information">{{old('note')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="biling-item-3">
                                    <input id="toggle4" type="checkbox" name="different_shipping" value="1">
                                    <label class="fontsize" for="toggle4">Ship to a Different Address?</label>
                                    <div class="billing-adress" id="open4">
                                        <div class="contact-form form-style">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <input type="text" placeholder="Full Name*" id="fname6" name="shippingName" value="{{old('shippingName')}}">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <select name="shippingCountry" id="Country2" class="form-control" value="{{old('shippingCountry')}}">
                                                        <option disabled="" selected="">Country*</option>
                                                        <option value="united_state">United State</option>
                                                        <option value="bangladesh">Bangladesh</option>
                                                        <option value="india">India</option>
                                                        <option value="srilanka">Srilanka</option>
                                                        <option value="pakisthan">Pakisthan</option>
                                                        <option value="afgansthan">Afgansthan</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="City / Town*" id="City1" name="shippingCity" value="{{old('shippingCity')}}">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Postcode / ZIP*" id="Post1" name="shippingPostCode" value="{{old('shippingPostCode')}}">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Company Name" id="Company1" name="shippingCompany" value="{{old('shippingCompany')}}">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="email" placeholder="Email Address" id="email5" name="shippingEmail" value="{{old('shippingEmail')}}">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="tel" placeholder="Phone*" id="phone1" name="shippingPhone" value="{{old('shippingPhone')}}">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <input type="text" placeholder="Address*" id="Adress1" name="shippingAddress" value="{{old('shippingAddress')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="cout-order-area">
                            <h3>Your Order</h3>
                            <div class="oreder-item">
                                <div class="title">
                                    <h2>Products <span>Subtotal</span></h2>
                                </div>
                                @foreach($cartItems ?? [] as $item)

                                <div class="oreder-product">
                                    <div class="images">
                                        <span>
                                            <img src="{{$item?->product?->thumbnail}}" alt="{{$item?->product?->name}}">
                                        </span>
                                    </div>
                                    <div class="product">
                                        <ul>
                                            <li class="first-cart">{{Str::limit($item?->product?->name, 10)}} (x{{$item?->quantity}})</li>
                                            <li>
                                                <div class="rating-product">
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <span>{{$item?->product?->rating}}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <span>{{ format_price($item->total)}}</span>
                                </div>
                                @endforeach

                                <!-- Shipping -->
                                <div class="mt-3 mb-3">
                                    <div class="title border-0">
                                        <h2>Delivery Charge</h2>
                                    </div>
                                    <ul>
                                        <li class="free">
                                            <input id="Free" type="radio" name="deliveryCharge" value="{{get_setting('shipping_inside_dhaka')}}" checked>
                                            <label for="Free">Inside City: <span>{{format_price(get_setting('shipping_inside_dhaka'))}}</span></label>
                                        </li>
                                        <li class="free">
                                            <input id="Local" type="radio" name="deliveryCharge" value="{{get_setting('shipping_outside_dhaka')}}">
                                            <label for="Local">Outside City: <span>{{format_price(get_setting('shipping_outside_dhaka'))}}</span></label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="title s2" style="border-top: 1px solid #e5e5e5; padding-top: 15px;">
                                    <h4 style="display:flex; justify-content:space-between; font-size: 16px;">
                                        Subtotal: <span>{{ format_price($subtotal) }}</span>
                                    </h4>

                                    @if($coupon)
                                    <h4 style="display:flex; justify-content:space-between; font-size: 16px; color: #28a745;">
                                        Discount ({{ $coupon->coupon_code }}): <span>- {{ format_price($discountAmount) }}</span>
                                    </h4>
                                    @endif
                                </div>

                                <div class="title s2">
                                    <h2>Total <span id="grandTotalDisplay">{{ format_price($subtotal - $discountAmount + 60) }}</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="caupon-wrap s5">
                            <div class="payment-area">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="payment-option" id="open5">
                                            <h3>Payment</h3>
                                            <div class="payment-select">
                                                <ul>
                                                    <li class="">
                                                        <input id="remove" type="radio" name="payment_method" checked="checked" value="cod">
                                                        <label for="remove">Cash on Delivery</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="add" type="radio" name="payment_method" value="sslcommerz">
                                                        <label for="add">Pay With SSLCOMMERZ</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="getway" type="radio" name="payment_method" value="stripe">
                                                        <label for="getway">Pay With STRIPE</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div id="open6" class="payment-name active">
                                                <div class="contact-form form-style">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <div class="submit-btn-area text-center">
                                                                <button class="theme-btn" type="submit">Place
                                                                    Order</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
        <div class="text-center mt-5">
            <h2>Your cart is empty</h2>
            <p class="mt-2">
                You need to add at least one product before proceeding to checkout.
            </p>
            <div class="shop-btn d-flex justify-content-center mt-3">
                <a class="theme-btn-s2" href="{{ route('shop') }}">Continue Shopping</a>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- wpo-checkout-area end-->
@endsection

@push('script')
<script>
    $(document).ready(function() {
        let currencySymbol = "{{ get_setting('currency_symbol') }}";
        // Initial grand total
        let baseTotal = {
            {
                $subtotal - $discountAmount
            }
        };

        // Update grand total on delivery charge change
        $('input[name="deliveryCharge"]').on('change', function() {
            let deliveryCharge = parseFloat($(this).val());
            let grandTotal = baseTotal + deliveryCharge;

            // Update grand total display
            $('#grandTotalDisplay').text(currencySymbol + grandTotal.toFixed(2));
        });
    });

</script>
@endpush

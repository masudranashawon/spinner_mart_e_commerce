@extends('frontend.layouts.app')

@section('title', 'Cart')

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
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Checkout</h2>
                    <p>There are {{$cartItems?->count() ?? 0}} products in this list</p>
                </div>
            </div>
        </div>
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
                                                <input type="text" placeholder="Company Name*" id="Company" name="company" value="{{old('company')}}">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="email" placeholder="Email Address*" id="email4" name="email" value="{{old('email') ?? $user->email}}">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="tel" placeholder="Phone*" id="email2" name="phone" value="{{old('phone')}}">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <input type="text" placeholder="Address*" id="Adress" name="address" value="{{old('address')}}">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <div class="note-area">
                                                    <textarea name="massage" placeholder="Additional Information">{{old('massage')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="biling-item-3">
                                    <input id="toggle4" type="checkbox">
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
                                                    <input type="text" placeholder="Postcode / ZIP*" id="Post1" name="shippingPost" value="{{old('shippingPost')}}">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Company Name*" id="Company1" name="shippingCompany" value="{{old('shippingCompany')}}">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="email" placeholder="Email Address*" id="email5" name="shippingEmail" value="{{old('shippingEmail')}}">
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
                                    <span>৳{{ $item->total}}</span>
                                </div>
                                @endforeach

                                <!-- Shipping -->
                                <div class="mt-3 mb-3">
                                    <div class="title border-0">
                                        <h2>Delivery Charge</h2>
                                    </div>
                                    <ul>
                                        <li class="free">
                                            <input id="Free" type="radio" name="delivaryCharge" value="60" checked>
                                            <label for="Free">Inside City: <span>৳60.00</span></label>
                                        </li>
                                        <li class="free">
                                            <input id="Local" type="radio" name="delivaryCharge" value="120">
                                            <label for="Local">Outside City: <span>৳120.00</span></label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="title s2">
                                    <h2>Total<span> ৳ {{ $cartItems?->sum('total') ?? 0 }}</span></h2>
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
                                                        <input id="remove" type="radio" name="payment" value="cod">
                                                        <label for="remove">Cash on Delivery</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="add" type="radio" name="payment" checked="checked" value="ssl">
                                                        <label for="add">Pay With SSLCOMMERZ</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="getway" type="radio" name="payment" value="stripe">
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
    </div>
</div>
<!-- wpo-checkout-area end-->
@endsection

@push('script')
@endpush

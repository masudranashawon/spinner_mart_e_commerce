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
                    <p>There are {{count($cartItems)?? "No"}} products in this list</p>
                </div>
            </div>
        </div>
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
                                    @forelse($cartItems as $cart)
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
                                            <div class="quantity cart-plus-minus">
                                                <input class="text-value" type="text" value="{{$cart->quantity}}">
                                                <div class="dec qtybutton">-</div>
                                                <div class="inc qtybutton">+</div>
                                            </div>
                                        </td>
                                        <td class="ptice">
                                            @php
                                            $total = $cart->quantity * ($cart->variant->discount_price ?? $cart->variant->selling_price);
                                            @endphp
                                            ৳{{ number_format($total,2) }}
                                        </td>
                                        <td class="action">
                                            <ul>
                                                <li class="w-btn"><a data-bs-toggle="tooltip" data-bs-html="true" title="" href="#" data-bs-original-title="Remove from Cart" aria-label="Remove from Cart"><i class="fi ti-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="wishlist-item">
                                        <td class="product-item-wish" colspan="5">
                                            <div class="text-center">
                                                <h4>No Product in Cart</h4>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="cart-action">
                            <div class="apply-area">
                                <input type="text" class="form-control" placeholder="Enter your coupon">
                                <button class="theme-btn-s2" type="submit">Apply</button>
                            </div>
                            <a class="theme-btn-s2" href="#"><i class="fi flaticon-refresh"></i> Update Cart</a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="cart-total-wrap">
                        <h3>Cart Totals</h3>
                        <div class="sub-total">
                            <h4>Subtotal</h4>
                            <span>৳{{ number_format($cartItems->sum('total'), 2) }}</span>
                        </div>
                        <div class="sub-total my-3">
                            <h4>Discount</h4>
                            <span>00.00</span>
                        </div>
                        <div class="total mb-3">
                            <h4>Total</h4>
                            <span>$300.00</span>
                        </div>
                        <a class="theme-btn-s2" href="checkout.html">Proceed To CheckOut</a>
                    </div>
                </div>
            </div>
        </div>
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
<style>

</style>
@endsection

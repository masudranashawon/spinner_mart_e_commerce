@extends('frontend.layouts.app')

@section('title', 'Wishlists')

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
                        <li>Wishlist</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- cart-area start -->
<div class="cart-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Wishlist</h2>
                    <p>There are {{count($wishlists) > 0 ? count($wishlists) : "No"}} products in this list</p>
                </div>
            </div>
        </div>

        <div class="form">
            <div class="cart-wrapper">
                <div class="row">
                    @if(count($wishlists) > 0)
                    <div class="col-12">
                        <table class="table-responsive cart-wrap">
                            <thead>
                                <tr>
                                    <th class="images images-b">Product</th>
                                    <th class="ptice">Price</th>
                                    <th class="stock">Stock Status</th>
                                    <th class="remove remove-b">Action</th>
                                    <th class="remove remove-b">Remove</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($wishlists as $wishlist)
                                <tr class="wishlist-item">
                                    <td class="product-item-wish">
                                        <div class="check-box"><input type="checkbox" class="myproject-checkbox">
                                        </div>
                                        <div class="images">
                                            <a style="width: 6rem; height: 6rem;" class="image d-block overflow-hidden" href="{{ route('productDetails', $wishlist->product->slug) }}">
                                                <img src="{{$wishlist->product->thumbnail}}" alt="{{ $wishlist->product->name }}" class="img-fluid w-100 h-100 object-fit-contain">
                                            </a>
                                        </div>
                                        <div class="product">
                                            <ul>
                                                <li class="first-cart"><a href="{{ route('productDetails', $wishlist->product->slug) }}"style="color:#233D50;">{{$wishlist->product->name}}</a></li>
                                                <li>
                                                    {{-- Rating --}}
                                                    <div class="rating-product">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $wishlist->product->rating)
                                                                <i class="fi flaticon-star"></i> 
                                                            @else
                                                                <i class="fi flaticon-star empty-star"></i>
                                                            @endif
                                                        @endfor
                                                        <span class="text-muted ms-1">({{ $wishlist->product->rating }})</span> 
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="ptice">
                                        @if($wishlist?->product?->discount_price)
                                        <del class="me-1">{{ format_price($wishlist?->product?->selling_price) }}</del>
                                        {{ format_price($wishlist?->product?->discount_price) }}
                                        @else
                                        {{ format_price($wishlist?->product?->selling_price) }}
                                        @endif
                                    </td>

                                    @if($wishlist->stock > 0)
                                    <td class="stock"><span class="in-stock">In Stock </span></td>
                                    @else
                                    <td class="stock"><span class="in-stock out-stock">Out Stock</span></td>
                                    @endif

                                    <td class="add-wish">
                                        <a class="theme-btn-s2" href="{{ route('productDetails', $wishlist->product->slug) }}">Shop Now</a>
                                    </td>
                                    <td class="action">
                                    <form action="{{route('wishlist.destroy')}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="product_id" value="{{$wishlist->product_id}}">
                                        <button type="submit" class="btn btn-lg w-btn fs-2" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Remove" aria-label="Remove">
                                            <i class="fi flaticon-remove"></i>
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center mt-5">
                        <h2>No Product in the Wishlist</h2>
                        <div class="shop-btn d-flex justify-content-center mt-3">
                            <a class="theme-btn-s2" href="{{route('shop')}}">Shop Now</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-area end -->

<style>
    .image {
        height: 12rem;
        overflow: hidden;
    }

    .image img {
        width: 100%;
        height: 100%;
        object-fit: contain !important;
    }

</style>
@endsection

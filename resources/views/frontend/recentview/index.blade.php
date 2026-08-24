@extends('frontend.layouts.app')

@section('title', 'Recent View')

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
                        <li>Recent View</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<section class="themart-interestproduct-section section-padding">
    <div class="container">
        @if($products->count() > 0)
        <div class="row">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Recently Viewed Products</h2>
                </div>
            </div>
        </div>
        @endif

        <div class="product-wrap">
            <div class="row row-cols-lg-4 row-cols-md-6 row-cols-sm-12">
                @foreach ( $products as $product )
                <div class="col"><x-product-card :product="$product" /></div>
                @endforeach
            </div>

            @if($products->count() < 1)
            <div class="text-center">
                <h2>No recent view available</h2>
                <p class="mt-2">
                    You need to view some products before you can see recently viewed products.
                </p>
                <div class="shop-btn d-flex justify-content-center mt-3">
                    <a class="theme-btn-s2" href="{{ route('shop') }}">Continue Shopping</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- end of themart-interestproduct-section -->
@endsection

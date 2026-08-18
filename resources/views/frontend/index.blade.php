@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
<!-- start of wpo-hero-section -->
<div class="wpo-hero-slider">
    <div class="container-fluid-sm container">
        <div class="hero-slider">
            
            @forelse($sliders as $slider)
            <div class="hero-slider-item">
                <div class="slider-bg">
                    <img src="{{ $slider->thumbnail }}" alt="Hero Slider">
                </div>
                
                @if($slider->btn_text)
                <div class="slider-content">
                    <div class="slide-title">
                        <h2>{{$slider->title}}</h2>
                    </div>
                    <a class="theme-btn" href="{{ $slider->btn_link ?? route('shop') }}">{{ $slider->btn_text }}</a>
                </div>
                @endif
            </div>
            @empty
            <div class="hero-slider-item">
                <div class="slider-bg">
                    <img src="{{ asset('frontend/assets/images/slider/slide-1.jpg') }}" alt="Default Slider">
                </div>
                <div class="slider-content">
                    <a class="theme-btn" href="{{ route('shop') }}">Shop Now</a>
                </div>
            </div>
            @endforelse

        </div>
    </div>
    
    <ul class="hero-social">
        <li><a href="#"><i class="ti-facebook"></i></a></li>
        <li><a href="#"><i class="ti-instagram"></i></a></li>
        <li><a href="#"><i class="ti-linkedin"></i></a></li>
        <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
    </ul>
</div>
<!-- end of wpo-hero-section -->

<!-- start of themart-featured-section -->
<section class="themart-featured-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Featured Categories</h2>
                </div>
            </div>
        </div>
        <div class="featured-categorie-slider owl-carousel">
            @foreach($categories ?? [] as $category)

                <div class="featured-item">
                        <div class="images">
                            <a href="{{ route('shop', ['category' => $category->slug]) }}">
                                <img src="{{ $category?->thumbnail }}" alt="{{$category?->name}}" class="w-100 h-100 object-fit-contain" style="object-fit:contain !important;">
                            </a>
                        </div>
                        <div class="text">
                            <h2><a href="{{ route('shop', ['category' => $category->slug]) }}">{{$category?->name}}</a></h2>
                        </div>
                </div>
          
            @endforeach
        </div>
    </div>
</section>
<!-- end of themart-featured-section -->

<!-- start of themart-offer-section -->
<section class="themart-offer-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Exciting Offers</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Banner 1 (Timer Banner) -->
            <div class="col-lg-6 col-md-12">
                <div class="offer-wrap" @if(get_setting('promo_1_image')) style="background: url('{{ get_setting('promo_1_image') }}') no-repeat center center/cover;" @endif>
                    <div class="content">
                        <h2>{{ get_setting('promo_1_title', 'Stylish Coat') }}</h2>
                        <span class="offer-price">{{ get_setting('promo_1_price', '$80') }}</span>
                        <del>{{ get_setting('promo_1_old_price', '$150') }}</del>

                        <div class="count-up">
                            @php
                                $timerDate = get_setting('promo_1_timer') ? \Carbon\Carbon::parse(get_setting('promo_1_timer'))->format('Y/m/d H:i:s') : '2026/12/31 23:59:59';
                            @endphp
                            
                            <div id="clock" data-date="{{ $timerDate }}"></div>
                        </div>
                        <a class="theme-btn-s2" href="{{ get_setting('promo_1_link') }}">Shop Now</a>
                    </div>
                </div>
            </div>

            {{-- Banner 2 --}}
            <div class="col-lg-6 col-md-12">
                <div class="banner-two-wrap" @if(get_setting('promo_2_image')) style="background: url('{{ get_setting('promo_2_image') }}') no-repeat center center/cover;" @endif>
                    <div class="text">
                        <h2>{{ get_setting('promo_2_title', 'New Year Sale') }}</h2>
                        <h4>{{ get_setting('promo_2_offer_text', 'Up To 70% Off') }}</h4>
                        <a class="theme-btn-s2" href="{{ get_setting('promo_2_link') }}">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of themart-offer-section -->

<!-- start of themart-interestproduct-section -->
<section class="themart-interestproduct-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Products Of Your Interest</h2>
                </div>
            </div>
        </div>
        
        <div class="product-wrap">
            <div>
                <div  class="row row-cols-lg-4 row-cols-md-6 row-cols-sm-12">
                    @foreach($interestedProducts as $product)
                    <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="more-btn">
                    <a class="theme-btn-s2" href="{{ route('shop') }}">View All</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of themart-interestproduct-section -->

<!-- start of themart-upcoming-offer-section -->
@if(get_setting('show_mega_new_year_sale', '1') == '1')
<section class="themart-upcoming-offer-section section-padding">
    <div class="container">
        <div class="upcoming-offer">
            <div class="left-shape">
                <svg width="448" height="448" viewBox="0 0 448 448" fill="none">
                    <path d="M448 224C448 347.712 347.712 448 224 448C100.288 448 0 347.712 0 224C0 100.288 100.288 0 224 0C347.712 0 448 100.288 448 224ZM13.8949 224C13.8949 340.038 107.962 434.105 224 434.105C340.038 434.105 434.105 340.038 434.105 224C434.105 107.962 340.038 13.8949 224 13.8949C107.962 13.8949 13.8949 107.962 13.8949 224Z" fill="#F1E2CC" />
                    <path d="M405 224C405 323.964 323.964 405 224 405C124.036 405 43 323.964 43 224C43 124.036 124.036 43 224 43C323.964 43 405 124.036 405 224ZM56.2246 224C56.2246 316.66 131.34 391.775 224 391.775C316.66 391.775 391.775 316.66 391.775 224C391.775 131.34 316.66 56.2246 224 56.2246C131.34 56.2246 56.2246 131.34 56.2246 224Z" fill="#F1E2CC" />
                    <path d="M360 224C360 299.111 299.111 360 224 360C148.889 360 88 299.111 88 224C88 148.889 148.889 88 224 88C299.111 88 360 148.889 360 224ZM100.433 224C100.433 292.244 155.756 347.567 224 347.567C292.244 347.567 347.567 292.244 347.567 224C347.567 155.756 292.244 100.433 224 100.433C155.756 100.433 100.433 155.756 100.433 224Z" fill="#F1E2CC" />
                </svg>
            </div>
            <div class="left-image">
                <img src="{{ asset('frontend/assets/images/upcomming-left.png') }}" alt="">
            </div>
            <div class="right-shape">
                <svg width="448" height="448" viewBox="0 0 448 448" fill="none">
                    <path d="M448 224C448 347.712 347.712 448 224 448C100.288 448 0 347.712 0 224C0 100.288 100.288 0 224 0C347.712 0 448 100.288 448 224ZM13.8949 224C13.8949 340.038 107.962 434.105 224 434.105C340.038 434.105 434.105 340.038 434.105 224C434.105 107.962 340.038 13.8949 224 13.8949C107.962 13.8949 13.8949 107.962 13.8949 224Z" fill="#F1E2CC" />
                    <path d="M405 224C405 323.964 323.964 405 224 405C124.036 405 43 323.964 43 224C43 124.036 124.036 43 224 43C323.964 43 405 124.036 405 224ZM56.2246 224C56.2246 316.66 131.34 391.775 224 391.775C316.66 391.775 391.775 316.66 391.775 224C391.775 131.34 316.66 56.2246 224 56.2246C131.34 56.2246 56.2246 131.34 56.2246 224Z" fill="#F1E2CC" />
                    <path d="M360 224C360 299.111 299.111 360 224 360C148.889 360 88 299.111 88 224C88 148.889 148.889 88 224 88C299.111 88 360 148.889 360 224ZM100.433 224C100.433 292.244 155.756 347.567 224 347.567C292.244 347.567 347.567 292.244 347.567 224C347.567 155.756 292.244 100.433 224 100.433C155.756 100.433 100.433 155.756 100.433 224Z" fill="#F1E2CC" />
                </svg>
            </div>
            <div class="right-image">
                <img src="{{ asset('frontend/assets/images/upcomming-right.png') }}" alt="">
            </div>
            <div class="section-title-text">
                <h2>New Year Sale</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text">
                        <div class="shape-text">Up To <div class="shape-single">
                                <div class="shape">
                                    <svg width="158" height="159" viewBox="0 0 158 159" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M156.059 58C146.681 24.5386 115.956 0 79.5 0C35.5934 0 0 35.5934 0 79.5C0 123.407 35.5934 159 79.5 159C117.749 159 149.689 131.988 157.285 96H147.228C139.817 126.526 112.306 149.193 79.5 149.193C41.0096 149.193 9.80698 117.99 9.80698 79.5C9.80698 41.0096 41.0096 9.80698 79.5 9.80698C110.488 9.80698 136.752 30.031 145.814 58H156.059Z" fill="url(#paint0_linear_62_180)" />

                                        <defs>
                                            <linearGradient id="paint0_linear_62_180" x1="78.6428" y1="0" x2="78.6428" y2="159" gradientUnits="userSpaceOnUse">
                                                <stop offset="0" stop-color="#95CD2F" />
                                                <stop offset="1" stop-color="#63911F" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                50
                            </div>% Off</div>
                        <a class="upcoming-btn" href="{{ route('shop') }}">Shop Now</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endif
<!-- end of themart-upcoming-offer-section -->

<!-- start of themart-special-product-section -->
@if($dealsOfTheDay->count() > 0)
<section class="themart-special-product-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Deals Of The Day</h2>
                </div>
            </div>
        </div>
        <div class="row g-0">
            @foreach($dealsOfTheDay as $product)
            <div class="col-lg-6 col-12">
                <ul class="special-product">
                    <li>
                        <div class="product-item">
                            <div class="image w-50">
                                <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}">
                            </div>
                            <div class="text w-50 p-2 p-md-4">
                                <h2><a href="{{route('productDetails', $product->slug)}}">{{$product->name}}</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>{{$product->rating}}</span>
                                </div>
                                <div class="price">
                                    @if($product->discount_price > 0)
                                    {{-- If discount price is greater than 0 --}}
                                    <span class="present-price">{{ format_price($product->discount_price) }}</span>
                                    <del class="old-price">{{ format_price($product->selling_price) }}</del>
                                    @else
                                    <span class="present-price">{{ format_price($product->selling_price) }}</span>
                                    @endif
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="{{route('productDetails', $product->slug)}}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- end of themart-special-product-section -->

<!-- start of themart-trendingproduct-section -->
@if($trendingProducts->count() > 0)    
<section class="themart-trendingproduct-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Trending Products</h2>
                </div>
            </div>
        </div>

        <div class="trendin-slider owl-carousel">
            @foreach($trendingProducts as $product)
            <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- end of themart-trendingproduct-section -->

<!-- start of themart-highlight-product-section -->
<section class="themart-highlight-product-section mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="highlight-wrap">
                    <h2>Top Selling</h2>
                    @foreach($topSellingProducts ?? [] as $product)
                    <div class="product-card">
                        <div class="card-image">
                            <div class="image overflow-hidden">
                                <img src="{{ $product?->thumbnail }}" alt="{{$product?->name}}" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        </div>
                        <div class="content">
                            <h3><a href="product.html" class="text-truncate" style="max-width:180px">{{$product?->name}}</a></h3>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>{{$product?->rating}}</span>
                            </div>
                            <div class="price">
                                <span class="present-price">{{$product?->discount_price}} </span>
                                <del class="old-price">{{$product?->selling_price}}</del>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="highlight-wrap">
                    <h2>Recently added</h2>
                    @foreach($recentlyAdded ?? [] as $product)
                    <div class="product-card">
                        <div class="card-image">
                            <div class="image overflow-hidden">
                                <img src="{{ $product?->thumbnail }}" alt="{{$product?->name}}" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        </div>
                        <div class="content">
                            <h3><a href="product.html" class="text-truncate" style="max-width:180px">{{$product?->name}}</a></h3>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>{{$product?->rating}}</span>
                            </div>
                            <div class="price">
                                <span class="present-price">{{$product?->discount_price}} </span>
                                <del class="old-price">{{$product?->selling_price}}</del>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="highlight-wrap">
                    <h2>Top Rated</h2>
                    <div class="product-card">
                        <div class="card-image">
                            <div class="image">
                                <img src="{{ asset('frontend/assets/images/top-rated/1.png') }}" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <h3><a href="product.html">Kids Shoes</a></h3>
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
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="card-image">
                            <div class="image">
                                <img src="{{ asset('frontend/assets/images/top-rated/2.png') }}" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <h3><a href="product.html">Stylish Earrings</a></h3>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>230</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$150.00</span>
                                <del class="old-price">$200.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="card-image">
                            <div class="image">
                                <img src="{{ asset('frontend/assets/images/top-rated/3.png') }}" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <h3><a href="product.html">Yellow Hats</a></h3>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>130</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$170.00</span>
                                <del class="old-price">$250.00</del>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of themart-highlight-product-section -->

<!-- start of themart-cta-section -->
<section class="themart-cta-section section-padding">
    <div class="container">
        <div class="cta-wrap">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12">
                    <div class="cta-content">
                        <h2>Subscribe Our Newsletter & <br>
                            Get 30% Discounts For Next Order</h2>
                        <form id="newsletter-form">
                            <div class="input-1">
                                <input type="email" name="email" id="newsletter-email" placeholder="Enter your email address" class="form-control" required>
                                <div class="submit clearfix">
                                    <button class="theme-btn-s2" type="submit" id="newsletter-btn">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of themart-cta-section -->
@endsection

@push('script') 
<script>
    $(document).ready(function() {
        $('#newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            let email = $('#newsletter-email').val();
            let btn = $('#newsletter-btn');
            let originalText = btn.text();
            
            btn.text('Wait...').prop('disabled', true);

            // Send AJAX request to server
            $.ajax({
                url: "{{ route('newsletter.store') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email
                },

                success: function(response) {
                    if (response.status === 'success') {
                        
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                        $('#newsletter-form')[0].reset();
                    } else {
                        
                        Toast.fire({
                            icon: "info",
                            title: response.message
                        });
                    }
                },

                error: function(xhr) {
                    // Handle error
                    let errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = xhr.responseJSON.errors.email[0];
                    }
                    Toast.fire({
                        icon: "error",
                        title: errorMessage
                    });
                },
                
                complete: function() {
                    // Reset button text and enable button
                    btn.text(originalText).prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush
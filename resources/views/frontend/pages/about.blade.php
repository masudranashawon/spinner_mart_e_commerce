@extends('frontend.layouts.app')

@section('title', 'About Us')

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
                        <li>About Us</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- start of wpo-about-section -->
<section class="wpo-about-section section-padding">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 col-md-12 col-12">
                <div class="wpo-about-wrap">
                    <div class="wpo-about-img">
                        <img src="{{ get_setting('about_hero_image') }}" alt="About Us">
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <div class="wpo-about-text">
                    <h4>ABOUT US</h4>
                    <h2>{!! get_setting('about_hero_heading') !!}</h2>
                    <p>{{ get_setting('about_hero_description') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of wpo-about-section -->

<!-- start wpo-service-section (Static as requested) -->
<section class="wpo-service-section">
    <div class="container">
        <div class="service-wrap">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="service-item">
                        <div class="service-item-img">
                            <img src="{{ asset('frontend/assets/images/service/1.png') }}" alt="Free Shipping">
                        </div>
                        <div class="service-item-text">
                            <h2>Free Shipping</h2>
                            <p>Free Shipping World Wide.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="service-item">
                        <div class="service-item-img">
                            <img src="{{ asset('frontend/assets/images/service/2.png') }}" alt="24 X 7 Service">
                        </div>
                        <div class="service-item-text">
                            <h2>24 X 7 Service</h2>
                            <p>Online Service For New Customer.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="service-item">
                        <div class="service-item-img">
                            <img src="{{ asset('frontend/assets/images/service/3.png') }}" alt="Festival Offer">
                        </div>
                        <div class="service-item-text">
                            <h2>Festival Offer</h2>
                            <p>New Online Special Festival Offer.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- end wpo-service-section -->

<!-- start themart-gallery-section-->
<section class="themart-gallery-section themart-gallery-section-s2 section-padding" id="gallery">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="wpo-section-title">
                    <h2>Image Gallery</h2>
                </div>
            </div>
        </div>
        <div class="sortable-gallery">
            <div class="gallery-filters"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="portfolio-grids gallery-container clearfix">

                        <!-- Image 1 -->
                        <div class="grid">
                            <div class="img-holder">
                                <a href="{{ get_setting('about_gallery_1_image') }}" class="fancybox" data-fancybox-group="gall-1">
                                    <img src="{{ get_setting('about_gallery_1_image') }}" alt="Gallery 1" class="img img-responsive">
                                    <div class="hover-content">
                                        <i class="fi flaticon-eye"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Image 2 -->
                        <div class="grid">
                            <div class="img-holder">
                                <a href="{{ get_setting('about_gallery_2_image') }}" class="fancybox" data-fancybox-group="gall-1">
                                    <img src="{{ get_setting('about_gallery_2_image') }}" alt="Gallery 2" class="img img-responsive">
                                    <div class="hover-content">
                                        <i class="fi flaticon-eye"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Image 3 -->
                        <div class="grid">
                            <div class="img-holder">
                                <a href="{{ get_setting('about_gallery_3_image') }}" class="fancybox" data-fancybox-group="gall-1">
                                    <img src="{{ get_setting('about_gallery_3_image') }}" alt="Gallery 3" class="img img-responsive">
                                    <div class="hover-content">
                                        <i class="fi flaticon-eye"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Image 4 -->
                        <div class="grid">
                            <div class="img-holder">
                                <a href="{{ get_setting('about_gallery_4_image') }}" class="fancybox" data-fancybox-group="gall-1">
                                    <img src="{{ get_setting('about_gallery_4_image') }}" alt="Gallery 4" class="img img-responsive">
                                    <div class="hover-content">
                                        <i class="fi flaticon-eye"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end themart-gallery-section-->

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

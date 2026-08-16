@extends('frontend.layouts.app')

@section('title', 'Contact Us')

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
                        <li>Contact</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end page-title -->

<!-- start wpo-contact-pg-section -->
<section class="wpo-contact-pg-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col col-lg-10 offset-lg-1">
                <div class="office-info">
                    <div class="row">
                        <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="office-info-item">
                                <div class="office-info-icon">
                                    <div class="icon">
                                        <i class="fi flaticon-pin"></i>
                                    </div>
                                </div>
                                <div class="office-info-text">
                                    <h2>Address</h2>
                                    <p>{{ get_setting('address', '7 Green Lake Street Crawfordsville, IN 47933') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="office-info-item">
                                <div class="office-info-icon">
                                    <div class="icon">
                                        <i class="fi flaticon-mail"></i>
                                    </div>
                                </div>
                                <div class="office-info-text">
                                    <h2>Email Us</h2>
                                    <a class="text-body" href="mailto:{{ get_setting('email') }}">{{ get_setting('email') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="office-info-item">
                                <div class="office-info-icon">
                                    <div class="icon">
                                        <i class="fi flaticon-phone"></i>
                                    </div>
                                </div>
                                <div class="office-info-text">
                                    <h2>Call Now</h2>
                                    <a class="text-body d-block" href="tel:{{ get_setting('phone') }}">{{ get_setting('phone') }}</a>
                                    <a class="text-body" href="tel:{{ get_setting('secondary_phone') }}">{{ get_setting('secondary_phone') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wpo-contact-title">
                    <h2>Have Any Question?</h2>
                    <p>Feel free to reach out to us. We will get back to you as soon as possible.</p>
                </div>

                <div class="wpo-contact-form-area">
                    <form action="{{ route('contact.store') }}" method="POST" id="laravel-contact-form">
                        @csrf
                        <div>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name*" value="{{ old('name') }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email*" value="{{ old('email') }}" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Subject Field (Updated from Adress/Service) -->
                        <div class="fullwidth">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject*" value="{{ old('subject') }}" required>
                            @error('subject') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="fullwidth">
                            <textarea class="form-control" name="message" id="message" placeholder="Message..." rows="4" required>{{ old('message') }}</textarea>
                            @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="submit-area">
                            <button type="submit" class="theme-btn">Get in Touch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end wpo-contact-pg-section -->

<!--  start wpo-contact-map -->
<section class="wpo-contact-map-section">
    <h2 class="hidden">Contact map</h2>
    <div class="wpo-contact-map">
       {!! get_setting('address_map') !!}
    </div>
</section>
<!-- end wpo-contact-map -->
@endsection

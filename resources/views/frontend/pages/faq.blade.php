@extends('frontend.layouts.app')
@section('title', 'FAQ')
@section('content')

<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>FAQ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- start wpo-faq-section -->
<section class="wpo-faq-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 offset-lg-2">
                <div class="wpo-section-title">
                    <h2>Frequently Asked Question</h2>
                </div>
            </div>
            <div class="col-lg-8 offset-lg-2">
                <div class="wpo-faq-wrap">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="wpo-benefits-item">
                                <div class="accordion" id="accordionExample">

                                    @forelse($faqs as $faq)
                                    <div class="accordion-item">
                                        <h3 class="accordion-header" id="heading{{ $faq->id }}">
                                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $faq->id }}">
                                                {{ $faq->question }}
                                            </button>
                                        </h3>
                                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p>{{ $faq->answer }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-center">No FAQ Found.</p>
                                    @endforelse

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<div class="question-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="wpo-section-title">
                    <h2>Do You Have Any Question?</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="question-touch">
                    <h2>Get In Touch</h2>
                    <form action="{{ route('contact.store') }}" method="POST" id="laravel-contact-form">
                        @csrf

                        <div class="half-col">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name') }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="half-col">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="half-col">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" value="{{ old('subject') }}" required>
                            @error('subject') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <textarea class="form-control" name="message" placeholder="Your Question" required>{{ old('message') }}</textarea>
                            @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="submit-btn-wrapper">
                            <button type="submit" class="theme-btn color-9">Submit Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

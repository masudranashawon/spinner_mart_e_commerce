<!-- start of wpo-site-footer-section -->
@php
use App\Models\Page;
use App\Models\Category;

$footerPages = Page::where('is_active', 1)
->where('show_in_footer', 1)
->select('title', 'slug')
->get();

$categories = Category::get()->take(5);

@endphp
<footer class="wpo-site-footer">
    <div class="wpo-upper-footer">
        <div class="container">
            <div class="row">
                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="widget about-widget">
                        <div class="logo widget-title">
                            <img src="{{ get_setting('footer_logo') }}" alt="{{ get_setting('store_name') }}">
                        </div>
                        <p>{{ get_setting('footer_about_text') }}</p>
                        <ul>
                            @if(get_setting('facebook_url'))
                            <li><a href="{{ get_setting('facebook_url') }}"><i class="ti-facebook"></i></a></li>
                            @endif

                            @if(get_setting('instagram_url'))
                            <li><a href="{{ get_setting('instagram_url') }}"><i class="ti-instagram"></i></a></li>
                            @endif

                            @if(get_setting('tiktok_url'))
                            <li>
                                <a href="{{ get_setting('tiktok_url') }}">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-3.77V2h-3.45v13.67a2.89 2.89 0 1 1-2.89-2.89c.3 0 .59.05.86.13V9.4a6.34 6.34 0 1 0 5.48 6.28V8.26a8.16 8.16 0 0 0 4.77 1.53V6.34a4.83 4.83 0 0 1-1-.65z"/>
                                    </svg>
                                </a>
                            </li>
                            @endif

                            @if(get_setting('youtube_url'))
                            <li><a href="{{ get_setting('youtube_url') }}"><i class="ti-youtube"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Contact Us</h3>
                        </div>
                        <div class="contact-ft">
                            <ul class="d-flex flex-column gap-3">
                                <li class="d-flex align-items-center"><i class="fi flaticon-mail"></i><a class="m-0 p-0" href="mailto:{{ get_setting('email')}}">{{ get_setting('email') }}</a></li>

                                <li class="d-flex align-items-center">
                                    <i class="fi flaticon-phone"></i>
                                    <p class="m-0 p-0">
                                        <a class="d-block" href="tel:{{ get_setting('phone') }}">{{ get_setting('phone') }},</a>
                                        <a class="d-block" href="tel:{{ get_setting('phone_secondary') }}">{{ get_setting('phone_secondary') }}</a>
                                    </p>
                                </li>

                                <li class="d-flex align-items-center"><i class="fi flaticon-pin"></i>{{ get_setting('address') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-3 col-lg-2 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Popular</h3>
                        </div>
                        <ul class="d-flex flex-column gap-3">
                            @foreach ($categories as $category)
                            <li><a href="{{ route('shop', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col col-xl-3 col-lg-2 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Quick Links</h3>
                        </div>
                        <ul class="d-flex flex-column gap-3">
                            @foreach ($footerPages as $page)
                            <li><a href="{{ route('dynamic.page', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </div>
    
    <div class="wpo-lower-footer">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <p class="copyright"> Copyright &copy; {{ date('Y') . ' ' . get_setting('store_name') }}. Developed & Maintained by <a href="https://masudranashawon.vercel.app" target="_blank">Masud Rana Shawon</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end of wpo-site-footer-section -->

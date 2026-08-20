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
                            <li>
                                <a href="#">
                                    <i class="ti-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ti-twitter-alt"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ti-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ti-instagram"></i>
                                </a>
                            </li>
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

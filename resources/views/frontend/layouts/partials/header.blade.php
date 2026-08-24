<?php 
    $categories = App\Models\Category::with('subCategories')->get();
    $user = auth('web')?->user();
    $cartItems = $user?->cartItems()?->latest()->get();
    $wishlist = $user?->wishlist()?->latest()->get();
 ?>

<!-- start header -->
<header id="header">
    <!-- start topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                   @if(get_setting('enable_announcement_bar') == '1')
                    <div class="contact-intro">
                        <a href="{{ get_setting('announcement_link') }}"><span>{{ get_setting('announcement_text') }}</span></a>
                    </div>
                    @endif
                </div>
                <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="contact-info">
                        <ul>
                            <li><a href="tel:{{get_setting('phone')}}"><span>Need help? Call Us:</span> {{get_setting('phone')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end topbar -->
    <!--  start header-middle -->
    <div class="header-middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ get_setting('site_logo') }}" alt="{{ get_setting('store_name') }}"></a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <form class="middle-box search-box" action="{{ route('shop') }}" method="GET">
                        <div class="header-search-form-wrapper position-relative">
                            <div class="input-group">
                                <input type="search" name="search" id="headerSearchInput" class="form-control border-0" placeholder="What are you looking for?" autocomplete="off">
                                <button class="search-btn" type="submit"> <i class="fi flaticon-search"></i>
                                </button>
                            </div>

                            {{-- Floating Search Results Box (Initially Hidden) --}}
                            <div id="floatingSearchResults" class="bg-white shadow rounded position-absolute w-100 d-none" style="top: 110%; left: 0; z-index: 99999; max-height: 400px; overflow-y: auto; border: 1px solid #e1e1e1;">
                                <!-- AJAX Response will come here in search_dropdown.blade.php -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="middle-right">
                        <ul>

                            @if($user)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if($user->media_id)
                                    <img src="{{ $user->thumbnail }}" alt="{{ $user->name }}" class="rounded-circle border" style="width: 2.5rem; height: 2.5rem; object-fit: cover;">
                                    @else
                                    <i class="fi flaticon-user-profile"></i>
                                    @endif

                                    <span class="ms-2">{{ Str::before($user->name, ' ') }}</span>
                                </a>

                                <ul class="dropdown-menu">
                                    @role('admin')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.root') }}">
                                            Dashboard
                                        </a>
                                    </li>
                                    @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                                            Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('order.index') }}">
                                            My Orders
                                        </a>
                                    </li>
                                    @endrole
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa fa-sign-out text-danger"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            @guest
                            <li><a href="{{ route('login') }}"><i class="fi flaticon-user-profile"></i><span>Login</span></a></li>
                            @endguest

                            <li>
                                <div class="header-wishlist-form-wrapper">
                                    <button class="wishlist-toggle-btn"> <i class="fi flaticon-heart"></i>
                                        <span class="cart-count">{{ $wishlist?->count() ?? 0 }}</span></button>
                                    <div class="mini-wislist-content">
                                        <button class="mini-cart-close"><i class="ti-close"></i></button>
                                        <div class="mini-cart-items">
                                            <div class="mini-cart-item clearfix">
                                                @foreach($wishlist ?? [] as $item)
                                                <div class="mini-cart-item clearfix">
                                                    <div class="mini-cart-item-image">
                                                        <a href="{{ route('productDetails', $item->product->slug) }}"><img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}"></a>
                                                    </div>
                                                    <div class="mini-cart-item-des">
                                                        <a href="{{ route('productDetails', $item->product->slug) }}" style="width: 90%;" class="text-truncate">{{ $item->product->name }}</a>

                                                        <span class="mini-cart-item-price">
                                                            @if($item->product->discount_price)
                                                            <del class="me-1">{{ format_price($item->product->selling_price) }}</del>
                                                            {{ format_price($item->product->discount_price) }}
                                                            @else
                                                            {{ format_price($item->product->selling_price) }}
                                                            @endif
                                                        </span>

                                                        <form action="{{ route('wishlist.destroy') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">

                                                            <button type="submit" class="mini-cart-item-quantity btn btn-link p-0 border-0 shadow-none">
                                                                <span class="mini-cart-item-quantity">
                                                                    <i class="ti-close"></i>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="mini-cart-action clearfix">
                                                <div class="mini-btn">
                                                    <a href="{{ route('wishlist.index') }}" class="view-cart-btn">View Wishlist</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </li>
                            <li>
                                <div class="mini-cart">
                                    <button class="cart-toggle-btn"> <i class="fi flaticon-add-to-cart"></i>
                                        <span class="cart-count">{{ $cartItems?->count() ?? 0 }}</span></button>
                                    <div class="mini-cart-content">
                                        <button class="mini-cart-close"><i class="ti-close"></i></button>
                                        <div class="mini-cart-items">
                                            @foreach($cartItems ?? [] as $item)
                                            <div class="mini-cart-item clearfix">
                                                <div class="mini-cart-item-image">
                                                    <a href="{{ route('productDetails', $item->product->slug) }}"><img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}"></a>
                                                </div>
                                                <div class="mini-cart-item-des">
                                                    <a href="{{ route('productDetails', $item->product->slug) }}" style="width: 90%;" class="text-truncate">{{ $item->product->name }}</a>

                                                    <small class="text-muted d-block">
                                                        @php
                                                        $attrs = [];
                                                        if ($item->variant->color?->name) $attrs[] = 'Color: ' . $item->variant->color->name;
                                                        if ($item->variant->size?->name) $attrs[] = 'Size: ' . $item->variant->size->name;
                                                        @endphp

                                                        {{ implode(' | ', $attrs) }}
                                                    </small>

                                                    <span class="mini-cart-item-price">

                                                        @if($item->variant->discount_price)
                                                        <del class="me-1">{{ format_price($item->variant->selling_price) }}</del>
                                                        {{ format_price($item->variant->discount_price) }}
                                                        @else
                                                        {{ format_price($item->variant->selling_price) }}
                                                        @endif
                                                        x {{ $item->quantity }}
                                                    </span>

                                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="mini-cart-item-quantity btn btn-link p-0 border-0 shadow-none">
                                                            <span class="mini-cart-item-quantity">
                                                                <i class="ti-close"></i>
                                                            </span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="mini-cart-action clearfix">
                                            <span class="mini-checkout-price">Subtotal:
                                                <span>{{ format_price($cartItems?->sum('total'),) }}</span></span>
                                            <div class="mini-btn">
                                                <a href="{{ route('cart.index') }}" class="view-cart-btn">View Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="d-lg-none">
                                <a 
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Recent Views" href="{{ route('recent-view.index') }}">
                                    <i class="fi flaticon-refresh ms-2" style="font-size: 1.4rem;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  end header-middle -->
    <div class="wpo-site-header">
        <nav class="navigation navbar navbar-expand-lg navbar-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-lg-none dl-block">
                        <div class="mobail-menu">
                            <button type="button" class="navbar-toggler open-btn">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar first-angle"></span>
                                <span class="icon-bar middle-angle"></span>
                                <span class="icon-bar last-angle"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-5 col-6 d-block d-lg-none">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ get_setting('site_logo') }}" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-3">
                        <div class="header-shop-item">
                            <button class="header-shop-toggle-btn"><span>Shop By Category</span> </button>
                            <div class="mini-shop-item">
                                <ul id="metis-menu">
                                    @foreach($categories ?? [] as $category)
                                    <li class="header-catagory-item">
                                        @if($category?->subCategories && count($category?->subCategories)>0)
                                        <a class="menu-down-arrow" href="{{ route('shop', ['category' => $category->slug]) }}">{{$category->name}}</a>

                                        <ul class="header-catagory-single">
                                            @foreach($category?->subCategories as $subCategory)
                                            <li><a href="{{ route('shop', ['subcategory' => $subCategory->slug]) }}">{{ $subCategory->name}}</a></li>
                                            @endforeach
                                        </ul>
                                        @else
                                    <li>
                                        <a href="{{ route('shop', ['category' => $category->slug]) }}">{{$category->name}}</a>
                                    </li>
                                    @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-1 col-1">
                        <div id="navbar" class="navbar-collapse navigation-holder collapse">
                            <button class="menu-close"><i class="ti-close"></i></button>
                            <ul class="nav navbar-nav mb-lg-0 mb-2">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('about') }}">About</a></li>
                                <li><a href="{{ route('shop') }}">Shop</a></li>
                                <li><a href="{{ route('faq') }}">FAQs</a></li>
                                <li><a href="{{ route('contact.index') }}">Contact</a></li>
                            </ul>

                        </div><!-- end of nav-collapse -->
                    </div>
                    <div class="col-lg-2 col-md-1 col-1">
                        <div class="header-right">
                            <a href="{{ route('recent-view.index') }}" class="recent-btn"><i class="fi flaticon-refresh"></i>
                                <span>Recently Viewed</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- end of container -->
        </nav>
    </div>
</header>
<!-- end of header -->

<style>
    .header-middle {
        overflow: inherit;
    }

    .hover-bg-light:hover {
        background-color: #f8f9fa !important;
    }
</style>

@push('script')
<script>
    $(document).ready(function() {
        let searchTimer;
        
        // Search Input
        $('#headerSearchInput').on('keyup', function() {
            clearTimeout(searchTimer);
            let query = $(this).val();

            if (query.length > 0) {
                // Search Results
                searchTimer = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('ajax.search') }}",
                        type: "GET",
                        data: { search: query },
                        success: function(res) {
                            $('#floatingSearchResults').html(res.html).removeClass('d-none');
                        }
                    });
                }, 300);
            } else {
                // Clear Search Results
                $('#floatingSearchResults').addClass('d-none').html('');
            }
        });

       // Close Search Results
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.header-search-form-wrapper').length) {
                $('#floatingSearchResults').addClass('d-none');
            }
        });
        
        // Focus Search Input
        $('#headerSearchInput').on('focus', function() {
            if($(this).val().length > 0 && $('#floatingSearchResults').html().trim() !== '') {
                $('#floatingSearchResults').removeClass('d-none');
            }
        });
    });
</script>
@endpush
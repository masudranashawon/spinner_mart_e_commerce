<?php 
    $categories = App\Models\Category::with('subCategories')->latest('id')->get();
    $user = auth('web')?->user();
    $cartItems = $user?->cartItems()?->latest()->get();
 ?>

<!-- start header -->
<header id="header">
    <!-- start topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="contact-intro">
                        <span>A Marketplace Initiative by Themart Theme - save more with coupons</span>
                    </div>
                </div>
                <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="contact-info">
                        <ul>
                            <li><a href="tel:869968236"><span>Need help? Call Us:</span> +869 968 236</a></li>
                            <li>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        English
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">English</a></li>
                                        <li><a class="dropdown-item" href="#">Bangla</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                        USD
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <li><a class="dropdown-item" href="#">BDT</a></li>
                                        <li><a class="dropdown-item" href="#">USD</a></li>
                                    </ul>
                                </div>
                            </li>
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
                        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('frontend/assets/images/logo.svg') }}" alt="logo"></a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <form action="#" class="middle-box">
                        <div class="category">
                            <select name="service" class="form-control">
                                <option disabled="disabled" selected="">All Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search-box">
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="What are you looking for?">
                                <button class="search-btn" type="submit"> <i class="fi flaticon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="middle-right">
                        <ul>
                            <li><a href="compare.html"><i class="fi flaticon-right-and-left"></i><span>Compare</span></a></li>

                            @if($user)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fi flaticon-user-profile"></i><span>{{ $user->name }}</span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
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
                                        <span class="cart-count">3</span></button>
                                    <div class="mini-wislist-content">
                                        <button class="mini-cart-close"><i class="ti-close"></i></button>
                                        <div class="mini-cart-items">
                                            <div class="mini-cart-item clearfix">
                                                <div class="mini-cart-item-image">
                                                    <a href="product.html"><img src="{{ asset('frontend/assets/images/cart/img-1.jpg') }}" alt></a>
                                                </div>
                                                <div class="mini-cart-item-des">
                                                    <a href="product.html">Stylish Pink Coat</a>
                                                    <span class="mini-cart-item-price">$150</span>
                                                    <span class="mini-cart-item-quantity"><a href="#"><i class="ti-close"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="mini-cart-item clearfix">
                                                <div class="mini-cart-item-image">
                                                    <a href="product.html"><img src="{{ asset('frontend/assets/images/cart/img-2.jpg') }}" alt></a>
                                                </div>
                                                <div class="mini-cart-item-des">
                                                    <a href="product.html">Blue Bag</a>
                                                    <span class="mini-cart-item-price">$120</span>
                                                    <span class="mini-cart-item-quantity"><a href="#"><i class="ti-close"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="mini-cart-item clearfix">
                                                <div class="mini-cart-item-image">
                                                    <a href="product.html"><img src="{{ asset('frontend/assets/images/cart/img-3.jpg') }}" alt></a>
                                                </div>
                                                <div class="mini-cart-item-des">
                                                    <a href="product.html">Kids Blue Shoes</a>
                                                    <span class="mini-cart-item-price">$120</span>
                                                    <span class="mini-cart-item-quantity"><a href="#"><i class="ti-close"></i></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mini-cart-action clearfix">
                                            <div class="mini-btn">
                                                <a href="wishlist.html" class="view-cart-btn">View Wishlist</a>
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
                                            @foreach($cartItems as $item)
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
                                                        <del class="me-1">৳{{ number_format($item->variant->selling_price,2) }}</del>
                                                        ৳{{ number_format($item->variant->discount_price,2) }}
                                                        @else
                                                        ৳{{ number_format($item->variant->selling_price,2) }}
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
                                                <span>৳{{ number_format($cartItems->sum('total'), 2) }}</span></span>
                                            <div class="mini-btn">
                                                <a href="cart.html" class="view-cart-btn">View Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                            <a class="navbar-brand" href="index.html"><img src="{{ asset('frontend/assets/images/logo.svg') }}" alt="logo"></a>
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
                                        <a class="menu-down-arrow" href="">{{$category->name}}</a>
                                        <ul class="header-catagory-single">
                                            @foreach($category?->subCategories as $subCategory)
                                            <li><a href="{{ $subCategory->slug}}">{{ $subCategory->name}}</a></li>
                                            @endforeach
                                        </ul>
                                        @else
                                    <li>
                                        <a href="{{$category->slug}}">{{$category->name}}</a>
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
                                <li class="menu-item-has-children">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li><a href="about.html">About</a></li>
                                <li class="menu-item-has-children">
                                    <a href="{{route('shop')}}">Shop</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">FAQ</a>
                                </li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>

                        </div><!-- end of nav-collapse -->
                    </div>
                    <div class="col-lg-2 col-md-1 col-1">
                        <div class="header-right">
                            <a href="recent-view.html" class="recent-btn"><i class="fi flaticon-refresh"></i>
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

</style>

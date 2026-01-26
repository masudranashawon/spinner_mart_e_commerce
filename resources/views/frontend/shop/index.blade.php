@extends('frontend.layouts.app')

@section('title', 'Shop')

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
                        <li>Shop</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- product-area-start -->
<div class="shop-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="shop-filter-wrap">
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <div class="shop-filter-search">
                                <form>
                                    <div>
                                        <input type="text" class="form-control" placeholder="Search..">
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item category-widget">
                            <h2>Categories</h2>
                            <ul>
                                @foreach($categories as $category)
                                <li><a href="#">{{$category->name}}<span></span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Filter by price</h2>
                            <div class="shopWidgetWraper">
                                <div class="priceFilterSlider">
                                    <form action="#" method="get" class="clearfix">
                                        <!-- <div id="sliderRange"></div>
                                                <div class="pfsWrap">
                                                    <label>Price:</label>
                                                    <span id="amount"></span>
                                                </div> -->
                                        <div class="d-flex">
                                            <div class="col-lg-6 pe-2">
                                                <label for="" class="form-label">Min</label>
                                                <input type="text" class="form-control" placeholder="Min" value="0">
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="" class="form-label">Max</label>
                                                <input type="text" class="form-control" placeholder="Max" value="100000">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <button class="form-control bg-light">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Color</h2>
                            <ul>
                                @foreach($colors as $color)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{$color->name}}
                                        <input type="radio" name="topcoat2">
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Size</h2>
                            <ul>
                                @foreach($sizes as $size)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{$size->name}}
                                        <input type="radio" name="topcoat3">
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item new-product">
                            <h2>New Products</h2>
                            <ul>
                                @foreach($recentlyAdded ?? [] as $product)
                                <li>
                                    <div class="product-card">
                                        <div class="card-image">
                                            <div class="image">
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
                                                <span>30</span>
                                            </div>
                                            <div class="price">
                                                <span class="present-price">{{$product?->discount_price}} </span>
                                                <del class="old-price">{{$product?->selling_price}}</del>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item tag-widget">
                            <h2>Popular Tags</h2>
                            <ul>
                                @foreach($tags as $tag)
                                <li><a href="{{$tag->id}}">{{$tag->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="shop-section-top-inner">
                    <div class="shoping-product">
                        <p>We found <span>10 items</span> for you!</p>
                    </div>
                    <div class="short-by">
                        <ul>
                            <li>
                                Sort by:
                            </li>
                            <li>
                                <select name="show">
                                    <option value="">Default Sorting</option>
                                    <option value="">Low To High</option>
                                    <option value="">High To Low</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-wrap">
                    <div class="row align-items-center">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/1.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Wireless Headphones</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>130</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$120.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/2.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Blue Bag with Lock</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>120</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$160.00</span>
                                        <del class="old-price">$190.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/3.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Stylish Pink Top</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>150</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$150.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/4.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Brown Com Boots</a></h2>
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
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/5.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Winter Sweter</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>160</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$110.00</span>
                                        <del class="old-price">$130.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/6.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Blue Kids Shoes</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>130</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$180.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/7.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Stylish Bag</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>120</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$170.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/8.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Finger Rings</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>120</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$100.00</span>
                                        <del class="old-price">$130.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/trending-product/1.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Pink Baby Shoes</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>130</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$120.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/1.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Wireless Headphones</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>130</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$120.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/2.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Blue Bag with Lock</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>120</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$160.00</span>
                                        <del class="old-price">$190.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/3.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Stylish Pink Top</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>150</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$150.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/4.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Brown Com Boots</a></h2>
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
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/5.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Winter Sweter</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>160</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$110.00</span>
                                        <del class="old-price">$130.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/6.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Blue Kids Shoes</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>130</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$180.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-area-end -->

<!-- popup-quickview  -->
<div id="popup-quickview" class="modal fade" tabindex="-1">
    <div class="modal-dialog quickview-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
            <div class="modal-body d-flex">
                <div class="product-details">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="product-single-img">
                                <div class="modal-product">
                                    <div class="item">
                                        <img src="assets/images/modal.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="product-single-content">
                                <h5>Wireless Headphones</h5>
                                <h6>120.00 USD</h6>
                                <ul class="rating">
                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                </ul>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis ultrices
                                    lectus lobortis, dolor et tempus porta, leo mi efficitur ante, in varius
                                    felis
                                    sem ut mauris. Proin volutpat lorem inorci sed vestibulum tempus. Lorem
                                    ipsum
                                    dolor sit amet, consectetur adipiscing elit. Aliquam
                                    hendrerit.
                                </p>
                                <div class="pro-single-btn">
                                    <div class="quantity cart-plus-minus">
                                        <input type="text" value="1">
                                        <div class="dec qtybutton">-</div>
                                        <div class="inc qtybutton"></div>
                                    </div>
                                    <a href="#" class="theme-btn">Add to cart</a>
                                </div>
                                <div class="social-share">
                                    <span>Share with : </span>
                                    <ul class="socialLinks">
                                        <li><a href='#'><i class="fa fa-facebook"></i></a></li>
                                        <li><a href='#'><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href='#'><i class="fa fa-twitter"></i></a></li>
                                        <li><a href='#'><i class="fa fa-instagram"></i></a></li>
                                        <li><a href='#'><i class="fa fa-youtube-play"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popup-quickview -->
</div>

</div>
<!-- end of page-wrapper -->
@endsection

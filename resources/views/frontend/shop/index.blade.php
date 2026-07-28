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
            {{-- ================= SIDEBAR FILTERS ================= --}}
            <div class="col-lg-3">
                <form id="filterForm">
                    <div class="shop-filter-wrap">
                        <!-- Search -->
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <div class="shop-filter-search">
                                    <div>
                                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search product...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="filter-item">
                            <div class="shop-filter-item category-widget">
                                <h2>Categories</h2>
                                <ul>
                                    @foreach($categories as $category)
                                    <li>
                                        {{-- Parent Category --}}
                                        <div class="form-check position-relative mt-3">
                                            <input class="form-check-input filter-checkbox m-0 p-0" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" {{ in_array($category->id, (array) request()->input('categories', [])) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">

                                            <label class="form-check-label m-0 ms-2 p-0 fw-bold" for="cat_{{ $category->id }}" style="cursor: pointer; user-select: none;">
                                                {{ $category->name }}
                                            </label>
                                        </div>

                                        {{-- Sub Categories (If available) --}}
                                        @if($category->subCategories && $category->subCategories->count() > 0)
                                        <ul class="ps-3 pt-3">
                                            @foreach($category->subCategories as $subCat)
                                            <li class="pt-1">
                                                <div class="form-check position-relative">
                                                    <input class="form-check-input filter-checkbox m-0 p-0" type="checkbox" name="subcategories[]" value="{{ $subCat->id }}" id="subcat_{{ $subCat->id }}" {{ in_array($subCat->id, (array) request()->input('subcategories', [])) ? 'checked' : '' }} style="width: 16px; height: 16px; cursor: pointer;">

                                                    <label class="form-check-label m-0 ms-2 p-0" for="subcat_{{ $subCat->id }}" style="cursor: pointer; user-select: none; font-size: 16px;">
                                                        {{ $subCat->name }}
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Filter by price</h2>
                                <div class="shopWidgetWraper">
                                    <div class="d-flex">
                                        <div class="col-lg-6 pe-2">
                                            <label class="form-label">Min</label>
                                            <input type="number" name="min_price" id="min_price" class="form-control price-filter" placeholder="0" value="0">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Max</label>
                                            <input type="number" name="max_price" id="max_price" class="form-control price-filter" placeholder="Max" value="100000">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Color -->
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Color</h2>
                                <ul style="max-height: 300px; overflow-y: auto;">
                                    @foreach($colors as $color)
                                    <div class="form-check position-relative mt-3">
                                        {{-- Checkbox --}}
                                        <input class=" form-check-input filter-checkbox m-0 p-0" type="checkbox" name="colors[]" value="{{ $color->id }}" id="color_{{ $color->id }}" {{ in_array($color->id, (array) request()->input('colors', [])) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">

                                        {{-- Label --}}
                                        <label class="form-check-label m-0 ms-2 p-0" for="color_{{ $color->id }}" style="cursor: pointer; user-select: none; font-size: 16px;">
                                            {{ $color->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Size -->
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Size</h2>
                                <ul style="max-height: 300px; overflow-y: auto;">
                                    @foreach($sizes as $size)
                                    <div class="form-check position-relative mt-3">
                                        {{-- Checkbox --}}
                                        <input class=" form-check-input filter-checkbox m-0 p-0" type="checkbox" name="sizes[]" value="{{ $size->id }}" id="size_{{ $size->id }}" {{ in_array($size->id, (array) request()->input('sizes', [])) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">

                                        {{-- Label --}}
                                        <label class="form-check-label m-0 ms-2 p-0" for="size_{{ $size->id }}" style="cursor: pointer; user-select: none; font-size: 16px;">
                                            {{ $size->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Recent products -->
                        <div class="filter-item">
                            <div class="shop-filter-item new-product">
                                <h2>New Products</h2>
                                <ul>
                                    @foreach($recentlyAdded ?? [] as $product)
                                    <li>
                                        <div class="recent-prod row align-items-center mb-4">
                                            <div class="card-image col-lg-4">
                                                <a href="{{ route('productDetails', $product->slug) }}">
                                                    <div class="image">
                                                        <img src="{{ $product?->thumbnail }}" alt="{{$product?->name}}">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="content col-lg-8 p-0">
                                                <h5><a href="{{ route('productDetails', $product->slug) }}" class="text-truncate d-block">{{$product?->name}}</a></h5>
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
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="filter-item">
                            <div class="shop-filter-item tag-widget">
                                <h2>Popular Tags</h2>
                                <ul class="d-flex flex-wrap gap-2" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($tags as $tag)
                                    <label class="tag-label" style="cursor: pointer;">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="d-none filter-checkbox">
                                        <span class="badge border text-dark p-2">{{ $tag->name }}</span>
                                    </label>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ================= PRODUCT AREA ================= --}}
            <div class="col-lg-9">
                <div class="shop-section-top-inner">
                    <div class="shoping-product">
                        <p>We found <span id="total-count">{{$products->total()}} items</span> for you! </p>
                    </div>

                    <div class="short-by">
                        <ul>
                            <li>Sort by:</li>
                            <li>
                                <select name="sort" id="sortSelect" form="filterForm">
                                    <option value="">Latest</option>
                                    <option value="low_to_high">Low To High</option>
                                    <option value="high_to_low">High To Low</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Product Grid Container (AJAX will replace HTML inside this div) --}}
                <div class="product-wrap" id="product-grid-container" style="transition: all 0.3s ease;">
                    @include('frontend.shop.partials.product_list')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-area-end -->

<style>
    .image {
        height: 12rem;
        overflow: hidden;
    }

    .image img {
        width: 100%;
        height: 100%;
        object-fit: contain !important;
    }

    .tag-label input:checked+span {
        background: linear-gradient(180deg, #95CD2F 0%, #63911F 100%);
        color: white !important;
    }

    input[type=checkbox]+label:before {
        top: 0.20rem !important;
    }

    input[type=checkbox]+label:before {
        top: 0.20rem !important;
    }

    .recent-prod h5 a {
        color: #233D50;
    }

    .recent-prod h5 a:hover {
        color: #83B735;
    }

    .recent-prod .image {
        height: auto;
    }

    .recent-prod .rating-product i {
        background: -webkit-gradient(linear, left top, left bottom, from(#FED700), to(#F78914));
        background: linear-gradient(180deg, #FED700 0%, #F78914 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

</style>
@endsection


@push('script')
<script>
    $(document).ready(function() {

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            fetchFilteredProducts();
        });

        // Ajax Pagination
        function fetchFilteredProducts(page = 1) {
            let formData = $('#filterForm').serialize();
            formData += '&page=' + page; // Add pagination page

            $.ajax({
                url: "{{ route('shop') }}",
                type: "GET",
                 data: formData,
                 beforeSend: function() {
                    // while data is being sent
                    $('#product-grid-container').css('opacity', '0.4');
                },
                 success: function(response) {
                    // on success
                    $('#product-grid-container').html(response.html);
                    $('#total-count').text(response.total + ' items');

                    // push state
                    window.history.pushState(null, '', "?" + formData);

                    $('#product-grid-container').css('opacity', '1');
                },
                 error: function() {
                    console.error("Something went wrong with filtering.");
                    $('#product-grid-container').css('opacity', '1');
                }
            });
        }

        // Filter Checkbox & Sort Select
        $('.filter-checkbox, #sortSelect').on('change', function() {
            fetchFilteredProducts();
        });

        // Search Input & Price Filter
        let typingTimer;
        $('#searchInput, .price-filter').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                fetchFilteredProducts();
            }, 500); // debounce
        });

        // AJAX Pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchFilteredProducts(page);

            // scroll to top
            $('html, body').animate({
                scrollTop: $(".shop-section-top-inner").offset().top - 100
            }, 500);
        });
    });

</script>
@endpush

@extends('frontend.layouts.app')

@section('title', $product->name)

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
                        <li><a href="{{route('shop')}}">Product</a></li>
                        <li>Product Single</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- product-single-section  start-->
<div class="product-single-section section-padding">
    <div class="container">
        <div class="product-details">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="product-single-img">
                        <div class="product-active owl-carousel">
                            @forelse($product?->galleries ?? [] as $gallary)
                            <div class="item">
                                <img src="{{Storage::url($gallary?->src)}}" alt="Gallary Image">
                            </div>
                            @empty
                            <div class="item">
                                <img src="{{$product?->thumbnail}}" alt="Thumbnail Image">
                            </div>
                            @endforelse
                        </div>

                        @if($product?->galleries)
                        <div class="product-thumbnil-active  owl-carousel">
                            @foreach($product?->galleries ?? [] as $gallary)
                            <div class="item">
                                <img src="{{Storage::url($gallary?->src)}}" alt="Gallary Thumb">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-single-content">
                        <h3 class="text-start">{{$product->name}}</h3>
                        <div class="price">
                            <span id="price" class="present-price">{{$defaultVariant->discount_price > 0 ? $defaultVariant->discount_price : $defaultVariant->selling_price}}</span>
                            <del id="oldPrice" class="old-price">{{ $defaultVariant->discount_price ? $defaultVariant->selling_price : '' }}</del>
                        </div>
                        <div class="rating-product">
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <span>120</span>
                        </div>
                        <p>{{$product?->details?->short_description}}</p>

                        @if($product->variants->whereNotNull('color_id')->count())
                        <div class="product-filter-item color">
                            <div class="color-name">
                                <span>Color :</span>
                                <ul>
                                    @foreach($product->variants->unique('color_id') as $key => $variant)
                                    @php $out = $variant->currentStock <= 0; @endphp <li class="{{ $out ? 'opacity-50' : '' }}">
                                        <input type="radio" name="color" value="{{ $variant->color_id }}" class="color-input" id="color{{ $key }}" {{ $out ? 'disabled' : '' }}>
                                        <label for="color{{ $key }}" style="background-color: {{ $variant->color?->color_code }}" title="{{ $out ? 'Out of stock' : '' }}"></label>
                                        </li>
                                        @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        @if($product->variants->whereNotNull('size_id')->count())
                        <div class="product-filter-item color filter-size">
                            <div class="color-name">
                                <span>Sizes :</span>

                                <ul>
                                    @foreach($product->variants->unique('size_id') as $key => $variant)
                                    @if($variant?->size)
                                    <li class="color">
                                        <input type="radio" name="size" value="{{ $variant?->size->id }}" id="{{ $variant?->size?->name.$key }}" class="size size-input">
                                        <label for="{{ $variant?->size?->name.$key }}">{{ $variant?->size?->name }}</label>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <div class="pro-single-btn">
                            <div class="quantity cart-plus-minus">
                                <input class="text-value" type="text" value="1">
                            </div>
                            <a href="#" class="theme-btn-s2">Add to cart</a>
                            <a href="#" class="wl-btn"><i class="fi flaticon-heart"></i></a>
                        </div>
                        
                        <ul class="important-text">
                            <li>SKU: <span id="sku">{{ $defaultVariant->sku_code }}</span></li>
                            <li>
                                Stock:
                                <span id="stock">
                                    {{ $defaultVariant->currentStock > 0 ? $defaultVariant->currentStock.' available' : 'Out of stock' }}
                                </span>
                            </li>
                            <li><span>Categories:</span> {{$product->details->category->name}}</li>
                            <li><span>Tags:</span> @foreach($product->tags as $tag)
                                <span class="badge bg-secondary px-2 py-0 small text-light fw-normal mb-2 mb-md-0">{{$tag->name}}</span>
                                @endforeach </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-tab-area">
            <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="descripton-tab" data-bs-toggle="pill" data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton" aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings" type="button" role="tab" aria-controls="Ratings" aria-selected="false">Reviews
                        (3)</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Information-tab" data-bs-toggle="pill" data-bs-target="#Information" type="button" role="tab" aria-controls="Information" aria-selected="false">Additional info</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="descripton" role="tabpanel" aria-labelledby="descripton-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="Descriptions-item">
                                    {!! $product?->details?->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
                    <div class="container">
                        <div class="rating-section">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="comments-area">
                                        <div class="comments-section">
                                            <h3 class="comments-title">3 reviews for Stylish Pink Coat</h3>
                                            <ol class="comments">
                                                <li class="comment even thread-even depth-1" id="comment-1">
                                                    <div id="div-comment-1">
                                                        <div class="comment-theme">
                                                            <div class="comment-image"><img src="assets/images/blog-details/comments-author/img-1.jpg" alt></div>
                                                        </div>
                                                        <div class="comment-main-area">
                                                            <div class="comment-wrapper">
                                                                <div class="comments-meta">
                                                                    <h4>Lily Zener</h4>
                                                                    <span class="comments-date">December 25, 2022 at 5:30 am</span>
                                                                    <div class="rating-product">
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="comment-area">
                                                                    <p>Turpis nulla proin donec a ridiculus. Mi suspendisse faucibus sed lacus. Vitae risus eu nullam sed quam.
                                                                        Eget aenean id augue pellentesque turpis magna egestas arcu sed.
                                                                        Aliquam non faucibus massa adipiscing nibh sit. Turpis integer aliquam aliquam aliquam.
                                                                        <a class="comment-reply-link" href="#"><span>Reply...</span></a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ul class="children">
                                                        <li class="comment">
                                                            <div>
                                                                <div class="comment-theme">
                                                                    <div class="comment-image"><img src="assets/images/blog-details/comments-author/img-2.jpg" alt></div>
                                                                </div>
                                                                <div class="comment-main-area">
                                                                    <div class="comment-wrapper">
                                                                        <div class="comments-meta">
                                                                            <h4>Leslie Alexander</h4>
                                                                            <div class="rating-product">
                                                                                <i class="fi flaticon-star"></i>
                                                                                <i class="fi flaticon-star"></i>
                                                                                <i class="fi flaticon-star"></i>
                                                                                <i class="fi flaticon-star"></i>
                                                                                <i class="fi flaticon-star"></i>
                                                                            </div>
                                                                            <span class="comments-date">December 26, 2022 at 5:30 am</span>
                                                                        </div>
                                                                        <div class="comment-area">
                                                                            <p>Turpis nulla proin donec a ridiculus. Mi suspendisse faucibus sed lacus. Vitae risus eu nullam sed quam.
                                                                                Eget aenean id augue pellentesque turpis magna egestas arcu sed.
                                                                                Aliquam non faucibus massa adipiscing nibh sit. Turpis integer aliquam aliquam aliquam.
                                                                                <a class="comment-reply-link" href="#"><span>Reply...</span></a>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="comment">
                                                    <div>
                                                        <div class="comment-theme">
                                                            <div class="comment-image"><img src="assets/images/blog-details/comments-author/img-1.jpg" alt></div>
                                                        </div>
                                                        <div class="comment-main-area">
                                                            <div class="comment-wrapper">
                                                                <div class="comments-meta">
                                                                    <h4>Jenny Wilson</h4>
                                                                    <div class="rating-product">
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                    </div>
                                                                    <span class="comments-date">December 30, 2022 at 3:12 pm</span>
                                                                </div>
                                                                <div class="comment-area">
                                                                    <p>Turpis nulla proin donec a ridiculus. Mi suspendisse faucibus sed lacus. Vitae risus eu nullam sed quam.
                                                                        Eget aenean id augue pellentesque turpis magna egestas arcu sed.
                                                                        Aliquam non faucibus massa adipiscing nibh sit. Turpis integer aliquam aliquam aliquam.
                                                                        <a class="comment-reply-link" href="#"><span>Reply...</span></a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>
                                        </div> <!-- end comments-section -->
                                        <div class="col col-lg-10 col-12 review-form-wrapper">
                                            <div class="review-form">
                                                <h4>Add a review</h4>
                                                <form>
                                                    <div class="give-rat-sec">
                                                        <div class="give-rating">
                                                            <label>
                                                                <input type="radio" name="stars" value="1">
                                                                <span class="icon">★</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="stars" value="2">
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="stars" value="3">
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="stars" value="4">
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="stars" value="5">
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <textarea class="form-control" placeholder="Write Comment..."></textarea>
                                                    </div>
                                                    <div class="name-input">
                                                        <input type="text" class="form-control" placeholder="Name" required>
                                                    </div>
                                                    <div class="name-email">
                                                        <input type="email" class="form-control" placeholder="Email" required>
                                                    </div>
                                                    <div class="rating-wrapper">
                                                        <div class="submit">
                                                            <button type="submit" class="theme-btn-s2">Post
                                                                review</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end comments-area -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
                    <div class="container">
                        <div class="Additional-wrap">
                            <div class="row">
                                <div class="col-12">
                                    {!! $product?->details?->additional_info !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-single-section  end-->

<style>
</style>
@endsection

@push('script')
<script>
    const variants = @json($variants);

    let selectedColor = null;
    let selectedSize  = null;

    // ===============================
    // Initial default variant
    // ===============================
    @if($defaultVariant)
        selectedColor = {{ $defaultVariant->color_id ?? 'null' }};
        selectedSize  = {{ $defaultVariant->size_id ?? 'null' }};

        if (selectedColor) {
            document.querySelector(`.color-input[value="{{ $defaultVariant->color_id }}"]`)?.setAttribute('checked', true);
        }

        if (selectedSize) {
            document.querySelector(`.size-input[value="{{ $defaultVariant->size_id }}"]`)?.setAttribute('checked', true);
        }
    @endif

    // ===============================
    // Color change
    // ===============================
    document.querySelectorAll('.color-input').forEach(el => {
        el.addEventListener('change', e => {
            selectedColor = e.target.value;
            updateSizeAvailability();
            updateVariant();
        });
    });

    // ===============================
    // Size change
    // ===============================
    document.querySelectorAll('.size-input').forEach(el => {
        el.addEventListener('change', e => {
            selectedSize = e.target.value;
            updateVariant();
        });
    });

    // ===============================
    // Disable size if variant doesn't exist
    // ===============================
    function updateSizeAvailability() {
        document.querySelectorAll('.size-input').forEach(el => {
            const exists = variants.some(v =>
                v.color_id == selectedColor && v.size_id == el.value
            );

            el.disabled = !exists;
            el.closest('li').style.opacity = exists ? 1 : 0.4;

            if (!exists) el.checked = false;
        });
    }

    // ===============================
    // Update variant
    // ===============================
    function updateVariant() {
        const variant = variants.find(v =>
            (selectedColor ? v.color_id == selectedColor : true) &&
            (selectedSize  ? v.size_id  == selectedSize  : true)
        );

        // If variant doesn't exist
        if (!variant) return;

        // Variant Exist → price/sku always show
        document.getElementById('price').innerText =
            variant.discount > 0 ? variant.discount : variant.price;

        document.getElementById('oldPrice').innerText =
            variant.discount > 0 ? variant.price : '';

        document.getElementById('sku').innerText = variant.sku;

        document.getElementById('stock').innerText =
            variant.stock > 0
                ? variant.stock + ' available'
                : 'Out of stock';
    }

    // ===============================
    // Initial size filtering
    // ===============================
    if (selectedColor) {
        updateSizeAvailability();
        updateVariant();
    }
</script>
@endpush


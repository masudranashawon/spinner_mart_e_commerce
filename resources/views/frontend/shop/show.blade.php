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
                    <form action="{{ route('cart.store') }}" method="POST" class="product-single-content">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
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

                        {{-- Color Selection --}}
                        @if($product->variants->whereNotNull('color_id')->count())
                        <div class="product-filter-item color">
                            <div class="color-name">
                                <span>Color:</span>
                                <ul>
                                    @foreach($product->variants->unique('color_id')->filter(fn($v) => $v->color_id) as $variant)
                                    <li class="{{ $variant->currentStock <= 0 ? 'out-of-stock' : '' }}">
                                        <input type="radio" name="color" value="{{ $variant->color_id }}" class="color-input" id="color-{{ $variant->color_id }}" data-stock="{{ $variant->currentStock }}" {{ $variant->currentStock <= 0 ? 'disabled' : '' }} {{ $variant->color_id == $defaultVariant->color_id ? 'checked' : '' }}>
                                        <label for="color-{{ $variant->color_id }}" style="background-color: {{ $variant->color?->color_code }}" title="{{ $variant->color?->name }} {{ $variant->currentStock <= 0 ? '(Out of stock)' : '' }}"></label>
                                    </li>
                                    @endforeach
                                </ul>
                                @error('color')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        {{-- Size Selection --}}
                        @if($product->variants->whereNotNull('size_id')->count())
                        <div class="product-filter-item color filter-size">
                            <div class="color-name">
                                <span>Sizes:</span>
                                <ul>
                                    @foreach($product->variants->unique('size_id')->filter(fn($v) => $v->size_id) as $variant)
                                    <li>
                                        <input type="radio" name="size" value="{{ $variant->size_id }}" id="size-{{ $variant->size_id }}" class="size-input" data-stock="{{ $variant->currentStock }}" {{ $variant->size_id == $defaultVariant->size_id ? 'checked' : '' }}>
                                        <label for="size-{{ $variant->size_id }}">
                                            {{ $variant->size?->name }}
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                                @error('size')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="pro-single-btn">
                            <div class="quantity cart-plus-minus">
                                <input name="quantity" class="text-value" value="1" min="1">
                            </div>
                            <button class="btn theme-btn-s2">Add to cart</button>
                            <button class="add-wishlist btn wl-btn" data-product="{{ $product->id }}" type="button"><i class="fi flaticon-heart"></i></button>
                        </div>
                        
                         @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                         @enderror

                        {{-- Stock Info --}}
                        <ul class="important-text">
                            <li>SKU: <span id="sku">{{ $defaultVariant->sku_code }}</span></li>
                            <li>
                                Stock:
                                <span id="stock" class="{{ $defaultVariant->currentStock > 0 ? 'in-stock' : 'out-of-stock' }}">
                                    {{ $defaultVariant->currentStock > 0 ? $defaultVariant->currentStock . ' available' : 'Out of stock' }}
                                </span>
                            </li>
                            <li><span>Category:</span> {{ $product->details->category->name }}</li>
                            <li>
                                <span>Tags:</span>
                                @foreach($product->tags as $tag)
                                <span class="badge bg-secondary px-2 py-0 small text-light fw-normal mb-2 mb-md-0">{{ $tag->name }}</span>
                                @endforeach
                            </li>
                        </ul>
                    </form>
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
    // Variants data from server
    const variantsData = @json($variantsData);

    // State management
    let state = {
        selectedColor: {{$defaultVariant-> color_id ?? 'null'}},
        selectedSize: {{$defaultVariant-> size_id ?? 'null'}},
        currentVariant: null
    };

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        initializeVariants();

        // Event listeners
        document.querySelectorAll('.color-input').forEach(el => {
            el.addEventListener('change', handleColorChange);
        });

        document.querySelectorAll('.size-input').forEach(el => {
            el.addEventListener('change', handleSizeChange);
        });
    });

    function initializeVariants() {
        updateSizeAvailability();
        updateCurrentVariant();
    }

    function handleColorChange(e) {
        state.selectedColor = parseInt(e.target.value);
        updateSizeAvailability();
        updateCurrentVariant();
    }

    function handleSizeChange(e) {
        state.selectedSize = parseInt(e.target.value);
        updateCurrentVariant();
    }

    function updateSizeAvailability() {
        if (!state.selectedColor) return;

        document.querySelectorAll('.size-input').forEach(el => {
            const sizeId = parseInt(el.value);

            // Check if variant exists with this color+size combination
            const variantExists = variantsData.some(v =>
                v.color_id == state.selectedColor &&
                v.size_id == sizeId &&
                v.in_stock
            );

            const listItem = el.closest('li');

            if (variantExists) {
                el.disabled = false;
                listItem.classList.remove('disabled');
                listItem.style.opacity = '1';
            } else {
                el.disabled = true;
                el.checked = false;
                listItem.classList.add('disabled');
                listItem.style.opacity = '0.4';
            }
        });
    }

    function updateCurrentVariant() {
        // Find matching variant
        const variant = variantsData.find(v => {
            const colorMatch = !state.selectedColor || v.color_id == state.selectedColor;
            const sizeMatch = !state.selectedSize || v.size_id == state.selectedSize;
            return colorMatch && sizeMatch;
        });

        if (!variant) {
            console.warn('No variant found for selection');
            return;
        }

        state.currentVariant = variant;
        updateUI(variant);
    }

    function updateUI(variant) {
        // Update price
        const priceEl = document.getElementById('price');
        const oldPriceEl = document.getElementById('oldPrice');

        if (variant.discount) {
            priceEl.textContent = '৳' + variant.discount;
            oldPriceEl.textContent = '৳' + variant.price;
            oldPriceEl.style.display = 'inline';
        } else {
            priceEl.textContent = '৳' + variant.price;
            oldPriceEl.style.display = 'none';
        }

        // Update SKU
        document.getElementById('sku').textContent = variant.sku;

        // Update stock
        const stockEl = document.getElementById('stock');
        if (variant.in_stock) {
            stockEl.textContent = variant.stock + ' available';
            stockEl.className = 'in-stock';
        } else {
            stockEl.textContent = 'Out of stock';
            stockEl.className = 'out-of-stock';
        }

        // Update add to cart button
        updateAddToCartButton(variant);
    }

    function updateAddToCartButton(variant) {
        const addToCartBtn = document.querySelector('.theme-btn-s2');

        if (variant.in_stock) {
            addToCartBtn.classList.remove('disabled');
            addToCartBtn.textContent = 'Add to cart';
        } else {
            addToCartBtn.classList.add('disabled');
            addToCartBtn.textContent = 'Out of stock';
        }
    }

    // Export current variant for cart functionality
    window.getCurrentVariant = function() {
        return state.currentVariant;
    };

</script>

<script>
$(document).on('click', '.add-wishlist', function() {

    let productId = $(this).data('product');

    $.ajax({
        url: "{{ route('wishlist.store') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId,
        },

        success: function(response) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: response.status === 'success' ? 'success' : 'info',
                title: response.message,
                showConfirmButton: false,
                timer: 1800
            });

        },

        error: function(xhr) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Failed to add wishlist!',
                showConfirmButton: false,
                timer: 2200
            });
        }
    });

});
</script>
@endpush

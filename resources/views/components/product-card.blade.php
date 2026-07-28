@props(['product'])

<div class="col">
    <div class="product-item">
        <div class="image position-relative">
            {{-- Product Thumbnail --}}
            <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}" style="width: 100%; object-fit: cover;">

            {{-- Tags Wrapper --}}
            <div class="tags-wrapper position-absolute z-index-2" style="top: 8%; left: 5%;">
                <div class="d-flex flex-wrap gap-1 flex-column">
                    {{-- 7 Days 'New' Logic --}}
                    @if($product->created_at->diffInDays(now()) <= 7) 
                    <div class="px-1 rounded fw-bold text-uppercase text-white w-fit" style="background: linear-gradient(180deg, #95CD2F 0%, #63911F 100%); padding: 2px 10px; font-size: 11px;">
                        New
                    </div>
                    @endif

                    {{-- Pivot Table Tags (Max 2) --}}
                    @if($product->tags && $product->tags->count() > 0)
                        @foreach($product->tags->take(2) as $tag)
                        <div class="px-1 rounded fw-bold text-uppercase text-white w-fit" style="background: linear-gradient(180deg, #FED700 0%, #F78914 100%); padding: 2px 10px; font-size: 11px;">
                            {{ $tag->name }}
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="text">
            {{-- Product Name --}}
             <h2><a href="{{ route('productDetails', $product->slug) }}" class="text-truncate w-100">{{ $product->name }}</a></h2>

            {{-- Rating --}}
            <div class="rating-product">
                <i class="fi flaticon-star"></i>
                <i class="fi flaticon-star"></i>
                <i class="fi flaticon-star"></i>
                <i class="fi flaticon-star"></i>
                <i class="fi flaticon-star"></i>
                <span>{{$product->rating}}</span>
            </div>

            {{-- Price Logic --}}
            <div class="price">
                @if($product->discount_price > 0)
                <span class="present-price">৳{{ number_format($product->discount_price, 2) }}</span>
                <del class="old-price">৳{{ number_format($product->selling_price, 2) }}</del>
                @else
                <span class="present-price">৳{{ number_format($product->selling_price, 2) }}</span>
                @endif
            </div>

            <div class="shop-btn">
                <a class="theme-btn-s2" href="{{route('productDetails', $product->slug)}}">Shop Now</a>
            </div>
        </div>
    </div>
</div>
<div class="row align-items-start">
    @forelse($products ?? [] as $product)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="product-item">
            <div class="image">
                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}">

                {{-- Tags Wrapper --}}
                <div class="tags-wrapper position-absolute z-index-2" style="top: 8%; left: 5%;">
                    <div class="d-flex flex-wrap gap-1 flex-column">
                        {{-- 7 Days 'New' Logic --}}
                        @if($product->created_at->diffInDays(now()) <= 7) <div class="px-1 rounded fw-bold text-uppercase text-white w-fit" style="background: linear-gradient(180deg, #95CD2F 0%, #63911F 100%); padding: 2px 10px; font-size: 11px;">
                            New
                    </div>
                    @endif

                    {{-- Pivot Table Tags (Max 2) --}}
                    @if($product->tags && $product->tags->count() > 0)
                    @foreach($product->tags->take(2) as $tag)
                    <div class="px-1 rounded fw-bold text-uppercase text-white w-fit" style="background:linear-gradient(180deg, #FED700 0%, #F78914 100%); padding: 2px 10px; font-size: 11px;">
                        {{ $tag->name }}
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="text p-3 p-lg-4">
            <h2><a href="{{ route('productDetails', $product->slug) }}" class="text-truncate w-100">{{ $product->name }}</a></h2>
            <div class="rating-product">
                <i class="fi flaticon-star"></i>
                <i class="fi flaticon-star"></i>
                <i class="fi flaticon-star"></i>
                <i class="fi flaticon-star"></i>
                <i class="fi flaticon-star"></i>
                <span>{{$product->rating}}</span>
            </div>

            <div class="price">
                @if($product->discount_price > 0)
                <span class="present-price">৳{{ $product->discount_price }}</span>
                <del class="old-price">৳{{ $product->selling_price }}</del>
                @else
                <span class="present-price">৳{{ $product->selling_price }}</span>
                @endif
            </div>

            <div class="shop-btn p-0">
                <a class="theme-btn-s2 px-2 py-2 w-100" href="{{ route('productDetails', $product->slug) }}">Shop Now</a>
            </div>
        </div>
    </div>

</div>
    @empty
    <div class="col-12 text-center py-5">
        <h4 class="text-muted">No products found!</h4>
    </div>
    @endforelse
</div>

{{-- Pagination Links --}}
<div class="mt-4">
    {{ $products->links() }}
</div>

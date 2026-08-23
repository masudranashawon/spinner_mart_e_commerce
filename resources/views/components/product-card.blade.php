@props(['product'])

@php
$qvData = [
'id' => $product->id,
'name' => $product->name,
'slug' => $product->slug,
'image' => asset($product->thumbnail),
'short_desc' => \Illuminate\Support\Str::limit($product->details?->short_description ?? 'No description available', 120),
'base_price' => $product->discount_price > 0 ? $product->discount_price : $product->selling_price,
'old_price' => $product->discount_price > 0 ? $product->selling_price : null,


'variants' => $product->variants->map(function($v) {
return [
'id' => $v->id,
'color_id' => $v->color_id,
'color_code' => $v->color?->color_code,
'color_name' => $v->color?->name,
'size_id' => $v->size_id,
'size_name' => $v->size?->name,
'price' => $v->discount_price > 0 ? $v->discount_price : $v->selling_price,
'old_price' => $v->discount_price > 0 ? $v->selling_price : null,
'stock' => $v->current_stock
];
})->toArray()
];
@endphp

<div class="product-item min-w-0">
    <div class="image position-relative">
        {{-- Product Thumbnail --}}
        <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}" style="height: 100%; object-fit: contain;">

        {{-- Tags Wrapper --}}
        <div class="tags-wrapper position-absolute z-index-2" style="top: 8%; left: 5%;">
            <div class="d-flex flex-wrap gap-1 flex-column">
                {{-- 7 Days 'New' Logic --}}
                @if($product->created_at->diffInDays(now()) <= 3) 
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

        {{-- Quick View --}}
        <a href="javascript:void(0)" class="quickview-btn transition-all position-absolute d-lg-none bottom-0 start-50 translate-middle d-block" data-product='@json($qvData)'>
            <i class="ti-eye"></i>
        </a>
    </div>

    <div class="text p-3">
        {{-- Product Name --}}
        <h2><a href="{{ route('productDetails', $product->slug) }}" class="text-truncate w-100 d-block">{{ $product->name }}</a></h2>

        {{-- Rating --}}
        <div class="rating-product">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $product->rating)
                    <i class="fi flaticon-star"></i> 
                @else
                    <i class="fi flaticon-star empty-star"></i>
                @endif
            @endfor
            <span class="text-muted ms-1">({{ $product->reviews }})</span> 
        </div>

        {{-- Price Logic --}}
        <div class="price">
            @if($product->discount_price > 0)
            <span class="present-price">{{ format_price($product->discount_price) }}</span>
            <del class="old-price">{{ format_price($product->selling_price) }}</del>
            @else
            <span class="present-price">{{ format_price($product->selling_price) }}</span>
            @endif
        </div>

        <div class="shop-btn">
            <a class="theme-btn-s2" href="{{route('productDetails', $product->slug)}}">Shop Now</a>
        </div>
    </div>
</div>
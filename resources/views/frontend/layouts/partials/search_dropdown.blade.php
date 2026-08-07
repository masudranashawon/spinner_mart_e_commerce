@if($products->count() > 0)
<ul>

    @foreach($products as $product)
    <li class="border-bottom" style="transition: background 0.2s;">
        <a href="{{ route('productDetails', $product->slug) }}" class="d-flex align-items-center text-decoration-none p-2 hover-bg-light" style="color: inherit;">

            {{-- Product Image --}}
            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid #eee;" class="me-3">

            {{-- Product Details --}}
            <div style="min-width:0; line-height: 1.2;">
                <h6 class="mb-1 text-dark text-truncate" style="font-size: 14px; font-weight: 500;">
                    {{ $product->name }}
                </h6>

                <div class="price">
                    @if($product->discount_price > 0)
                    <strong style="font-size: 13px;" class="text-success">{{ format_price($product->discount_price) }}</strong>
                    <del class="text-muted ms-1" style="font-size: 11px;">{{ format_price($product->selling_price) }}</del>
                    @else
                    <strong style="font-size: 13px;" class="text-success">{{ format_price($product->selling_price) }}</strong>
                    @endif
                </div>
            </div>

        </a>
    </li>
    @endforeach

</ul>
@else
<div class="text-center p-3 text-muted" style="font-size: 14px;">
    No product found
</div>
@endif

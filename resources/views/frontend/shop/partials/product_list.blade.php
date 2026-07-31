  <div class="product-wrapper row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 m-0 p-0" style="transition: all 0.3s ease;">
      @foreach($products ?? [] as $product)
      <div class="col">
          <x-product-card :product="$product" />
      </div>
      @endforeach
  </div>

  @if($products->count() == 0)
  <div class="text-center mt-4">
      <h4 class="text-muted text-center">No product found!</h4>
  </div>
  @endif

  {{-- Pagination Links --}}
  <div class="mt-4">
      {{ $products->links() }}
  </div>

  <style>
  
      .product-item {
          margin-bottom: 5px !important;
      }

      .product-item .text .shop-btn {
          padding-bottom: 10px;
      }

      .theme-btn-s2 {
          padding: 5px 20px;
      }

  </style>

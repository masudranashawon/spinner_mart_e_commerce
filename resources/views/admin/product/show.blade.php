@extends('admin.layouts.app')

@section('content')
  {{-- Product Details --}}
  <div class="container-fluid">
    {{--  Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold mb-0">
        {{ $product->name ?? 'Product Name' }}
      </h4>

      <div class="d-flex justify-content-center align-items-center">
        <a href="{{ route('product.index') }}"
          class="d-flex justify-content-center align-items-center bg-primary rounded px-2 py-1 text-white">
          <i class="link-icon" data-feather="arrow-left"></i>
          <span class="ml-1">Back</span>
        </a>

        <a href="{{ route('product.index') }}"
          class="d-flex justify-content-center align-items-center bg-secondary ml-1 rounded px-2 py-1 text-white">
          <i class="link-icon" data-feather="edit"></i>
          <span class="ml-1">Edit</span>
        </a>

      </div>
    </div>

    {{-- Product Images and Info --}}
    <div class="row">
      {{-- Product Images --}}
      <div class="col-md-5">
        <div class="card mb-3">
          <div class="card-body text-center">

            <img src="{{ $product?->thumbnail }}" class="img-fluid mb-3 border" style="max-height: 360px;"
              alt="Product Image">

            {{-- Gallery --}}
            @if ($productGalleries->count())
              <div class="d-flex flex-wrap">
                @foreach ($productGalleries as $gallery)
                  <div class="mb-2 mr-2">
                    <img src="{{ $gallery['src'] }}" alt="{{ $gallery['media_id'] }}" class="img-thumbnail"
                      style="width: 7rem; height: 7rem; object-fit: cover;">
                  </div>
                @endforeach
              </div>
            @else
              <p class="text-muted">No gallery images found.</p>
            @endif
          </div>
        </div>
      </div>

      {{-- Product Info  --}}
      <div class="col-md-7">
        <div class="card">
          <div class="card-body">

            <h5 class="font-weight-bold mb-3">General Information</h5>

            <table class="table-sm table-borderless mb-0 table">
              <tr>
                <td class="text-muted">Product SKU</td>
                <td>{{ $product->sku_code }}</td>
              </tr>
              <tr>
                <td class="text-muted">Buying Price</td>
                <td>৳ {{ $product->buying_price }}</td>
              </tr>
              <tr>
                <td class="text-muted">Selling Price</td>
                <td class="font-weight-bold">৳ {{ $product->selling_price }}</td>
              </tr>
              <tr>
                <td class="text-muted">Sold Count</td>
                <td> {{ $product->sold_count ?? '0.00' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Brand</td>
                <td>{{ $product->details->brand->name ?? 'N/A' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Category</td>
                <td>{{ $product->details->category->name }}</td>
              </tr>
              <tr>
                <td class="text-muted">Sub Category</td>
                <td>{{ $product->details->subCategory->name }}</td>
              </tr>
              <tr>
                <td class="text-muted">Status</td>
                <td>
                  @if (($product->status ?? 1) == 1)
                    <span class="badge badge-success">Active</span>
                  @else
                    <span class="badge badge-danger">Inactive</span>
                  @endif
                </td>
              </tr>
            </table>

          </div>
        </div>
      </div>
    </div>

    {{-- Short Description --}}
    <div class="card mt-4">
      <div class="card-body">
        <h5 class="font-weight-bold mb-3">Short Description</h5>
        <div class="text-muted">
          {!! $product->details->short_description ?? '<p>No Short description available.</p>' !!}
        </div>
      </div>
    </div>

    {{-- Description --}}
    <div class="card mt-4">
      <div class="card-body">
        <h5 class="font-weight-bold mb-3">Description</h5>
        <div class="text-muted">
          {!! $product->details->description ?? '<p>No description available.</p>' !!}
        </div>
      </div>
    </div>

    {{-- Additional Information --}}
    <div class="card mt-3">
      <div class="card-body">
        <h5 class="font-weight-bold mb-3">Additional Information</h5>
        <div class="text-muted">
          {!! $product->details->additional_info ?? '<p>No additional information.</p>' !!}
        </div>
      </div>
    </div>

    {{-- Back Button --}}
    <a href="{{ route('product.index') }}"
      class="d-inline-flex justify-content-start align-items-start bg-primary mt-3 rounded px-2 py-1 text-white">
      <i class="link-icon" data-feather="arrow-left"></i>
      <span class="ml-1">Back</span>
    </a>
  </div>
@endsection

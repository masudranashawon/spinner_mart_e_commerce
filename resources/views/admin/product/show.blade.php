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

        <a href="{{ route('product.edit', $product->id) }}"
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

          <div class="row card-body text-center">
            {{-- Product Thumbnail --}}
            <div class="col-lg-6 border-right">
              <h5 class="font-weight-bold mb-2">Product Thumbnail</h5>
              <img src="{{ $product?->thumbnail }}" class="img-fluid img-thumbnail mb-3 border" style="max-height: 360px;"
                alt="Product Image">
            </div>

            {{-- Product Gallery --}}
            <div class="col-lg-6">
              <h5 class="font-weight-bold mb-2">Product Gallery</h5>

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

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#variantModal">
      Add Variants
    </button>

    <!-- Modal -->
    <div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <form action="{{ route('products.variants.bulkStore', $product->id) }}" method="POST" class="w-100">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="variantModalLabel">Add Variants</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="link-icon" data-feather="x"></i></span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table-bordered table" id="variantTable">
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- initial row will be added by jQuery -->
                </tbody>
              </table>
              <button type="button" class="btn btn-secondary" id="addVariantRow">Add Variant Row</button>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save Variants</button>
            </div>
          </div>
        </form>
      </div>
    </div>


    <table style="display:none;">
      <tbody id="variantRowTemplate">
        <tr data-index="__INDEX__">
          <td>
            <input type="text" name="variants[__INDEX__][sku]" class="form-control skuInput">
          </td>
          <td>
            <select name="variants[__INDEX__][color_id]" class="form-control colorSelect">
              <option value="">Select Color</option>
              @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ $color->name }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <select name="variants[__INDEX__][size_id]" class="form-control sizeSelect">
              <option value="">Select Size</option>
              @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <input type="number" name="variants[__INDEX__][buying_price]" class="form-control"
              value="{{ $product->buying_price }}">
          </td>
          <td>
            <input type="number" name="variants[__INDEX__][selling_price]" class="form-control"
              value="{{ $product->selling_price }}">
          </td>
          <td>
            <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
          </td>
        </tr>
      </tbody>
    </table>


    {{-- Variants --}}
    <div class="card mt-4">
      <div class="card-body">
        <h5 class="font-weight-bold mb-3">Product Variants</h5>
        <div class="text-muted">
          {!! $product->details->short_description ?? '<p>No Short description available.</p>' !!}
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


@push('script')
  <script>
    $(function() {
      let variantIndex = 0;

      function generateSKU(row) {
        let productId = {{ $product->id }};
        let colorId = row.find('.colorSelect').val() || 0;
        let sizeId = row.find('.sizeSelect').val() || 0;
        row.find('.skuInput').val('P' + productId + '-C' + colorId + '-S' + sizeId);
      }

      $('#addVariantRow').on('click', function() {
        let html = $('#variantRowTemplate').html().replace(/__INDEX__/g, variantIndex);
        let row = $(html);
        $('#variantTable tbody').append(row);
        generateSKU(row);
        variantIndex++;
      });

      $('#variantTable').on('change', '.colorSelect, .sizeSelect', function() {
        generateSKU($(this).closest('tr'));
      });

      $('#variantTable').on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
      });
    });
  </script>
@endpush

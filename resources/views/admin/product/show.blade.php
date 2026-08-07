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
      <div class="col-md-4">
        <div class="card mb-3">

          <div class="row card-body text-center">
            {{-- Product Thumbnail --}}
            <div class="col-lg-5 border-right">
              <h5 class="font-weight-bold mb-2">Product Thumbnail</h5>
              <img src="{{ $product?->thumbnail }}" class="img-fluid img-thumbnail mb-3 border" style="max-height: 360px;"
                alt="Product Image">
            </div>

            {{-- Product Gallery --}}
            <div class="col-lg-7 d-flex flex-column align-items-center" style="min-height: 250px;">

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
                <div class="d-flex grow align-items-center">
                  <p class="text-muted mb-0">No gallery images added yet.</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- Product Info  --}}
      <div class="col-md-3">
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
                <td>{{ format_price($product->buying_price) }}</td>
              </tr>
              <tr>
                <td class="text-muted">Selling Price</td>
                <td class="font-weight-bold">{{ format_price($product->selling_price) }}</td>
              </tr>
              <tr>
                <td class="text-muted">Discounted Price</td>
                <td class="font-weight-bold">{{ format_price($product->discount_price) }}</td>
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
                  @if ($product->is_active)
                    <span class="badge badge-success">Active</span>
                  @else
                    <span class="badge badge-danger">Inactive</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td class="text-muted">Visibility Flags</td>
                <td>
                  @if ($product->is_deal_of_the_day)
                    <span class="badge badge-info mb-1">Deal of the Day</span> <br>
                  @endif
                  
                  @if ($product->is_trending)
                    <span class="badge badge-primary">Trending</span>
                  @endif

                  @if (!$product->is_deal_of_the_day && !$product->is_trending)
                     <span class="text-muted">Normal Product</span>
                  @endif
                </td>
              </tr>
            </table>

          </div>
        </div>
      </div>

      {{-- Stock Info  --}}
      <div class="col-md-5">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="font-weight-bold">Stock Information</h5>
            <button class="btn btn-primary" data-toggle="modal" data-target="#stockUpdateModal">
              Update Stock
            </button>
          </div>

          <div class="card-footer table-responsive" style="max-height: 300px; overflow-y: scroll;">
            <table class="table-bordered table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Variant</th>
                  <th>Quantity</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($stockHistory as $stock)
                  <tr>
                    <td>{{ $stock->created_at->format('d/m/y h:i A') }}</td>
                    <td>
                      @if ($stock->variant->size || $stock->variant->color)
                        {{ $stock->variant->size ? 'Size: ' . $stock->variant->size->name : '' }}
                        {{ $stock->variant->size && $stock->variant->color ? ',' : '' }}
                        {{ $stock->variant->color ? 'Color: ' . $stock->variant->color->name : '' }}
                      @else
                        Default Variant
                      @endif
                    </td>
                    <td>{{ $stock->quantity }}</td>
                    <td>
                      <span
                        class="{{ $stock->type == 'stock_in' ? 'badge badge-success' : ($stock->type == 'stock_out' ? 'badge badge-danger' : ($stock->type == 'return' ? 'badge badge-info' : 'badge badge-warning')) }}">
                        {{ ucfirst(str_replace('_', ' ', $stock->type)) }}
                      </span>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">No stock history found</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Variants --}}
    <div class="card mt-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5>{{ count($productVariants) > 0 ? count($productVariants) . ' Variants' : 'Variants' }}</h5>

        <button type="button" class="btn btn-primary px-2 py-1" data-toggle="modal" data-target="#variantModal">
          Add Variants <i class="link-icon" data-feather="plus-circle"></i>
        </button>
      </div>
      <div class="card-footer table-responsive">
        @if (count($productVariants) > 0)
          <table class="table-hover table">
            <thead>
              <tr>
                <th>Product SKU</th>
                <th>Options</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Discount Price</th>
                <th>Stock</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($productVariants ?? [] as $key => $variant)
                <tr>
                  <td>{{ $variant?->sku_code }}</td>
                  <td>
                    <strong class="fw-bold bg-light">
                      {{ $variant?->size ? 'Size: ' . $variant?->size?->name : '' }}
                      {{ $variant?->size && $variant?->color ? ',' : '' }}
                      {{ $variant?->color ? 'Colour: ' . $variant?->color?->name : '' }}
                    </strong>
                  </td>
                  <td>{{ format_price($variant?->buying_price) }}</td>
                  <td>{{ format_price($variant?->selling_price) }}</td>
                  <td>{{ $variant?->discount_price ? $variant?->discount_price : '-' }}</td>
                  <td>{{ $variant?->current_stock }}</td>
                  <td class="text-center">
                    <button class="btn btn-primary btn-icon edit-variant-btn" data-toggle="modal"
                      data-target="#variantEditModal" data-variant='@json($variant)'>
                      <i data-feather="edit"></i>
                    </button>

                    <a href="{{ route('product.variants.destroy', [$product?->id, $variant?->id]) }}"
                      class="delete-confirm btn btn-danger btn-icon btn-md">
                      <i data-feather="trash-2"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p class="text-secondary text-center">No variants found for this product.</p>
        @endif
      </div>
    </div>

    {{-- Short Description --}}
    <div class="card mt-4">
      <div class="card-header">
        <h5 class="font-weight-bold">Short Description</h5>
      </div>
      <div class="card-footer">
        <div class="text-muted">
          {!! $product->details->short_description ?? '<p>No Short description available.</p>' !!}
        </div>
      </div>
    </div>

    {{-- Description --}}
    <div class="card mt-4">
      <div class="card-header">
        <h5 class="font-weight-bold">Description</h5>
      </div>
      <div class="card-footer">
        <div class="text-muted">
          {!! $product->details->description ?? '<p>No description available.</p>' !!}
        </div>
      </div>
    </div>

    {{-- Additional Information --}}
    <div class="card mt-3">
      <div class="card-header">
        <h5 class="font-weight-bold">Additional Information</h5>
      </div>
      <div class="card-footer">
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

  <!-- Add Variant Modal -->
  <div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
      <form action="{{ route('products.variants.bulkStore', $product->id) }}" method="POST" class="w-100">
        @csrf

        <input type="hidden" name="_form" value="variant_create">

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="variantModalLabel">Add Variants</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="link-icon" data-feather="x"></i></span>
            </button>
          </div>

          <div class="modal-body table-responsive">
            <table class="table-bordered table" id="variantTable">
              <thead>
                <tr>
                  <th>SKU</th>
                  <th>Color</th>
                  <th>Size</th>
                  <th>Buying Price</th>
                  <th>Selling Price</th>
                  <th>Discount Price</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <!-- initial row will be added by jQuery -->
              </tbody>
            </table>

            <button type="button" class="btn btn-secondary mt-3 px-2 py-1" id="addVariantRow">
              <i class="link-icon" data-feather="plus-circle"></i> Add Variant Row</button>

            {{-- Validation Errors --}}
            @if ($errors->any())
              <div class="alert text-danger">
                <ul class="mb-0 p-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Save Variants</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Template for variant rows --}}
  <div class="table-responsive">
    <table style="display:none;">
      <tbody id="variantRowTemplate">
        <tr data-index="__INDEX__">
          <td>
            <x-input name="variants[__INDEX__][sku]" placeholder="Write SKU" class="skuInput -mb-1rem" />
          </td>
          <td>
            <x-select name="variants[__INDEX__][color_id]" class="colorSelect -mb-1rem">
              <option value="">Select Color</option>
              @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ $color->name }}</option>
              @endforeach
            </x-select>
          </td>
          <td>
            <x-select name="variants[__INDEX__][size_id]" class="sizeSelect -mb-1rem">
              <option value="">Select Size</option>
              @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
              @endforeach
            </x-select>
          </td>
          <td>
            <x-input type="number" name="variants[__INDEX__][buying_price]" value="{{ $product->buying_price }}"
              class="-mb-1rem" />
          </td>
          <td>
            <x-input type="number" name="variants[__INDEX__][selling_price]" value="{{ $product->selling_price }}"
              class="-mb-1rem" />
          </td>
          <td>
            <x-input type="number" name="variants[__INDEX__][discount_price]" value="{{ $product->discount_price }}"
              class="-mb-1rem" />
          </td>
          <td>
            <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  {{-- Edit Variant Modal --}}
  <div class="modal fade" id="variantEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editVariantForm" method="POST" action="">
        @csrf
        @method('PUT')

        <div class="modal-content">
          <div class="modal-header">
            <h5>Edit Variant</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            <input type="hidden" name="_form" value="variant_edit">

            <x-input type="hidden" id="variant_id" name="variant_id" />

            <x-select label="Size" name="edit_size" id="edit_size">

              @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
              @endforeach

            </x-select>

            <x-select label="Color" name="edit_color" id="edit_color">

              @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ $color->name }}</option>
              @endforeach

            </x-select>

            <x-input label="Buying Price" type="number" name="edit_buying_price" id="edit_buying_price" />

            <x-input label="Selling Price" type="number" name="edit_selling_price" id="edit_selling_price" />

            <x-input label="Discount Price Price" type="number" name="edit_discount_price" id="edit_discount_price" />

            @error('variant')
              <p class="text-danger fw-bold mt-2">{{ $message }}</p>
            @enderror
          </div>


          <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Update Variant</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Stock Update Modal --}}
  <div class="modal fade" id="stockUpdateModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form method="POST" action="{{ route('products.stock.bulkUpdate', $product->id) }}" class="w-100">
        @csrf

        <div class="modal-content">
          <input type="hidden" name="_form" value="stock_update">

          <div class="modal-header">
            <h5 class="modal-title">Update Stock</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div class="table-responsive">
              <table class="table">
                <tbody>
                  @foreach ($stockVariants as $index => $variant)
                    @if ($variant->size || $variant->color)
                      <tr>
                        <td class="border-top-0 font-weight-bold pb-0 pt-2">
                          {{ $variant->size ? 'Size: ' . $variant->size->name : '' }}
                          {{ $variant->size && $variant->color ? ',' : '' }}
                          {{ $variant->color ? 'Color: ' . $variant->color->name : '' }}
                        </td>
                      </tr>
                    @endif
                    <tr class="border-bottom p-2">
                      <input type="hidden" name="stocks[{{ $index }}][variant_id]"
                        value="{{ $variant->id }}">
                      <td class="border-top-0">
                        <select name="stocks[{{ $index }}][type]" class="form-control">
                          <option value="stock_in">Add Stock</option>
                          <option value="stock_out">Remove Stock</option>
                          <option value="return">Return</option>
                          <option value="adjustment">Adjustment</option>
                        </select>
                      </td>

                      <td class="border-top-0">
                        <div class="input-group input-group-sm py-0">
                          <span class="input-group-text py-0">Qty
                            ({{ $variant->current_stock }})
                          </span>
                          <input type="number" name="stocks[{{ $index }}][quantity]" class="form-control"
                            min="1">
                        </div>
                      </td>

                      <td class="border-top-0">
                        <div class="input-group input-group-sm py-0">
                          <span class="input-group-text py-0">Notes</span>
                          <input type="text" name="stocks[{{ $index }}][note]" class="form-control">
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update Stock</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('style')
  <style>
    .-mb-1rem {
      margin-bottom: -1rem;
    }
  </style>
@endpush

@push('script')
  <script>
    $(document).ready(function() {
      // Add Variant Row
      let variantIndex = 0;

      $('#addVariantRow').on('click', function() {
        let template = $('#variantRowTemplate').html();
        let html = template.replace(/__INDEX__/g, variantIndex);
        let row = $(html);
        $('#variantTable tbody').append(row);

        // Generate SKU
        let prefix = 'SF';
        let random = Math.random().toString(36).substring(2, 6).toUpperCase();
        let time = Date.now().toString().slice(-4);
        row.find('.skuInput').val(prefix + random + time);

        variantIndex++;
      });

      $('#variantTable').on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
      });

      // Edit Variant Modal
      $('#variantEditModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        if (!button.length) return;

        let variant = button.data('variant');
        let productId = {{ $product->id }};

        // Set form action dynamically
        let url = "{{ route('product.variants.update', ['product' => ':product', 'variant' => ':variant']) }}"
          .replace(':product', productId)
          .replace(':variant', variant.id);

        $('#editVariantForm').attr('action', url);

        // Populate fields
        $('#variant_id').val(variant.id);
        $('#edit_size').val(variant.size_id);
        $('#edit_color').val(variant.color_id);
        $('#edit_buying_price').val(variant.buying_price);
        $('#edit_selling_price').val(variant.selling_price);
        $('#edit_discount_price').val(variant.discount_price);
      });

      // Show modals on validation errors
      @if ($errors->any())
        let formType = @json(old('_form'));

        if (formType === 'variant_create') {
          $('#variantModal').modal('show');
        }

        if (formType === 'stock_update') {
          $('#stockUpdateModal').modal('show');
        }

        if (formType === 'variant_edit') {
          let oldData = @json(old());
          let productId = {{ $product->id }};
          let url = "{{ route('product.variants.update', ['product' => ':product', 'variant' => ':variant']) }}"
            .replace(':product', productId)
            .replace(':variant', oldData.variant_id);

          $('#editVariantForm').attr('action', url);

          $('#variant_id').val(oldData.variant_id);
          $('#edit_size').val(oldData.edit_size);
          $('#edit_color').val(oldData.edit_color);
          $('#edit_buying_price').val(oldData.edit_buying_price);
          $('#edit_selling_price').val(oldData.edit_selling_price);
          $('#edit_discount_price').val(oldData.edit_discount_price);

          $('#variantEditModal').modal('show');
        }
      @endif
    });
  </script>
@endpush

@extends('admin.layouts.app')

@section('content')
  {{-- All Product --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5>All Products</h5>

      <a href="{{ route('product.create') }}"
        class="d-flex justify-content-center align-items-center bg-primary rounded px-2 py-1 text-white">
        <span class="mr-1">Add a product</span>
        <i class="link-icon" data-feather="plus-circle"></i>
      </a>
    </div>

    <div class="card-footer">
      <table class="data-table table-hover table">
        <thead>
          <tr>
            <th>Thumbnail</th>
            <th>Product SKU</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Brand</th>
            <th>Status</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>

        <tbody>
          @forelse($products ?? [] as $key => $product)
            <tr>
              <td><img src="{{ $product?->thumbnail }}" alt="{{ $product?->name }}" class="object-fit-cover"
                  style="object-fit:cover;"></td>
              <td>{{ $product?->sku_code }}</td>
              <td>{{ $product?->name }}</td>
              <td>{{ $product?->details?->category->name }}</td>
              <td>{{ $product?->details?->subCategory->name }}</td>
              <td>{{ $product?->details?->brand->name }}</td>
              <td>
                @if ($product?->status == 1)
                  <span class="badge badge-success">Active</span>
                @else
                  <span class="badge badge-danger">Inactive</span>
                @endif
              </td>

              <td class="text-center">
                <a href="{{ route('product.show', $product?->id) }}"><button class="btn btn-secondary btn-icon btn-md"><i
                      data-feather="eye"></i></button></a>
                <a href="{{ route('product.edit', $product?->id) }}"><button class="btn btn-primary btn-icon btn-md"><i
                      data-feather="edit"></i></button></a>
                <button class="btn btn-danger btn-icon btn-md"><i data-feather="trash-2"></i></button>
              </td>
            </tr>
          @empty
            <tr class="text-center">
              <td colspan="8">No Product Found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection

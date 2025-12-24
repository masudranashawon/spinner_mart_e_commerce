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
      <h1>Products</h1>
    </div>
  </div>
@endsection

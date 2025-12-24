@extends('admin.layouts.app')

@section('content')
  {{-- Add new Product --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5>Add New Product</h5>

      <a href="{{ route('product.index') }}"
        class="d-flex justify-content-center align-items-center bg-primary rounded px-2 py-1 text-white">
        <i class="link-icon" data-feather="arrow-left"></i>

        <span class="ml-1">Back</span>
      </a>
    </div>

    <div class="card-footer">
      <form action="" method="post" enctype="multipart/form-data">
        @csrf

        <fieldset class="p-lg-4 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Product Info</span>
          </legend>

          <x-input name="name" label="Product Name" placeholder="Product Name" :required="true" />
          <x-input name="short_description" label="Short Description" placeholder="Short Description" />
          <x-file name="image" label="Product Image" />

          <div class="d-flex justify-content-end">
            <a href="{{ route('product.create') }}" class="btn btn-secondary d-flex align-items-center px-2">
              <i class="link-icon mr-2" data-feather="rotate-cw"></i>Reset</a>

            <button type="submit" class="btn btn-primary ml-2">Submit</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
@endsection

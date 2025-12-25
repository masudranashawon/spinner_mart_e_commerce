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
      <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <fieldset class="p-lg-4 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Product Information</span>
          </legend>

          <x-input name="name" label="Product Name" placeholder="Product Name" :required="true" />
          <x-textarea name="short_description" label="Short Description" placeholder="Short Description..." />
          <x-file name="image" label="Product Image" />
        </fieldset>

        <fieldset class="p-lg-4 mt-3 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Genaral Information</span>
          </legend>

          <div class="row">
            <div class="col-md-6">
              <x-select name="category" label="Select Category" :required="true">
                <option value="">Select Category</option>
                @foreach ($categories ?? [] as $category)
                  <option value="{{ $category?->id }}">{{ $category->name }}</option>
                @endforeach
              </x-select>
            </div>

            <div class="col-md-6">
              <x-select name="sub_category" label="Select Sub Category" :required="true">
                <option value="">Select Sub Category</option>
                @foreach ($subCategories ?? [] as $subCategory)
                  <option value="{{ $subCategory?->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </x-select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <x-input name="sku" label="Product SKU" placeholder="Product SKU" :required="true" />
            </div>

            <div class="col-md-6">
              <x-input name="buying_price" label="Buying Price" placeholder="Buying Price" :required="true" />
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <x-input name="selling_price" label="Selling Price" placeholder="Selling Price" :required="true" />
            </div>

            <div class="col-md-6">
              <x-select name="brand" label="Select Brand">
                <option value="">Select Brand</option>
                @foreach ($brands ?? [] as $brand)
                  <option value="{{ $brand?->id }}">{{ $brand->name }}</option>
                @endforeach
              </x-select>
            </div>
          </div>
        </fieldset>

        <fieldset class="p-lg-4 mt-3 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Product Description</span>
          </legend>

          <x-textarea name="description" label="Description" placeholder="Write product description..."
            class="tinymce-editor" />

          <x-textarea name="additional_information" label="Additional Information"
            placeholder="Add product additional information..." class="tinymce-editor" />
        </fieldset>

        <div class="d-flex justify-content-end my-4">
          <a href="{{ route('product.create') }}" class="btn btn-secondary d-flex align-items-center px-2">
            <i class="link-icon mr-2" data-feather="rotate-cw"></i>Reset</a>

          <button type="submit" class="btn btn-primary ml-2">Submit</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('script')
  <script src="{{ asset('admin/assets/vendors/tinymce/tinymce.min.js') }}"></script>

  <script>
    $(function() {
      'use strict';

      //Tinymce editor
      if ($(".tinymce-editor").length) {
        tinymce.init({
          selector: '.tinymce-editor',
          height: 300,
          toolbar1: 'undo redo | insert | styleselect | bold italic forecolor backcolor emoticons | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media',
          plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
          ],
          image_advtab: true,
          content_css: []
        });
      }
    });
  </script>
@endpush

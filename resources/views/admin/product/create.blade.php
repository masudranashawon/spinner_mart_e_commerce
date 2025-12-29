@extends('admin.layouts.app')

@push('style')
  <style>
    .thumbnail-preview {
      height: 7rem;
      object-fit: contain;
      cursor: pointer;
    }

    .gallery-item {
      width: 7rem;
      height: 7rem;
      position: relative;
      margin-right: .5rem;
    }

    .delete-icon {
      width: 1rem;
      height: 1rem;
    }

    .gallery-item .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      display: flex;
      justify-content: flex-end;
      align-items: flex-start;
      padding: 2px;
      border-radius: 0.25rem;
      opacity: 0;
      transition: opacity 0.2s;
    }

    .gallery-item:hover .overlay {
      opacity: 1;
    }

    .gallery-item .overlay button {
      font-size: 0.7rem;
      line-height: 1;
      width: 2rem;
      height: 2rem;
      padding: 0;
    }
  </style>
@endpush

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

          <x-input name="name" label="Product Name" placeholder="Product Name" />
          <x-textarea name="short_description" label="Short Description" placeholder="Short Description..." />
          <x-file name="image" label="Product Image" />
        </fieldset>

        <fieldset class="p-lg-4 mt-3 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Genaral Information</span>
          </legend>

          <div class="row">
            <div class="col-md-6 d-flex flex-column">
              <button type="button" id="generateSku" class="btn btn-sm btn-primary align-self-end px-2 py-1"
                style="margin-bottom:-1.5rem; cursor:pointer; z-index:2;">Generate
                SKU</button>
              <x-input name="product_sku" id="product_sku" label="Product SKU" placeholder="Product SKU" />
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

          <div class="row">
            <div class="col-md-6">
              <x-select name="category" id="category" label="Select Category">
                <option value="">Select Category</option>
                @foreach ($categories ?? [] as $category)
                  <option value="{{ $category?->id }}">{{ $category->name }}</option>
                @endforeach
              </x-select>
            </div>

            <div class="col-md-6">
              <x-select name="sub_category" label="Select Sub Category">
                <option value="">Select Sub Category</option>
                @foreach ($subCategories ?? [] as $subCategory)
                  <option value="{{ $subCategory?->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </x-select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <x-input name="buying_price" label="Buying Price" placeholder="Buying Price" />
            </div>

            <div class="col-md-6">
              <x-input name="selling_price" label="Selling Price" placeholder="Selling Price" />
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

        <!-- Images -->
        <fieldset class="p-lg-4 mt-3 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Product Images</span>
          </legend>

          <div class="row mb-3">
            <div class="col-12">
              <p class="d-block w-100 mb-2">Product Thumbnail</p>

              <label for="thumbnail">
                <img src="{{ asset('/upload-picture.png') }}" class="thumbnail-preview" id="thumbnail-preview"
                  alt="thumbnail" />
              </label>

              <input type="file" name="thumbnail" id="thumbnail" class="form-control sr-only" />

              <div>
                @error('thumbnail')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-3">
              <p class="mb-2">Product Gallery</p>
              <div id="galleryDropArea" class="rounded border p-4 text-center" style="cursor:pointer;background:#fafafa">
                <i data-feather="upload-cloud"></i>

                <h6>Click or drop images here</h6>
                <small>
                  Max 5 images • Max 2MB per file • JPG, PNG, WEBP, GIF
                </small>
              </div>
            </div>

            <!-- gallery images preview -->
            <div class="col-lg-9 mt-lg-0 mt-3">
              <!-- Hidden actual file input -->
              <input type="file" name="gallery_images[]" id="galleryInput" multiple accept="image/*" hidden>
              <!-- Visible dummy input for clicking -->
              <input type="file" id="dummyGalleryInput" multiple accept="image/*" hidden>

              <div id="galleryPreview" class="d-flex mt-lg-4 flex-wrap gap-2"></div>
            </div>
          </div>
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
    $(document).ready(function() {
      'use strict';
      //Tinymce editor
      if ($(".tinymce-editor").length) {
        tinymce.init({
          selector: '.tinymce-editor',
          height: 300,
          theme: 'silver',
          branding: false,
          image_advtab: true,

          plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime table media'
          ],

          toolbar: [
            'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            'print preview media | forecolor backcolor emoticons | codesample help'
          ].join(' | '),

          mobile: {
            theme: 'mobile',
            menubar: true,
            plugins: 'autosave lists autolink',
            toolbar: 'undo bold italic styles'
          },

          content_css: []
        });
      }

      //Generate Product SKU
      $('#generateSku').on('click', function() {

        let prefix = 'SF';
        let random = Math.random().toString(36).substring(2, 6).toUpperCase();
        let time = Date.now().toString().slice(-4);

        let sku = prefix + random + time;

        $('#product_sku').val(sku);
      });

      //Thumbnail Preview
      $('#thumbnail').change(function() {
        let reader = new FileReader;

        reader.onload = (e) => {
          $('#thumbnail-preview').attr("src", e.target.result);
        }

        reader.readAsDataURL(this.files[0]);
      })
    });
  </script>

  <script>
    //Gallery Upload
    $(function() {
      const MAX_FILES = 5;
      const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

      const $dropArea = $('#galleryDropArea');
      const $realInput = $('#galleryInput');
      const $dummyInput = $('#dummyGalleryInput');
      const $previewContainer = $('#galleryPreview');

      let selectedFiles = [];

      // Click → dummy input open
      $dropArea.on('click', () => $dummyInput.click());

      // Drag effects
      $dropArea.on('dragover', e => {
        e.preventDefault();
        $dropArea.addClass('border-primary');
      });
      $dropArea.on('dragleave', () => $dropArea.removeClass('border-primary'));
      $dropArea.on('drop', e => {
        e.preventDefault();
        $dropArea.removeClass('border-primary');
        handleNewFiles(e.originalEvent.dataTransfer.files);
      });

      // Dummy input change
      $dummyInput.on('change', function() {
        handleNewFiles(this.files);
        this.value = ''; // allow same files again
      });

      function handleNewFiles(newFiles) {
        for (let file of newFiles) {
          // Validation
          if (!file.type.startsWith('image/')) {
            Toast.fire({
              icon: "error",
              title: `"${file.name}" is not an image!`
            });

            continue;
          }

          if (file.size > MAX_FILE_SIZE) {
            Toast.fire({
              icon: "error",
              title: `"${file.name}" is larger than 2MB!`
            });

            continue;
          }

          // Duplicate check (by name, size, lastModified)
          const isDuplicate = selectedFiles.some(f =>
            f.name === file.name && f.size === file.size && f.lastModified === file.lastModified
          );

          if (isDuplicate) {
            Toast.fire({
              icon: "error",
              title: `"${file.name}" is already added!`
            });

            continue;
          }

          if (selectedFiles.length >= MAX_FILES) {
            Toast.fire({
              icon: "error",
              title: `Maximum ${MAX_FILES} images allowed!`
            });

            return;
          }

          selectedFiles.push(file);
          previewFile(file, selectedFiles.length - 1);
        }
      }

      function previewFile(file, index) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const $div = $('<div class="gallery-item position-relative"></div>');
          const $img = $(`<img src="${e.target.result}" class="w-100 h-100 border rounded")>`);

          var $overlay = $(
            `<div class="overlay d-flex justify-content-end align-items-start"><button type="button" class = "btn btn-sm btn-danger rounded-circle p-1"> <i class="delete-icon" data-feather="trash-2"></i></button ></div>`
          );

          $overlay.find('button').on('click', () => removeFile(index));

          $div.append($img).append($overlay);
          $previewContainer.append($div);

          feather.replace();
        };
        reader.readAsDataURL(file);
      }

      function removeFile(index) {
        selectedFiles.splice(index, 1);
        refreshAllPreviews();
      }

      function refreshAllPreviews() {
        $previewContainer.empty();
        selectedFiles.forEach((file, index) => previewFile(file, index));
      }

      $('form').on('submit', function() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        $realInput[0].files = dt.files;
      });
    });
  </script>
@endpush

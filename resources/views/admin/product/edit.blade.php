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
  {{-- Edit Product --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5>Edit Product</h5>

      <a href="{{ url()->previous() }}"
        class="d-flex justify-content-center align-items-center bg-primary rounded px-2 py-1 text-white">
        <i class="link-icon" data-feather="arrow-left"></i>

        <span class="ml-1">Back</span>
      </a>
    </div>

    <div class="card-footer">
      <form action="{{ route('product.update', $product?->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <fieldset class="p-lg-4 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Product Information</span>
          </legend>
          <x-input name="name" label="Product Name" placeholder="Product Name" :value="$product?->name" />
          <x-textarea name="short_description" label="Short Description" placeholder="Short Description..."
            :value="$product->details?->short_description" />

          <x-select label="Select Tags" name="tags[]" class="tags-select-multiple" :multiple="true">
            @foreach ($tags ?? [] as $tag)
              <option value="{{ $tag?->id }}" {{ in_array($tag?->id, $productTags ?? []) ? 'selected' : '' }}>
                {{ $tag->name }}</option>
            @endforeach
          </x-select>
        </fieldset>

        <fieldset class="p-lg-4 mt-3 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Genaral Information</span>
          </legend>

          <div class="row">
            <div class="col-md-6 d-flex flex-column">
              <x-input name="product_sku" id="product_sku" label="Product SKU" placeholder="Product SKU" :value="$product?->sku_code"
                readonly />
            </div>

            <div class="col-md-6">
              <x-select name="brand" label="Select Brand">
                <option value="">Select Brand</option>
                @foreach ($brands ?? [] as $brand)
                  <option value="{{ $brand?->id }}" {{ $product->details->brand_id == $brand?->id ? 'selected' : '' }}>
                    {{ $brand->name }}</option>
                @endforeach
              </x-select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <x-select name="category" id="category" label="Select Category">
                <option value="">Select Category</option>
                @foreach ($categories ?? [] as $category)
                  <option value="{{ $category?->id }}"
                    {{ $product->details->category_id == $category?->id ? 'selected' : '' }}>{{ $category->name }}
                  </option>
                @endforeach
              </x-select>
            </div>

            <div class="col-md-6">
              <x-select name="sub_category" label="Select Sub Category">
                <option value="">Select Sub Category</option>
                @foreach ($subCategories ?? [] as $subCategory)
                  <option value="{{ $subCategory?->id }}"
                    {{ $product->details->sub_category_id == $subCategory?->id ? 'selected' : '' }}>
                    {{ $subCategory->name }}</option>
                @endforeach
              </x-select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <x-input name="buying_price" label="Buying Price" placeholder="Buying Price" :value="$product?->buying_price" />
            </div>

            <div class="col-md-6">
              <x-input name="selling_price" label="Selling Price" placeholder="Selling Price" :value="$product?->selling_price" />
            </div>
          </div>
        </fieldset>

        <fieldset class="p-lg-4 mt-3 rounded-lg border p-3">
          <legend class="w-auto">
            <span class="small bg-light rounded-lg px-3 py-2">Product Description</span>
          </legend>

          <x-textarea name="description" label="Description" placeholder="Write product description..."
            class="tinymce-editor" :value="$product?->details?->description" />

          <x-textarea name="additional_information" label="Additional Information"
            placeholder="Add product additional information..." class="tinymce-editor" :value="$product?->details?->additional_info" />
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
                <img src="{{ $product?->thumbnail }}" class="thumbnail-preview" id="thumbnail-preview" alt="thumbnail" />
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
              <!-- deleted existing images -->
              <input type="hidden" name="deleted_gallery_ids" id="deleted_gallery_ids">

              <div id="galleryPreview" class="d-flex mt-lg-4 flex-wrap gap-2">
                @foreach ($product->galleries as $gallery)
                  <div class="gallery-item position-relative" data-existing="1" data-id="{{ $gallery->id }}">
                    <img src="{{ Storage::url($gallery->src) }}" alt="{{ $gallery->media_id }}"
                      class="w-100 h-100 rounded border" style="object-fit: cover;">
                    <div class="overlay d-flex justify-content-end align-items-start">
                      <button type="button" class="btn btn-sm btn-danger rounded-circle remove-gallery p-1">
                        <i class="delete-icon" data-feather="trash-2"></i>
                      </button>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </fieldset>

        <div class="d-flex justify-content-end my-4">
          <a href="{{ route('product.edit', $product->id) }}" class="btn btn-secondary d-flex align-items-center px-2">
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

      //Thumbnail Preview
      $('#thumbnail').change(function() {
        let reader = new FileReader;

        reader.onload = (e) => {
          $('#thumbnail-preview').attr("src", e.target.result);
        }

        reader.readAsDataURL(this.files[0]);
      })

      //Select2 for tags
      'use strict'
      if ($(".tags-select-multiple").length) {
        $(".tags-select-multiple").select2();
      }
    });
  </script>

  {{-- <script>
    $(function() {

      const MAX_FILES = 5;
      const MAX_FILE_SIZE = 2 * 1024 * 1024;

      const $preview = $('#galleryPreview');
      const $realInput = $('#galleryInput');
      const $dummyInput = $('#dummyGalleryInput');
      const $dropArea = $('#galleryDropArea');
      const $deletedInput = $('#deleted_gallery_ids');

      let newFiles = [];
      let deletedExistingIds = [];

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



      $dummyInput.on('change', function() {
        addNewFiles(this.files);
        this.value = '';
      });

      function addNewFiles(files) {
        for (let file of files) {

          if (!file.type.startsWith('image/')) return;
          if (file.size > MAX_FILE_SIZE) return;
          if (newFiles.length >= MAX_FILES) return;

          newFiles.push(file);
          renderNewImage(file, newFiles.length - 1);
        }
      }

      function renderNewImage(file, index) {
        const reader = new FileReader();

        reader.onload = e => {
          const html = `
        <div class="gallery-item position-relative"
            data-new="1"
            data-index="${index}">
          <img src="${e.target.result}" class="w-100 h-100 rounded border" style="object-fit: cover;" alt="Gallery Image">
          <div class="overlay d-flex justify-content-end align-items-start">
            <button type="button"
                    class="btn btn-sm btn-danger rounded-circle p-1 remove-gallery">
              <i data-feather="trash-2"></i>
            </button>
          </div>
        </div>`;

          $preview.append(html);
          feather.replace();
        };
        reader.readAsDataURL(file);
      }

      // DELETE (event delegation) with confirmation
      $preview.on('click', '.remove-gallery', function() {
        const $item = $(this).closest('.gallery-item');

        Swal.fire({
          title: 'Are you sure?',
          text: "This image will be marked for deletion.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, remove it!',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (!result.isConfirmed) return;

          // Existing image
          if ($item.data('existing')) {
            const id = $item.data('id');
            deletedExistingIds.push(id);
            $deletedInput.val(deletedExistingIds.join(','));
            $item.remove();
            return;
          }

          // New image
          if ($item.data('new')) {
            const index = $item.data('index');
            newFiles.splice(index, 1);
            refreshNewImages();
          }
        });
      });

      function refreshNewImages() {
        $preview.find('[data-new]').remove();
        newFiles.forEach((file, i) => renderNewImage(file, i));
      }

      // FORM SUBMIT
      $('form').on('submit', function() {
        const dt = new DataTransfer();
        newFiles.forEach(f => dt.items.add(f));
        $realInput[0].files = dt.files;
      });

    });
  </script> --}}

  <script>
    $(function() {
      const MAX_FILES = 5;
      const MAX_FILE_SIZE = 2 * 1024 * 1024;

      const $dropArea = $('#galleryDropArea');
      const $realInput = $('#galleryInput');
      const $dummyInput = $('#dummyGalleryInput');
      const $preview = $('#galleryPreview');
      const $deletedInput = $('#deleted_gallery_ids');

      let newFiles = [];
      let deletedExistingIds = [];

      // Click → dummy input
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

      // Dummy input
      $dummyInput.on('change', function() {
        handleNewFiles(this.files);
        this.value = '';
      });

      function handleNewFiles(files) {
        for (let file of files) {
          if (!file.type.startsWith('image/')) continue;
          if (file.size > MAX_FILE_SIZE) continue;
          if (newFiles.length + $preview.find('[data-existing]').length >= MAX_FILES) continue;

          // duplicate check
          const isDuplicate = newFiles.some(f => f.name === file.name && f.size === file.size && f.lastModified ===
            file.lastModified);
          if (isDuplicate) continue;

          newFiles.push(file);
          renderNewImage(file, newFiles.length - 1);
        }
      }

      function renderNewImage(file, index) {
        const reader = new FileReader();
        reader.onload = e => {
          const html = $(`
        <div class="gallery-item position-relative" data-new="1" data-index="${index}">
          <img src="${e.target.result}" class="w-100 h-100 rounded border" style="object-fit: cover;" alt="Gallery Image">
          <div class="overlay d-flex justify-content-end align-items-start">
            <button type="button" class="btn btn-sm btn-danger rounded-circle p-1 remove-gallery">
              <i data-feather="trash-2"></i>
            </button>
          </div>
        </div>
      `);
          $preview.append(html);
          feather.replace();
        };
        reader.readAsDataURL(file);
      }

      // DELETE with Swal confirmation
      $preview.on('click', '.remove-gallery', function() {
        const $item = $(this).closest('.gallery-item');

        Swal.fire({
          title: 'Are you sure?',
          text: "This image will be removed.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, remove it!',
          cancelButtonText: 'Cancel'
        }).then(result => {
          if (!result.isConfirmed) return;

          // Existing image
          if ($item.data('existing')) {
            const id = $item.data('id');
            deletedExistingIds.push(id);
            $deletedInput.val(deletedExistingIds.join(','));
            $item.remove();
            return;
          }

          // New image
          if ($item.data('new')) {
            const index = $item.data('index');
            newFiles.splice(index, 1);
            refreshNewImages();
          }
        });
      });

      function refreshNewImages() {
        $preview.find('[data-new]').remove();
        newFiles.forEach((file, i) => renderNewImage(file, i));
      }

      // Form submit
      $('form').on('submit', function() {
        const dt = new DataTransfer();
        newFiles.forEach(f => dt.items.add(f));
        $realInput[0].files = dt.files;
      });
    });
  </script>
@endpush

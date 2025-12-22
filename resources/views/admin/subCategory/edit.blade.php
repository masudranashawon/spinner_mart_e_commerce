@extends('admin.layouts.app')
@section('content')
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5>Edit Sub Category</h5>

          <a href="{{ route('subCategory.index') }}"
            class="d-flex justify-content-center align-items-center bg-primary rounded px-2 py-1 text-white">
            <i class="link-icon" data-feather="arrow-left"></i>

            <span class="ml-1">Back</span>
          </a>
        </div>

        <div class="card-footer">
          <form action="{{ route('subCategory.update', $subCategory->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
              <label for="sub-category-name" class="form-label">Name</label>
              <input type="text" name="name" id="sub-category-name" class="form-control"
                placeholder="Sub Category Name" value="{{ $subCategory->name }}">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="sub-category-slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="sub-category-slug" class="form-control"
                placeholder="Sub Category Slug" value="{{ $subCategory->slug }}">
              @error('slug')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="category" class="form-label">Category</label>
              <select name="category_id" id="category" class="form-control form-select">
                <option value="" selected disabled>Select a Category</option>

                @foreach ($categories ?? [] as $category)
                  <option @selected(old('category_id', $subCategory->category_id) == $category?->id) value="{{ $category?->id }}">{{ $category?->name }}</option>
                @endforeach

              </select>
              @error('category_id')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <div class="row">
                <div class="col-xl-6">
                  <label for="sub-category-image" class="form-label">Image</label>
                  <input type="file" name="image" id="sub-category-image" class="form-control">
                </div>
                <div class="col-xl-6 mt-xl-0 mt-3">
                  <div class="w-50 h-100 d-flex align-items-center overflow-hidden">
                    <img id="preview" src="{{ $subCategory->thumbnail }}" class="object-fit-scale"
                      style="object-fit:cover; width:3.5rem; height:3.5rem;">
                  </div>
                </div>
              </div>
              @error('image')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Submit</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script>
    $(document).ready(function() {
      $('#sub-category-image').on('change', function(e) {
        let file = e.target.files[0];
        if (file) {
          $('#preview').attr('src', URL.createObjectURL(file));
        }
      });
    });
  </script>
@endpush

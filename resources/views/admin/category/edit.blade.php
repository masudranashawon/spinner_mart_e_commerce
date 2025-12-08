@extends('admin.layouts.app')
@section('content')
  <div class="row">

    <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-header">
          <h5>Edit Category</h5>
        </div>
        <div class="card-footer">
          <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
              <label for="category-name" class="form-label">Name</label>
              <input type="text" name="name" id="category-name" class="form-control" placeholder="Category Name"
                value="{{ $category->name }}">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="category-slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="category-slug" class="form-control" placeholder="Category Slug"
                value="{{ $category->slug }}">
              @error('slug')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <div class="row">
                <div class="col-xl-6">
                  <label for="category-image" class="form-label">Image</label>
                  <input type="file" name="image" id="category-image" class="form-control">
                </div>
                <div class="col-xl-6 mt-xl-0 mt-3">
                  <div class="w-50 h-100 d-flex align-items-center overflow-hidden">
                    <img id="preview" src="{{ $category->thumbnail }}" class="object-fit-scale"
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
      $('#category-image').on('change', function(e) {
        let file = e.target.files[0];
        if (file) {
          $('#preview').attr('src', URL.createObjectURL(file));
        }
      });
    });
  </script>
@endpush

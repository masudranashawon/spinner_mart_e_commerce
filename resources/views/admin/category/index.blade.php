@extends('admin.layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-7">hi</div>
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Add New Category</h5>
        </div>
        <div class="card-footer">
          <form action="" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label for="category-name" class="form-label">Name</label>
              <input type="text" name="name" id="category-name" class="form-control" placeholder="Category Name">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="category-slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="category-slug" class="form-control" placeholder="Category Slug">
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
                    <img id="preview" src="" class="object-fit-contain">
                  </div>
                </div>
              </div>
              @error('image')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
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
          $('#preview').attr('src', URL.createObjectURL(file))
            .addClass("border")
            .css({
              width: "6rem",
              height: "6rem"
            });
        }
      });
    });
  </script>
@endpush

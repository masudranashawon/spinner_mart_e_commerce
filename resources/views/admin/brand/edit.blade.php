@extends('admin.layouts.app')
@section('content')
  <div class="row">

    <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-header">
          <h5>Edit Brand</h5>
        </div>
        <div class="card-footer">
          <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
              <label for="brand-name" class="form-label">Name</label>
              <input type="text" name="name" id="brand-name" class="form-control" placeholder="Brand Name"
                value="{{ $brand->name }}">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="brand-slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="brand-slug" class="form-control" placeholder="Brand Slug"
                value="{{ $brand->slug }}">
              @error('slug')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <div class="row">
                <div class="col-xl-6">
                  <label for="brand-image" class="form-label">Image</label>
                  <input type="file" name="image" id="brand-image" class="form-control">
                </div>
                <div class="col-xl-6 mt-xl-0 mt-3">
                  <div class="w-50 h-100 d-flex align-items-center overflow-hidden">
                    <img id="preview" src="{{ $brand->thumbnail }}" class="object-fit-scale"
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
      $('#brand-image').on('change', function(e) {
        let file = e.target.files[0];
        if (file) {
          $('#preview').attr('src', URL.createObjectURL(file));
        }
      });
    });
  </script>
@endpush

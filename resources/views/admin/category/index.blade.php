@extends('admin.layouts.app')

@section('content')
  <div class="row">
    {{-- All Categories --}}
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h5>All Categories</h5>
        </div>
        <div class="card-footer">
          <table class="table-bordered table-srtiped data-table table">
            <thead>
              <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Image</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>

            <tbody>
              @forelse($categories ?? [] as $key => $category)
                <tr>
                  <td>{{ $categories?->firstItem() + $key }}</td>
                  <td>{{ $category?->name }}</td>
                  <td>{{ $category?->slug }}</td>
                  <td class="text-center"><img src="{{ $category?->thumbnail }}" alt="{{ $category?->name }}"
                      class="object-fit-cover" style="object-fit:cover;"></td>

                  <td class="text-center">
                    <a href="{{ route('category.edit', $category?->id) }}"><button
                        class="btn btn-primary btn-icon btn-md"><i data-feather="edit"></i></button></a>
                    <button class="btn btn-danger btn-icon btn-md"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="5">No Category Found</td>
                </tr>
              @endforelse
            </tbody>
          </table>

          {{ $categories->links() }}
        </div>
      </div>
    </div>

    {{-- Add new Category --}}
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Add New Category</h5>
        </div>
        <div class="card-footer">
          <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
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
                    <img id="preview" src="" class="object-fit-scale">
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
          $('#preview').attr('src', URL.createObjectURL(file))
            .addClass("border")
            .css({
              width: "6rem",
              height: "6rem",
              objectFit: "contain"
            });
        }
      });
    });
  </script>
@endpush

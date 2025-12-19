@extends('admin.layouts.app')

@section('content')
  <div class="row">
    {{-- All Sub Categories --}}
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h5>All Sub Categories</h5>
        </div>
        <div class="card-footer">
          <table class="table-bordered table-srtiped data-table table">
            <thead>
              <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Category</th>
                <th>Image</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>

            <tbody>
              @forelse($subCategories ?? [] as $key => $subCategory)
                <tr>
                  <td>{{ $subCategories?->firstItem() + $key }}</td>
                  <td>{{ $subCategory?->name }}</td>
                  <td>{{ $subCategory?->slug }}</td>
                  <td>{{ $subCategory?->category?->name }}</td>
                  <td class="text-center"><img src="{{ $subCategory?->thumbnail }}" alt="{{ $subCategory?->name }}"
                      class="object-fit-cover" style="object-fit:cover;"></td>

                  <td class="text-center">
                    {{-- <a href="{{ route('subCategory.edit', $subCategory?->id) }}"><button
                        class="btn btn-primary btn-icon btn-md"><i data-feather="edit"></i></button></a> --}}
                    <button class="btn btn-danger btn-icon btn-md"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="5">No Sub Category Found</td>
                </tr>
              @endforelse
            </tbody>
          </table>

          {{ $subCategories->links() }}
        </div>
      </div>
    </div>

    {{-- Add New Sub Category --}}
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Add New Sub Category</h5>
        </div>
        <div class="card-footer">
          <form action="{{ route('subCategory.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label for="sub-category-name" class="form-label">Name</label>
              <input type="text" name="name" id="sub-category-name" class="form-control"
                placeholder="Sub Category Name">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="sub-category-slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="sub-category-slug" class="form-control"
                placeholder="Sub Category Slug">
              @error('slug')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="category" class="form-label">Category</label>
              <select name="category_id" id="category" class="form-control form-select">
                <option value="" selected disabled>Select a Category</option>

                @foreach ($categories ?? [] as $category)
                  <option @selected(old('category_id') === $category?->id) value="{{ $category?->id }}">{{ $category?->name }}</option>
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
      $('#sub-category-image').on('change', function(e) {
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

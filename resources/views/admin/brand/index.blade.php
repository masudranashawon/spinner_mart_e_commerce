@extends('admin.layouts.app')

@section('content')
  <div class="row">
    {{-- All Brands --}}
     <div class="col-lg-7 order-2 order-lg-0 mt-4 mt-lg-0">
      <div class="card">
        <div class="card-header">
          <h5>All Brands</h5>
        </div>
        <div class="card-footer table-responsive">
          <table class="data-table table-hover table">
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
              @forelse($brands ?? [] as $key => $brand)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $brand?->name }}</td>
                  <td>{{ $brand?->slug }}</td>
                  <td class="text-center"><img src="{{ $brand?->thumbnail }}" alt="{{ $brand?->name }}"
                      class="object-fit-cover" style="object-fit:cover;"></td>

                  <td class="text-center">
                    <a href="{{ route('brand.edit', $brand?->id) }}"><button class="btn btn-primary btn-icon btn-md"><i
                          data-feather="edit"></i></button></a>

                    <a href="{{ route('brand.destroy', $brand?->id) }}"
                      class="delete-confirm btn btn-danger btn-icon btn-md">
                      <i data-feather="trash-2"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="5">No Brand Found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Add new Brand --}}
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Add New Brand</h5>
        </div>
        <div class="card-footer">
          <form action="{{ route('brand.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label for="brand-name" class="form-label">Name</label>
              <input type="text" name="name" id="brand-name" class="form-control" placeholder="Brand Name">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="brand-slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="brand-slug" class="form-control" placeholder="Brand Slug">
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
      $('#brand-image').on('change', function(e) {
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

@extends('admin.layouts.app')

@section('content')
  <div class="row">
    {{-- All Sizes --}}
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h5>All Sizes</h5>
        </div>
        <div class="card-footer">
          <table class="data-table table-hover table">
            <thead>
              <tr>
                <th>SL</th>
                <th>Size Name</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>

            <tbody>
              @forelse($sizes ?? [] as $key => $size)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $size?->name }}</td>
                  <td class="text-center">
                    <button type="button" class="editBtn btn btn-primary btn-icon btn-md" data-name="{{ $size?->name }}"
                      data-id="{{ $size?->id }}" data-toggle="modal" data-target="#sizeEditModal"><i
                        data-feather="edit"></i></button>

                    <a href="{{ route('size.destroy', $size->id) }}"
                      class="delete-confirm btn btn-danger btn-icon btn-md">
                      <i data-feather="trash-2"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="4">No Size Found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Add new Size --}}
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Add New Size</h5>
        </div>
        <div class="card-footer">
          <form action="{{ route('size.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label for="size-name" class="form-label">Size Name</label>
              <input type="text" name="name" id="size-name" class="form-control" placeholder="Size Name">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Submit</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Size Modal --}}
  <div class="modal fade" id="sizeEditModal" tabindex="-1" role="dialog" aria-labelledby="sizeEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sizeEditModalLabel">Edit Size</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editSizeForm" action="" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="edit-size-name" class="col-form-label">Size Name</label>
              <input type="text" class="form-control" id="edit-size-name" name="name">
            </div>
            <div class="d-flex justify-content-end my-4">
              <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Size</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('script')
  <script>
    $('#sizeEditModal').on('show.bs.modal', function(event) {
      let button = $(event.relatedTarget);

      // Extract info from data-* attributes
      let name = button.data('name');
      let id = button.data('id');
      let colorCode = button.data('color-code');

      // Update the modal's content.
      let url = `{{ route('size.update', ':id') }}/`.replace(':id', id);
      $('#edit-size-name').val(name);

      // Set the form action URL
      $('#editSizeForm').attr('action', url);
    });
  </script>
@endpush

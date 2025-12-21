@extends('admin.layouts.app')

@section('content')
  <div class="row">
    {{-- All Colors --}}
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h5>All Colors</h5>
        </div>
        <div class="card-footer">
          <table class="data-table table-hover table">
            <thead>
              <tr>
                <th>SL</th>
                <th>Color Name</th>
                <th>Color</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>

            <tbody>
              @forelse($colors ?? [] as $key => $color)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $color?->name }}</td>
                  <td>
                    <span class="badge border"
                      style="width: 3rem; height: 1.5rem; display: inline-block; background-color: {{ $color?->color_code }}; color:{{ $color?->color_code == 'N/A' ? '' : 'transparent' }};">
                      {{ $color?->name }}</span>
                  </td>
                  <td class="text-center">


                    <button type="button" class="editBtn btn btn-primary btn-icon btn-md" data-name="{{ $color?->name }}"
                      data-id="{{ $color?->id }}" data-color-code="{{ $color?->color_code }}" data-toggle="modal"
                      data-target="#colorEditModal"><i data-feather="edit"></i></button>

                    <a href="{{ route('color.destroy', $color->id) }}"
                      class="delete-confirm btn btn-danger btn-icon btn-md">
                      <i data-feather="trash-2"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="4">No Color Found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Add new Color --}}
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Add New Color</h5>
        </div>
        <div class="card-footer">
          <form action="{{ route('color.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label for="color-name" class="form-label">Color Name</label>
              <input type="text" name="name" id="color-name" class="form-control" placeholder="Color Name">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="color-code" class="form-label">Color Code</label>
              <input type="text" name="color_code" id="color-code" class="form-control" placeholder="Color Code">
              @error('color_code')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Submit</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Color Modal --}}
  <div class="modal fade" id="colorEditModal" tabindex="-1" role="dialog" aria-labelledby="colorEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="colorEditModalLabel">Edit Color</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editColorForm" action="" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="edit-color-name" class="col-form-label">Color Name</label>
              <input type="text" class="form-control" id="edit-color-name" name="name">
            </div>
            <div class="form-group">
              <label for="edit-color-code" class="col-form-label">Color Code:</label>
              <input type="text" class="form-control" id="edit-color-code" name="color_code">
            </div>
            <div class="d-flex justify-content-end my-4">
              <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Color</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('script')
  <script>
    $('#colorEditModal').on('show.bs.modal', function(event) {
      let button = $(event.relatedTarget);

      // Extract info from data-* attributes
      let name = button.data('name');
      let id = button.data('id');
      let colorCode = button.data('color-code');

      // Update the modal's content.
      let url = `{{ route('color.update', ':id') }}/`.replace(':id', id);

      $('#edit-color-name').val(name);
      $('#edit-color-code').val(colorCode);

      // Set the form action URL
      $('#editColorForm').attr('action', url);
    });
  </script>
@endpush

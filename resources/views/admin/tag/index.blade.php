@extends('admin.layouts.app')

@section('content')
  <div class="row">
    {{-- All Tags --}}
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h5>All Tags</h5>
        </div>
        <div class="card-footer">
          <table class="data-table table-hover table">
            <thead>
              <tr>
                <th>SL</th>
                <th>Tag Name</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>

            <tbody>
              @forelse($tags ?? [] as $key => $tag)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $tag?->name }}</td>
                  <td class="text-center">
                    <button type="button" class="editBtn btn btn-primary btn-icon btn-md" data-name="{{ $tag?->name }}"
                      data-id="{{ $tag?->id }}" data-toggle="modal" data-target="#tagEditModal"><i
                        data-feather="edit"></i></button>

                    <a href="{{ route('tag.destroy', $tag->id) }}" class="delete-confirm btn btn-danger btn-icon btn-md">
                      <i data-feather="trash-2"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="4">No Tag Found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Add new Tag --}}
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Add New Tag</h5>
        </div>
        <div class="card-footer">
          <form action="{{ route('tag.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label for="tag-name" class="form-label">Tag Name</label>
              <input type="text" name="name" id="tag-name" class="form-control" placeholder="Tag Name">
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

  {{-- Edit Tag Modal --}}
  <div class="modal fade" id="tagEditModal" tabindex="-1" role="dialog" aria-labelledby="tagEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tagEditModalLabel">Edit Tag</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editTagForm" action="" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="edit-tag-name" class="col-form-label">Tag Name</label>
              <input type="text" class="form-control" id="edit-tag-name" name="name">
            </div>
            <div class="d-flex justify-content-end my-4">
              <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Tag</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection

@push('script')
  <script>
    $('#tagEditModal').on('show.bs.modal', function(event) {
      let button = $(event.relatedTarget);

      // Extract info from data-* attributes
      let name = button.data('name');
      let id = button.data('id');

      // Update the modal's content.
      let url = `{{ route('tag.update', ':id') }}/`.replace(':id', id);

      $('#edit-tag-name').val(name);

      // Set the form action URL
      $('#editTagForm').attr('action', url);
    });
  </script>
@endpush

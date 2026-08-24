@extends('admin.layouts.app')

@php
use App\Enums\AuthEnums;
@endphp

@section('content')
{{-- All Customers --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>All Customers</h5>
    </div>

    <div class="card-footer table-responsive">
        <table class="data-table table-hover table">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Verified</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Registered Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users ?? [] as $key => $user)
                <tr>
                    <td><img src="{{ $user?->thumbnail }}" alt="{{ $user?->name }}" class="object-fit-cover" style="object-fit:cover;"></td>
                    <td>{{ $user?->name }}</td>
                    <td>{{ $user?->email }}</td>
                    <td>
                        @if ($user?->email_verified_at == null)
                        <span class="badge badge-danger">Not Verified</span>
                        @else
                        <span class="badge badge-success">Verified</span>
                        @endif
                    </td>
                    <td>
                        @php
                        // Get current role
                        $currentRole = $user->hasRole(AuthEnums::ADMIN->value) ? AuthEnums::ADMIN->value : AuthEnums::USER->value;
                        @endphp

                        @if($currentRole === AuthEnums::ADMIN->value)
                        <span class="badge badge-primary">Admin</span>
                        @else
                        <span class="badge badge-secondary">User</span>
                        @endif
                    </td>
                    <td>
                        @if ($user?->is_active == 0)
                        <span class="badge badge-danger">Inactive</span>
                        @else
                        <span class="badge badge-success">Active</span>
                        @endif
                    </td>

                    <td>{{ $user?->created_at?->format('M d, Y') }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary btn-icon edit-btn" data-toggle="modal" data-target="#editUserModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-active="{{ $user->is_active }}" data-role="{{ $currentRole }}" title="Edit User">
                            <i data-feather="edit"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="8">No Customer Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade text-left" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            {{-- Form Action will be injected via JS --}}
            <form id="editUserForm" action="#" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="modalUserName">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    {{-- Status Update --}}
                    <div class="form-group mb-3">
                        <label for="edit_is_active" class="fw-bold text-muted mb-2">Account Status</label>
                        <select name="is_active" id="edit_is_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    {{-- Role Update --}}
                    <div class="form-group mb-0">
                        <label for="edit_role" class="fw-bold text-muted mb-2">User Role</label>
                        <select name="role" id="edit_role" class="form-control text-capitalize">
                            @foreach(AuthEnums::cases() as $role)
                            <option value="{{ $role->value }}">{{ $role->value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Edit Modal --}}
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Handle Edit Button Click
        $('.edit-btn').on('click', function() {
            // Get data from clicked button attributes
            let userId = $(this).data('id');
            let userName = $(this).data('name');
            let userActive = $(this).data('active');
            let userRole = $(this).data('role');

            // Update Modal Title
            $('#modalUserName').text('Update Customer: ' + userName);

            // Populate Select Dropdowns
            $('#edit_is_active').val(userActive);
            $('#edit_role').val(userRole);

            // Build dynamic route and update Form Action
            let baseUrl = "{{ route('customer.update', ':id') }}";
            let actionUrl = baseUrl.replace(':id', userId);

            $('#editUserForm').attr('action', actionUrl);
        });
    });

</script>
@endpush

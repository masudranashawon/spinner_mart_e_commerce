@extends('admin.layouts.app')

@section('content')
<!-- profile-area start -->
<div class="row">
    <!-- Profile Update Form -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom pb-2 pt-3">
                <h4 class="card-title fw-bold mb-0">Update Profile</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Avatar --}}
                    <div class="text-center mb-4">
                        <label for="thumbnail" class="d-inline-block" style="cursor: pointer;">
                            <img src="{{ $user->thumbnail }}" id="profilePreview" class="profile-image rounded-circle border" style="width: 6rem; height: 6rem; object-fit: cover;" alt="Profile Image">
                        </label>

                        <input type="file" name="thumbnail" id="thumbnail" hidden accept="image/*">

                        <small class="d-block text-muted mt-2">
                            Click the image to change your profile photo
                        </small>

                        @error('thumbnail')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-input name="name" label="Full Name" placeholder="Full Name" :value="old('name', $user->name)" required />
                    <x-input type="email" name="email" label="Email Address" placeholder="Email Address" :value="old('email', $user->email)" required />

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Update Form -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom pb-2 pt-3">
                <h4 class="card-title fw-bold mb-0">Change Password</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <x-input type="password" name="current_password" label="Current Password" placeholder="Current Password" :value="old('current_password')" required />
                    <x-input type="password" name="password" label="New Password" placeholder="New Password" :value="old('password')" required />
                    <x-input type="password" name="password_confirmation" label="Confirm New Password" placeholder="Confirm New Password" :value="old('password_confirmation')" required />

                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('thumbnail');
        const preview = document.getElementById('profilePreview');

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (!file) return;

            preview.src = URL.createObjectURL(file);
        });
    });

</script>
@endpush

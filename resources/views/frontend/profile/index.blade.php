@extends('frontend.layouts.app')

@section('title', 'My Profile')

@section('content')

<!-- start wpo-page-title -->
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li>Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end page-title -->

<!-- profile-area start -->
<div class="profile-area section-padding">
    <div class="container">
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

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="theme-btn-s2 mt-3 border-0 py-2 px-4">Save Changes</button>
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
                            
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="theme-btn-s2 mt-3 border-0 py-2 px-4">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- profile-area end -->
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

@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Edit Slider</h5>
                <a href="{{ route('admin.sliders.index') }}" class="d-flex justify-content-center align-items-center bg-primary rounded px-2 py-1 text-white" style="text-decoration: none;">
                    <i class="link-icon" data-feather="arrow-left" style="width: 16px;"></i>
                    <span class="ml-1">Back</span>
                </a>
            </div>

            <div class="card-footer">
                <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <x-input name="title" label="Title" id="title" placeholder="Trendy & uniqe collection" value="{{ $slider->title }}" />

                    <x-input name="btn_text" label="Button Text" id="btn-text" placeholder="e.g. Shop Now" value="{{ $slider->btn_text }}" />

                    <x-input name="serial" label="Serial" id="serial" placeholder="e.g. 1, 2, 3" value="{{ $slider->serial }}" />

                    <x-input name="btn_link" label="Button Link" id="btn-link" placeholder="/products" value="{{ $slider->btn_link }}" />

                    <div class="mb-4">
                        <div class="row">
                            <div class="col-xl-6">
                                <label for="slider-image" class="form-label">Update Image (Optional)</label>
                                <input type="file" name="image" id="slider-image" class="form-control">
                                @error('image')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-xl-6 mt-xl-0 mt-3">
                                <div class="w-100 h-100 d-flex align-items-center overflow-hidden">
                                    <img id="preview" src="{{ $slider->thumbnail }}" class="object-fit-scale border rounded" style="object-fit:contain; width:100%; height:6rem;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Update Slider</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#slider-image').on('change', function(e) {
            let file = e.target.files[0];
            if (file) {
                $('#preview').attr('src', URL.createObjectURL(file));
            }
        });
    });

</script>
@endpush

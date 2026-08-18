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

                    <div class="mb-4">
                        <label for="btn-text" class="form-label">Button Text</label>
                        <input type="text" name="btn_text" id="btn-text" class="form-control" placeholder="e.g. Shop Now" value="{{ $slider->btn_text }}">
                        @error('btn_text')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="btn-link" class="form-label">Button Link</label>
                        <input type="url" name="btn_link" id="btn-link" class="form-control" placeholder="https://..." value="{{ $slider->btn_link }}">
                        @error('btn_link')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

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

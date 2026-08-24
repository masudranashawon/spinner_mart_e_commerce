@extends('admin.layouts.app')

@section('content')
<div class="row">
    {{-- All Sliders --}}
     <div class="col-lg-7 order-2 order-lg-0 mt-4 mt-lg-0">
        <div class="card">
            <div class="card-header">
                <h5>All Hero Sliders</h5>
            </div>
            <div class="card-footer">
                <div class="table-responsive">
                    <table class="data-table table-hover table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Button Info</th>
                                <th>Serial</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sliders ?? [] as $key => $slider)
                            <tr>
                                <td class="align-middle">{{ $key + 1 }}</td>
                                <td class="align-middle">
                                    <img src="{{ $slider->thumbnail }}" alt="Slider" class="object-fit-cover" style="height: 50px; width: 100px; border-radius: 4px;">
                                </td>
                                <td class="align-middle">
                                    {{ Str::limit($slider->title, 20) ?? 'N/A' }}
                                </td>
                                <td class="align-middle">
                                    <strong>{{ $slider->btn_text ?? 'N/A' }}</strong> <br>
                                    <a href="{{ $slider->btn_link }}" target="_blank" class="small text-muted">{{ Str::limit($slider->btn_link, 20) }}</a>
                                </td>
                                <td class="align-middle">
                                   {{ $slider->serial}}
                                </td>
                                <td class="align-middle">
                                    <form action="{{ route('admin.sliders.status', $slider->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="badge {{ $slider->is_active ? 'bg-success' : 'bg-danger' }} border-0 px-2 py-1 text-white">
                                            {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>

                                <td class="text-center align-middle">
                                    <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-primary btn-icon btn-sm">
                                        <i data-feather="edit" style="width: 16px; height:16px;"></i>
                                    </a>

                                     <a href="{{ route('admin.sliders.destroy', $slider?->id) }}"
                                    class="delete-confirm btn btn-danger btn-icon btn-md">
                                        <i data-feather="trash-2"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7">No Slider Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add new Slider --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add New Slider</h5>
            </div>
            <div class="card-footer">
                <form action="{{ route('admin.sliders.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <x-input name="title" label="Title" id="title" placeholder="Enter a catchy title" required/>

                    <x-input name="btn_text" label="Button Text" id="btn-text" placeholder="e.g. Shop Now" required/>

                    <x-input name="btn_link" label="Button Link" id="btn-link" placeholder="/products" required/>

                    <x-input type="number" name="serial" label="Serial" id="serial" placeholder="e.g. 1, 2, 3" value="0"/>

                    <div class="mb-4">
                        <div class="row">
                            <div class="col-xl-6">
                                <label for="slider-image" class="form-label">Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" id="slider-image" class="form-control">
                                @error('image')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-xl-6 mt-xl-0 mt-3">
                                <div class="w-100 h-100 d-flex align-items-center overflow-hidden">
                                    <img id="preview" src="" class="object-fit-scale" style="max-height: 80px;">
                                </div>
                            </div>
                        </div>
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
        $('#slider-image').on('change', function(e) {
            let file = e.target.files[0];
            if (file) {
                $('#preview').attr('src', URL.createObjectURL(file))
                    .addClass("border rounded")
                    .css({
                        width: "100%",
                        height: "6rem",
                        objectFit: "contain"
                    });
            }
        });
    });

</script>
@endpush

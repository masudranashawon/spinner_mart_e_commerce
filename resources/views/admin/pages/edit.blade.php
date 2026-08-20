@extends('admin.layouts.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Edit {{ $page->title }}</h5>

        <a href="{{route('admin.pages.index') }}" class="d-flex justify-content-center align-items-center bg-primary rounded px-2 py-1 text-white">
            <i class="link-icon" data-feather="arrow-left"></i>

            <span class="ml-1">Back</span>
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
            @csrf @method('PUT')

            <fieldset class="p-lg-4 mb-3 rounded-lg border p-3">
                <legend class="w-auto">
                    <span class="small bg-light rounded-lg px-3 py-2">Page Information</span>
                </legend>

                <div class="mb-4">
                    <x-input name="title" label="Page Title" placeholder="e.g. Privacy Policy" :value="$page->title" />
                </div>

                <div class="mb-4">
                    <x-textarea name="content" label="Page Content" placeholder="Write page content..." class="tinymce-editor" :value="$page->content" />
                </div>

                <!-- Show in Footer Checkbox -->
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input" id="show_in_footer" name="show_in_footer" value="1" {{ $page->show_in_footer ? 'checked' : '' }}>
                    <label class="custom-control-label" for="show_in_footer">Show this page link in Footer</label>
                </div>
            </fieldset>

            <button type="submit" class="btn btn-primary">Update Page</button>
        </form>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('admin/assets/vendors/tinymce/tinymce.min.js') }}"></script>

<script>
    $(document).ready(function() {
        'use strict';

        if ($(".tinymce-editor").length) {
            tinymce.init({
                selector: '.tinymce-editor',
                height: 500,
                theme: 'silver',
                branding: false,
                image_advtab: true,

                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime table media'
                ],

                toolbar: [
                    'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                    'print preview media | forecolor backcolor emoticons | codesample help'
                ].join(' | '),

                mobile: {
                    theme: 'mobile',
                    menubar: true,
                    plugins: 'autosave lists autolink',
                    toolbar: 'undo bold italic styles'
                },

                content_css: []
            });
        }
    });
</script>
@endpush
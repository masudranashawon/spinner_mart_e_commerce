@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Edit FAQ</h5>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-primary btn-sm">Back</a>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" class="form-control" value="{{ $faq->question }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea name="answer" class="form-control" rows="5" required>{{ $faq->answer }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update FAQ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

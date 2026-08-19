@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h5>All FAQs</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Question</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $key => $faq)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ Str::limit($faq->question, 40) }}</td>
                            <td>
                                <form action="{{ route('admin.faqs.status', $faq->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="badge {{ $faq->is_active ? 'bg-success' : 'bg-danger' }} border-0 text-white">
                                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-primary btn-icon btn-sm">
                                    <i data-feather="edit" style="width:16px;"></i>
                                </a>

                                <a href="{{ route('admin.faqs.destroy', $faq->id) }}"
                                class="delete-confirm btn btn-danger btn-icon btn-md">
                                <i data-feather="trash-2"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No FAQ Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add New FAQ</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.faqs.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea name="answer" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save FAQ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

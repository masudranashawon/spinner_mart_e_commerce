@extends('admin.layouts.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Dynamic Pages</h5>

        <a href="{{ route('admin.pages.create') }}" class="d-flex justify-content-center align-items-center bg-primary rounded px-2 py-1 text-white">
            <i class="link-icon" data-feather="plus-circle"></i>
            <span class="ml-1">Add a page</span>
        </a>
    </div>


    <div class="card-footer">
        <div class="table-responsive">
            <table class="data-table table-hover table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>URL Slug</th>
                        <th>Show in Footer</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages ?? [] as $key => $page)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $page->title }}</td>
                        <td><a href="{{ url('page/'.$page->slug) }}" target="_blank">/page/{{ $page->slug }}</a></td>
                        <td>{{ $page->show_in_footer ? 'Yes' : 'No' }}</td>
                        <td>
                            <form action="{{ route('admin.pages.status', $page->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="badge {{ $page->is_active ? 'bg-success' : 'bg-danger' }} border-0 text-white">
                                    {{ $page->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-primary btn-icon btn-sm">
                                <i data-feather="edit" style="width:16px;"></i>
                            </a>

                            <a href="{{ route('admin.pages.destroy', $page->id) }}" class="delete-confirm btn btn-danger btn-icon btn-md">
                                <i data-feather="trash-2"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Page Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

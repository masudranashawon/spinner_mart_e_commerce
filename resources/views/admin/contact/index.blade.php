@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Contact Messages</h5>
    </div>

    <div class="card-footer table-responsive">
        <table class="data-table table-hover table">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th>Sender Details</th>
                    <th>Subject</th>
                    <th>Message (Preview)</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $key => $message)
                <tr class="{{ !$message->is_read ? 'bg-light' : '' }}">
                    <td class="text-center align-middle">{{ $messages->firstItem() + $key }}</td>

                    <td class="align-middle">
                        <strong>{{ $message->name }}</strong><br>
                        <a href="mailto:{{ $message->email }}" class="small text-muted">{{ $message->email }}</a><br>
                        <small class="text-muted">{{ $message->created_at->format('d M, Y h:i A') }}</small>
                    </td>

                    <td class="align-middle fw-bold">{{ Str::limit($message->subject, 40) }}</td>

                    <td class="align-middle text-muted">
                        {{ Str::limit($message->message, 50) }}
                    </td>

                    <td class="text-center align-middle">
                        <form action="{{ route('admin.contact.status', $message->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="badge {{ $message->is_read ? 'badge-secondary' : 'badge-primary' }} border-0 px-3 py-2">
                                {{ $message->is_read ? 'Read' : 'Unread' }}
                            </button>
                        </form>
                    </td>

                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center gap-2">
                            <!-- View Full Message Button -->
                            <button type="button" class="view-message-btn btn btn-md btn-secondary btn-icon mr-1" data-toggle="modal" data-name="{{ $message->name }}" data-email="{{ $message->email }}" data-date="{{ $message->created_at->format('d M, Y h:i A') }}" data-subject="{{ $message->subject }}" data-message="{{ $message->message }}">
                                <i data-feather="eye"></i>
                            </button>

                            <!-- Delete Button -->
                            <a href="{{ route('admin.contact.destroy', $message->id) }}" class="delete-confirm btn btn-danger btn-icon btn-md">
                                <i data-feather="trash-2"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No messages found!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Single View Modal -->
<div class="modal fade text-left" id="viewMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Message Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <p><strong>From:</strong> <span id="modal-name"></span> (<a href="#" id="modal-email"></a>)</p>
                <p><strong>Date:</strong> <span id="modal-date"></span></p>
                <hr>
                <p><strong>Subject:</strong> <span id="modal-subject"></span></p>
                <p><strong>Message:</strong></p>
                <div class="bg-light p-3 rounded text-dark" style="white-space: pre-wrap;" id="modal-message-body"></div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('.view-message-btn').on('click', function() {
            let btn = $(this);

            // Update modal data
            $('#modal-name').text(btn.data('name'));
            $('#modal-email').text(btn.data('email')).attr('href', 'mailto:' + btn.data('email'));
            $('#modal-date').text(btn.data('date'));
            $('#modal-subject').text(btn.data('subject'));

            // Update modal message body
            $('#modal-message-body').text(btn.data('message'));

            $('#viewMessageModal').modal('show');
        });
    });

</script>
@endpush

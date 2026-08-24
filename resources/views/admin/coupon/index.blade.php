@extends('admin.layouts.app')

@section('content')
<div class="row">
    {{-- All Coupons --}}
    <div class="col-lg-8 order-2 order-lg-0 mt-4 mt-lg-0">
        <div class="card">
            <div class="card-header">
                <h5>All Coupons</h5>
            </div>
            <div class="card-footer table-responsive">
                <table class="data-table table-hover table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Minimum Amount</th>
                            <th>Limit</th>
                            <th>Start Date</th>
                            <th>Expiry Date</th>
                            <th>Total Apply</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($coupons ?? [] as $key => $coupon)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $coupon?->coupon_code }}</td>
                            <td>{{ $coupon?->coupon_type }}</td>
                            <td>{{ $coupon?->discount }}</td>
                            <td>{{ $coupon?->min_amount }}</td>
                            <td>{{ $coupon?->limit }}</td>
                            <td>{{ $coupon->start_date ? date('d-M-Y', strtotime($coupon->start_date)) : 'N/A' }}</td>
                            <td>{{ $coupon->expiry_date ? date('d-M-Y', strtotime($coupon->expiry_date)) : 'N/A' }}</td>
                            <td>{{ $coupon?->total_applied }}</td>
                            <td>
                                @if ($coupon?->status == 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <button type="button" class="editBtn btn btn-primary btn-icon btn-md" data-coupon='@json($coupon)' data-url="{{ route('coupon.update', $coupon->id) }}" data-toggle="modal" data-target="#couponModal"><i data-feather="edit"></i></button>

                                <a href="{{ route('coupon.destroy', $coupon->id) }}" class="delete-confirm btn btn-danger btn-icon btn-md">
                                    <i data-feather="trash-2"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="11">No coupon Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add new Coupon --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add New Coupon</h5>
            </div>
            <div class="card-footer">
                <form action="{{ route('coupon.store') }}" method="post">
                    @csrf

                    <x-input name="couponCode" label="Coupon Code" placeholder="Coupon Code" />

                    <x-select name="type" label="Coupon Type" placeholder="Coupon Type">
                        @foreach ($couponTypes ?? [] as $type)
                        <option value="{{$type->value}}" {{ old('type') == $type->value ? 'selected' : '' }}>
                            {{ ucfirst($type->value) }}
                        </option>
                        @endforeach
                    </x-select>

                    <x-input type="number" name="minimumAmount" label="Minimum Amount" placeholder="Minimum Amount" />

                    <x-input type="number" name="discount" label="Discount" placeholder="Discount" />

                    <x-input type="number" name="limit" label="Limit" placeholder="Limit" />

                    <x-input type="date" name="startDate" label="Start Date" placeholder="Start Date" />

                    <x-input type="date" name="expiryDate" label="Expiry Date" placeholder="Expiry Date" />

                    <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Submit</button></div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Coupon Modal --}}
<div class="modal fade" id="couponModal" tabindex="-1" role="dialog" aria-labelledby="couponEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="couponEditModalLabel">Edit coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCouponForm" action="{{ old('coupon_id') ? route('coupon.update', old('coupon_id')) : '' }}" method="post">
                    @csrf
                    @method('PUT')

                    <x-input type="hidden" id="editCouponId" name="coupon_id" value="{{ old('coupon_id') }}" />

                    <x-input name="editCouponCode" id="editCouponCode" label="Coupon Code" placeholder="Coupon Code" value="{{ old('editCouponCode') }}" readonly />

                    <x-select name="editCouponType" id="editCouponType" label="Coupon Type">
                        @foreach ($couponTypes ?? [] as $type)
                        <option value="{{ $type->value }}" {{ old('editCouponType') == $type->value ? 'selected' : '' }}>
                            {{ ucfirst($type->value) }}
                        </option>
                        @endforeach
                    </x-select>

                    <x-select name="editStatus" id="editStatus" label="Status">
                        <option value="1" {{ old('editStatus') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('editStatus') == '0' ? 'selected' : '' }}>Inactive</option>
                    </x-select>

                    <x-input type="number" name="editMinimumAmount" id="editMinimumAmount" label="Minimum Amount" placeholder="Minimum Amount" value="{{ old('editMinimumAmount') }}" />

                    <x-input type="number" name="editDiscount" id="editDiscount" label="Discount" placeholder="Discount" value="{{ old('editDiscount') }}" />

                    <x-input type="number" name="editLimit" id="editLimit" label="Limit" placeholder="Limit" value="{{ old('editLimit') }}" />

                    <x-input type="date" name="editStartDate" id="editStartDate" label="Start Date" placeholder="Start Date" value="{{ old('editStartDate') }}" />

                    <x-input type="date" name="editExpiryDate" id="editExpiryDate" label="Expiry Date" placeholder="Expiry Date" value="{{ old('editExpiryDate') }}" />

                    <div class="d-flex justify-content-end my-4">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

<script>
    $('#couponModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        if (!button || !button.length) return;

        let coupon = JSON.parse(button.attr('data-coupon'));
        let url = button.data('url');

        // FORCE action every time
        $('#editCouponForm').attr('action', url);

        // Set the values of the form fields based on the coupon data
        $('#editCouponId').val(coupon.id);

        $('#editCouponCode').val(coupon.coupon_code);
        $('#editCouponType').val(coupon.coupon_type);
        $('#editStatus').val(coupon.status);
        $('#editMinimumAmount').val(coupon.min_amount);
        $('#editDiscount').val(coupon.discount);
        $('#editLimit').val(coupon.limit);

        // Set the date values, ensuring they are in the correct format for the input fields
        $('#editStartDate').val(coupon.start_date ? coupon.start_date.split(' ')[0] : '');
        $('#editExpiryDate').val(coupon.expiry_date ? coupon.expiry_date.split(' ')[0] : '');
    });


    // Show the modal if there are validation errors and a coupon ID is present in the old input
    $(document).ready(function() {
        // prettier-ignore
        @if($errors->any() && old('coupon_id'))
        $('#couponModal').modal('show');
        // prettier-ignore
        @endif
    });
</script>

@endpush

@extends('admin.layouts.app')

@section('title', 'Site Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Settings Tabs -->
        <div class="col-md-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link fw-bold active rounded-0" id="v-pills-branding-tab" data-toggle="pill" href="#v-pills-branding" role="tab">Branding</a>
                        <a class="nav-link fw-bold rounded-0" id="v-pills-contact-tab" data-toggle="pill" href="#v-pills-contact" role="tab">Contact Info</a>
                        <a class="nav-link fw-bold rounded-0" id="v-pills-order-tab" data-toggle="pill" href="#v-pills-order" role="tab">Order & Delivery</a>
                        <a class="nav-link fw-bold rounded-0" id="v-pills-currency-tab" data-toggle="pill" href="#v-pills-currency" role="tab">Currency</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="tab-content" id="v-pills-tabContent">

                            <!-- Branding Tab -->
                            <div class="tab-pane fade show active" id="v-pills-branding" role="tabpanel">
                                <h4>Branding Settings</h4>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Store Name</label>
                                    <input type="text" name="store_name" class="form-control" value="{{ get_setting('store_name') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Store Tagline</label>
                                    <input type="text" name="store_tagline" class="form-control" value="{{ get_setting('store_tagline') }}">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Site Logo</label>
                                        <input type="file" name="site_logo" class="form-control">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        @if(get_setting('site_logo'))
                                        <img src="{{ get_setting('site_logo') }}" alt="Logo" height="45">
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Footer Logo</label>
                                        <input type="file" name="footer_logo" class="form-control">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        @if(get_setting('footer_logo'))
                                        <img src="{{ get_setting('footer_logo') }}" alt="Footer Logo" height="45">
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Favicon</label>
                                        <input type="file" name="site_favicon" class="form-control">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        @if(get_setting('site_favicon'))
                                        <img src="{{ get_setting('site_favicon') }}" alt="Favicon" height="40">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Tab -->
                            <div class="tab-pane fade" id="v-pills-contact" role="tabpanel">
                                <h4>Contact Settings</h4>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ get_setting('phone') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Secondary Phone Number</label>
                                    <input type="text" name="phone_secondary" class="form-control" value="{{ get_setting('phone_secondary') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ get_setting('email') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Store Address</label>
                                    <textarea name="address" class="form-control" rows="3">{{ get_setting('address') }}</textarea>
                                </div>
                            </div>

                            <!-- Order & Delivery Tab -->
                            <div class="tab-pane fade" id="v-pills-order" role="tabpanel">
                                <h4>Order & Delivery Settings</h4>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Invoice Prefix</label>
                                    <input type="text" name="invoice_prefix" class="form-control" value="{{ get_setting('invoice_prefix') }}" placeholder="e.g. ORD-">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tax Percentage (%)</label>
                                    <input type="number" step="0.01" name="tax_percentage" class="form-control" value="{{ get_setting('tax_percentage') }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Shipping Inside Dhaka</label>
                                        <input type="number" name="shipping_inside_dhaka" class="form-control" value="{{ get_setting('shipping_inside_dhaka') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Shipping Outside Dhaka</label>
                                        <input type="number" name="shipping_outside_dhaka" class="form-control" value="{{ get_setting('shipping_outside_dhaka') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Currency Tab -->
                            <div class="tab-pane fade" id="v-pills-currency" role="tabpanel">
                                <h4>Currency Settings</h4>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Currency Code</label>
                                    <input type="text" name="currency_code" class="form-control" value="{{ get_setting('currency_code') }}" placeholder="BDT">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Currency Symbol</label>
                                    <input type="text" name="currency_symbol" class="form-control" value="{{ get_setting('currency_symbol') }}" placeholder="৳">
                                </div>
                            </div>

                        </div> <!-- End Tab Content -->

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save Settings</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for the nav pills to match standard admin panel look */
    .nav-pills .nav-link {
        color: #495057;
        font-weight: 500;
        padding: 12px 20px;
        border-left: 3px solid transparent;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: #727cf5;
        background-color: #f8f9fa;
        border-left: 3px solid #727cf5;
    }

</style>
@endsection

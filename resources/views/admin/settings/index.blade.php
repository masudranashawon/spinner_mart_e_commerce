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
                        <a class="nav-link fw-bold rounded-0" id="v-pills-announcement-tab" data-toggle="pill" href="#v-pills-announcement" role="tab">Announcement</a>
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
                                    <input type="hidden" name="group[store_name]" value="branding">
                                    <input type="text" name="store_name" class="form-control" value="{{ get_setting('store_name') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Store Tagline</label>
                                    <input type="hidden" name="group[store_tagline]" value="branding">
                                    <input type="text" name="store_tagline" class="form-control" value="{{ get_setting('store_tagline') }}">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Site Logo</label>
                                        <input type="hidden" name="group[site_logo]" value="branding">
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
                                        <input type="hidden" name="group[footer_logo]" value="branding">
                                        <input type="file" name="footer_logo" class="form-control">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        @if(get_setting('footer_logo'))
                                        <img src="{{ get_setting('footer_logo') }}" alt="Footer Logo" height="45">
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Favicon</label>
                                        <input type="hidden" name="group[site_favicon]" value="branding">
                                        <input type="file" name="site_favicon" class="form-control">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        @if(get_setting('site_favicon'))
                                        <img src="{{ get_setting('site_favicon') }}" alt="Favicon" height="40">
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Footer About Text</label>
                                    <input type="hidden" name="group[footer_about_text]" value="branding">
                                    <textarea name="footer_about_text" class="form-control" rows="3">{{ get_setting('footer_about_text') }}</textarea>
                                </div>
                            </div>

                            <!-- Contact Tab -->
                            <div class="tab-pane fade" id="v-pills-contact" role="tabpanel">
                                <h4>Contact Settings</h4>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="hidden" name="group[phone]" value="contact">
                                    <input type="text" name="phone" class="form-control" value="{{ get_setting('phone') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Secondary Phone Number</label>
                                    <input type="hidden" name="group[phone_secondary]" value="contact">
                                    <input type="text" name="phone_secondary" class="form-control" value="{{ get_setting('phone_secondary') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="hidden" name="group[email]" value="contact">
                                    <input type="email" name="email" class="form-control" value="{{ get_setting('email') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Store Address</label>
                                    <input type="hidden" name="group[address]" value="contact">
                                    <textarea name="address" class="form-control" rows="3">{{ get_setting('address') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Google Map Embed Code</label>
                                    <input type="hidden" name="group[address_map]" value="contact">
                                    <textarea name="address_map" class="form-control" rows="3">{{ get_setting('address_map') }}</textarea>
                                    <div class="form-text text-muted">Paste the full &lt;iframe&gt; embed code from Google Maps</div>
                                </div>

                            </div>

                            <!-- Order & Delivery Tab -->
                            <div class="tab-pane fade" id="v-pills-order" role="tabpanel">
                                <h4>Order & Delivery Settings</h4>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Invoice Prefix</label>
                                    <input type="hidden" name="group[invoice_prefix]" value="order">
                                    <input type="text" name="invoice_prefix" class="form-control" value="{{ get_setting('invoice_prefix') }}" placeholder="e.g. ORD-">
                                </div>
                                <div
                                    class="row"
                                >
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Vat Percentage (%)</label>
                                        <input type="hidden" name="group[vat_percentage]" value="order">
                                        <input type="number" step="0.01" name="vat_percentage" class="form-control" value="{{ get_setting('vat_percentage') }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Return Policy Days</label>
                                        <input type="hidden" name="group[return_policy_days]" value="order">
                                        <input type="number" name="return_policy_days" class="form-control" value="{{ get_setting('return_policy_days') }}">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Shipping Inside Dhaka</label>
                                        <input type="hidden" name="group[shipping_inside_dhaka]" value="order">
                                        <input type="number" name="shipping_inside_dhaka" class="form-control" value="{{ get_setting('shipping_inside_dhaka') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Shipping Outside Dhaka</label>
                                        <input type="hidden" name="group[shipping_outside_dhaka]" value="order">
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
                                    <input type="hidden" name="group[currency_code]" value="currency">
                                    <input type="text" name="currency_code" class="form-control" value="{{ get_setting('currency_code') }}" placeholder="BDT">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Currency Symbol</label>
                                    <input type="hidden" name="group[currency_symbol]" value="currency">
                                    <input type="text" name="currency_symbol" class="form-control" value="{{ get_setting('currency_symbol') }}" placeholder="৳">
                                </div>
                            </div>

                            <!-- Announcement Tab -->
                            <div class="tab-pane fade" id="v-pills-announcement" role="tabpanel">
                                <h4>Announcement Settings</h4>
                                <hr>
                                <div class="custom-control custom-switch mb-3">
                                    <input type="hidden" name="group[enable_announcement_bar]" value="announcement">
                                    <!-- Hidden input for default value 0 -->
                                    <input type="hidden" name="enable_announcement_bar" value="0">
                                    <!-- Checkbox for value 1 -->
                                    <input type="checkbox" class="custom-control-input" id="enable_announcement_bar" name="enable_announcement_bar" value="1" {{ get_setting('enable_announcement_bar') == '1' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="enable_announcement_bar">Announcement Bar</label>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Announcement Text</label>
                                    <input type="hidden" name="group[announcement_text]" value="announcement">
                                    <input type="text" name="announcement_text" class="form-control" value="{{ get_setting('announcement_text') }}" placeholder="Exclusive Deals Available for a Limited Time.">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Announcement Link</label>
                                    <input type="hidden" name="group[announcement_link]" value="announcement">
                                    <input type="text" name="announcement_link" class="form-control" value="{{ get_setting('announcement_link') }}" placeholder="https://example.com/offers">
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

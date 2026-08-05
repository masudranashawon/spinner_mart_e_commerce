<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <meta name="description" content="{{ get_setting('store_tagline') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ get_setting('site_favicon') }}">
    <title>
        @hasSection('title')
        @yield('title') | {{ get_setting('store_name', config('app.name')) }}
        @else
        {{ get_setting('store_name', config('app.name')) }}
        @endif
    </title>
    <link href="{{ asset('frontend/assets/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/flaticon_ecommerce.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/owl.transitions.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/odometer-theme-default.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendors/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/sass/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img src="{{ asset('frontend/assets/images/preloader.png') }}" alt="">
                </div>
            </div>
        </div>
        <!-- end preloader -->

        @include('frontend.layouts.partials.header')

        @yield('content')

        @include('frontend.layouts.partials.footer')

        <!-- start wpo-newsletter-popup-area-section -->
        <section class="wpo-newsletter-popup-area-section">
            <div class="wpo-newsletter-popup-area">
                <div class="wpo-newsletter-popup-ineer">
                    <button class="btn newsletter-close-btn"><i class="ti-close"></i></button>
                    <div class="img-holder">
                        <img src="{{ asset('frontend/assets/images/newsletter.jpg') }}" alt>
                    </div>
                    <div class="details">
                        <h4>Get 30% discount shipped to your inbox</h4>
                        <p>Subscribe to the Themart eCommerce newsletter to receive timely updates to your favorite products</p>
                        <form>
                            <div>
                                <input type="email" placeholder="Enter your email">
                                <button type="submit">Subscribe</button>
                            </div>
                            <div>
                                <label class="checkbox-holder"> Don't show this popup again!
                                    <input type="checkbox" class="show-message">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- end wpo-newsletter-popup-area-section -->

        <!-- Instant Quick View Modal -->
        <div id="popup-quickview" class="modal fade" tabindex="-1">
            <div class="modal-dialog quickview-dialog">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>

                    <div class="modal-body d-flex">
                        <div class="product-details">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="product-single-img">
                                        <div class="modal-product">
                                            <div class="item">
                                                <img id="qv-img" src="" alt="" class="img-fluid rounded w-100" style="object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 mt-4 mt-lg-0">
                                    <div class="product-single-content">
                                        <form action="{{ route('cart.store') }}" method="POST" class="d-block">
                                            @csrf

                                            {{-- Product ID & Variant ID --}}
                                            <input type="hidden" name="product_id" id="qv-product-id">
                                            <input type="hidden" name="variant_id" id="qv-variant-id">

                                            <h3 id="qv-title" class="mb-2 text-start me-3 me-xl-5"></h3>

                                            <div class="price mb-3">
                                                <span id="qv-price" class="present-price"></span>
                                                <del id="qv-old-price" class="old-price"></del>
                                            </div>

                                            <ul class="mb-3 important-text">
                                                <li>Stock: <span id="qv-stock-status" class="fw-bold"></span></li>
                                            </ul>

                                            <p id="qv-desc"></p>

                                            <div id="qv-color-container" class="product-filter-item color d-none">
                                                <div class="color-name">
                                                    <span>Color:</span>
                                                    <ul id="qv-colors"></ul>
                                                </div>
                                            </div>

                                            <div id="qv-size-container" class="product-filter-item color filter-size d-none">
                                                <div class="color-name">
                                                    <span>Size:</span>
                                                    <ul id="qv-sizes"></ul>
                                                </div>
                                            </div>

                                            <div class="pro-single-btn">
                                                <div class="quantity cart-plus-minus">
                                                    <input type="text" name="quantity" id="qv-qty" class="text-value" value="1" min="1" readonly>
                                                    <div class="dec qtybutton">-</div>
                                                    <div class="inc qtybutton">+</div>
                                                </div>

                                                <button type="submit" id="qv-add-to-cart" class="btn theme-btn-s2">Add to cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Disable quick view button when out of stock */
            #qv-add-to-cart:disabled {
                opacity: 0.5 !important;
                cursor: not-allowed !important;
                pointer-events: none;
            }

            .out-of-stock label {
                opacity: 0.4 !important;
                cursor: not-allowed !important;
            }

        </style>

    </div>
    <!-- end of page-wrapper -->

    <!-- All JavaScript files
    ================================================== -->
    <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Plugins for this template -->
    <script src="{{ asset('frontend/assets/js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.dlmenu.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-plugin-collection.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Custom script for this template -->
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true
            , position: "top-end"
            , showConfirmButton: false
            , timer: 3000
            , timerProgressBar: true
            , didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @if(session('success'))
        Toast.fire({
            icon: "success"
            , title: "{{ session('success') }}"
        });
        @endif

        @if(session('error'))
        Toast.fire({
            icon: "error"
            , title: "{{ session('error') }}"
        });
        @endif

        @if(session('warning'))
        Toast.fire({
            icon: "warning"
            , title: "{{ session('warning') }}"
        });
        @endif

    </script>

    <script>
        $(document).ready(function() {
            let currentVariants = [];
            let qvState = {
                color: null
                , size: null
            };

            // Quick View Button Click
            $(document).on('click', '.quickview-btn', function(e) {
                e.preventDefault();

                let product = $(this).data('product');
                currentVariants = product.variants;

                $('#qv-product-id').val(product.id);
                $('#qv-title').text(product.name);
                $('#qv-img').attr('src', product.image);
                $('#qv-desc').text(product.short_desc);
                $('#qv-qty').val(1);
                $('#qv-variant-id').val('');

                // Color HTML
                let colors = [...new Map(currentVariants.filter(v => v.color_id).map(v => [v.color_id, v])).values()];
                if (colors.length > 0) {
                    $('#qv-color-container').removeClass('d-none');
                    let colorHtml = colors.map((c, index) => `
                    <li class="qv-color-wrapper">
                        <input type="radio" name="color" id="qv-c-${c.color_id}" value="${c.color_id}" class="qv-color-select" ${index === 0 ? 'checked' : ''} style="display:none;">
                        <label for="qv-c-${c.color_id}" style="background-color: ${c.color_code}" title="${c.color_name}"></label>
                    </li>
                `).join('');
                    $('#qv-colors').html(colorHtml);
                    qvState.color = colors[0].color_id;
                } else {
                    $('#qv-color-container').addClass('d-none');
                    qvState.color = null;
                }

                // Size HTML
                let sizes = [...new Map(currentVariants.filter(v => v.size_id).map(v => [v.size_id, v])).values()];
                if (sizes.length > 0) {
                    $('#qv-size-container').removeClass('d-none');
                    let sizeHtml = sizes.map((s, index) => `
                    <li class="qv-size-wrapper">
                        <input type="radio" name="size" id="qv-s-${s.size_id}" value="${s.size_id}" class="qv-size-select" ${index === 0 ? 'checked' : ''} style="display:none;">
                        <label for="qv-s-${s.size_id}">${s.size_name}</label>
                    </li>
                `).join('');
                    $('#qv-sizes').html(sizeHtml);
                    qvState.size = sizes[0].size_id;
                } else {
                    $('#qv-size-container').addClass('d-none');
                    qvState.size = null;
                }

                updateSizeAvailability();
                updateQvPriceAndVariant();
                $('#popup-quickview').modal('show');
            });

            // Variant Change Event
            $(document).on('change', '.qv-color-select', function() {
                qvState.color = $(this).val();
                updateSizeAvailability();
                updateQvPriceAndVariant();
            });

            // Variant Change Event
            $(document).on('change', '.qv-size-select', function() {
                qvState.size = $(this).val();
                updateQvPriceAndVariant();
            });

            // Out of stock logic
            function updateSizeAvailability() {
                if (!qvState.color) return;

                // Check if variant exists with this color+size combination
                $('.qv-size-wrapper').each(function() {
                    let sizeInput = $(this).find('.qv-size-select');
                    let sizeId = sizeInput.val();

                    // Check if variant exists with this color+size combination
                    let variantExists = currentVariants.some(v =>
                        v.color_id == qvState.color &&
                        v.size_id == sizeId &&
                        v.stock > 0
                    );

                    // If variant exists, enable size input and remove out of stock class
                    if (variantExists) {
                        sizeInput.prop('disabled', false);
                        $(this).removeClass('out-of-stock');
                    } else {
                        sizeInput.prop('disabled', true);
                        $(this).addClass('out-of-stock');

                        if (qvState.size == sizeId) {
                            sizeInput.prop('checked', false);
                            qvState.size = null;
                        }
                    }
                });

                // If no size is selected, select the first available size
                if (!qvState.size) {
                    let firstAvailable = $('.qv-size-select:not(:disabled)').first();
                    if (firstAvailable.length > 0) {
                        firstAvailable.prop('checked', true);
                        qvState.size = firstAvailable.val();
                    }
                }
            }

            // Price and Stock Update Logic
            function updateQvPriceAndVariant() {
                if (currentVariants.length === 0) return;

                let matchedVariant = currentVariants.find(v =>
                    (!qvState.color || v.color_id == qvState.color) &&
                    (!qvState.size || v.size_id == qvState.size)
                );

                if (!matchedVariant) {
                    $('#qv-add-to-cart').text('Unavailable').prop('disabled', true);
                    $('#qv-stock-status').text('Out of Stock').removeClass('text-success').addClass('text-danger');
                    return;
                }

                $('#qv-variant-id').val(matchedVariant.id);
                $('#qv-price').text('৳' + matchedVariant.price);

                if (matchedVariant.old_price) {
                    $('#qv-old-price').text('৳' + matchedVariant.old_price).show();
                } else {
                    $('#qv-old-price').hide();
                }

                // ====== STOCK & BUTTON LOGIC ======
                if (matchedVariant.stock > 0) {
                    // is stock, enable add to cart button
                    $('#qv-add-to-cart').text('Add To Cart').prop('disabled', false);
                    $('#qv-stock-status').text(matchedVariant.stock + ' in stock').removeClass('text-danger').addClass('text-success');
                } else {
                    // If out of stock, disable add to cart button
                    $('#qv-add-to-cart').text('Out Of Stock').prop('disabled', true);
                    $('#qv-stock-status').text('Out of Stock').removeClass('text-success').addClass('text-danger');
                }
            }

            function checkQvQuantity() {
                let input = $('#qv-qty');
                let val = parseInt(input.val());

                // if quantity is less than 1 or is not a number, set quantity to 1
                if (val <= 1 || isNaN(val)) {
                    input.val(1);

                    $('#popup-quickview .dec.qtybutton').css({
                        'opacity': '0.4'
                        , 'cursor': 'not-allowed'
                        , 'pointer-events': 'none'
                    });
                } else {

                    $('#popup-quickview .dec.qtybutton').css({
                        'opacity': '1'
                        , 'cursor': 'pointer'
                        , 'pointer-events': 'auto'
                    });
                }
            }

            // when modal is shown, check quantity
            $('#popup-quickview').on('shown.bs.modal', function() {
                checkQvQuantity();
            });

            // when quantity button is clicked, check quantity
            $(document).on('click', '#popup-quickview .qtybutton', function() {
                setTimeout(function() {
                    checkQvQuantity();
                }, 50);
            });

            // when quantity input is changed, check quantity
            $(document).on('input change', '#qv-qty', function() {
                checkQvQuantity();
            });
        });

    </script>



    @stack('script')
</body>

</html>

{{-- <nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{route('admin.root')}}" class="sidebar-brand">
Noble<span>UI</span>
</a>
<div class="sidebar-toggler not-active">
    <span></span>
    <span></span>
    <span></span>
</div>
</div>
<div class="sidebar-body">
    <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
            <a href="{{route('admin.root')}}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">web apps</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                <i class="link-icon" data-feather="mail"></i>
                <span class="link-title">Email</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="emails">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/email/inbox.html" class="nav-link">Inbox</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/email/read.html" class="nav-link">Read</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/email/compose.html" class="nav-link">Compose</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a href="pages/apps/chat.html" class="nav-link">
                <i class="link-icon" data-feather="message-square"></i>
                <span class="link-title">Chat</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="pages/apps/calendar.html" class="nav-link">
                <i class="link-icon" data-feather="calendar"></i>
                <span class="link-title">Calendar</span>
            </a>
        </li>
        <li class="nav-item nav-category">Components</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#categories" role="button" aria-expanded="false" aria-controls="categories">
                <i class="link-icon" data-feather="feather"></i>
                <span class="link-title">Categories</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="categories">
                <ul class="nav sub-menu">
                    <li class="nav-item {{ request()->routeIs('category.*') ? 'active' : '' }}">
                        <a href="{{ route('category.index') }}" class="nav-link">Category</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('subCategory.*') ? 'active' : '' }}">
                        <a href="{{ route('subCategory.index') }}" class="nav-link">Sub Category</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('brand.*') ? 'active' : '' }}">
                        <a href="{{ route('brand.index') }}" class="nav-link">Brand</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('color.*') ? 'active' : '' }}">
                        <a href="{{ route('color.index') }}" class="nav-link">Color</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('size.*') ? 'active' : '' }}">
                        <a href="{{ route('size.index') }}" class="nav-link">Size</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('tag.*') ? 'active' : '' }}">
                        <a href="{{ route('tag.index') }}" class="nav-link">Tag</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('coupon.*') ? 'active' : '' }}">
                        <a href="{{ route('coupon.index') }}" class="nav-link">Coupon</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#products" role="button" aria-expanded="false" aria-controls="products">
                <i class="link-icon" data-feather="feather"></i>
                <span class="link-title">Products</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="products">
                <ul class="nav sub-menu">
                    <li class="nav-item {{ request()->routeIs('product.*') ? 'active' : '' }}">
                        <a href="{{ route('product.index') }}" class="nav-link">All Products</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('product.*') ? 'active' : '' }}">
                        <a href="{{ route('product.create') }}" class="nav-link">Add Product</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item nav-category">Orders</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#orders" role="button" aria-expanded="false" aria-controls="orders">
                <i class="link-icon" data-feather="list"></i>
                <span class="link-title">Orders</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="orders">
                <ul class="nav sub-menu">
                    <li class="nav-item {{ request()->routeIs('admin.order.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.index') }}" class="nav-link">All orders</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item nav-category">Users</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#customers" role="button" aria-expanded="false" aria-controls="customers">
                <i class="link-icon" data-feather="users"></i>
                <span class="link-title">Customers</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="customers">
                <ul class="nav sub-menu">
                    <li class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <a href="{{ route('customer.index') }}" class="nav-link">All customers</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                <i class="link-icon" data-feather="anchor"></i>
                <span class="link-title">Advanced UI</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="advancedUI">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/advanced-ui/sweet-alert.html" class="nav-link">Sweet Alert</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#forms" role="button" aria-expanded="false" aria-controls="forms">
                <i class="link-icon" data-feather="inbox"></i>
                <span class="link-title">Forms</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="forms">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/forms/basic-elements.html" class="nav-link">Basic Elements</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/forms/advanced-elements.html" class="nav-link">Advanced Elements</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Editors</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/forms/wizard.html" class="nav-link">Wizard</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" role="button" aria-expanded="false" aria-controls="charts">
                <i class="link-icon" data-feather="pie-chart"></i>
                <span class="link-title">Charts</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/charts/apex.html" class="nav-link">Apex</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">ChartJs</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/charts/flot.html" class="nav-link">Flot</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/charts/morrisjs.html" class="nav-link">Morris</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/charts/peity.html" class="nav-link">Peity</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/charts/sparkline.html" class="nav-link">Sparkline</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" role="button" aria-expanded="false" aria-controls="tables">
                <i class="link-icon" data-feather="layout"></i>
                <span class="link-title">Table</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/tables/basic-table.html" class="nav-link">Basic Tables</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/tables/data-table.html" class="nav-link">Data Table</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" role="button" aria-expanded="false" aria-controls="icons">
                <i class="link-icon" data-feather="smile"></i>
                <span class="link-title">Icons</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/icons/feather-icons.html" class="nav-link">Feather Icons</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/icons/flag-icons.html" class="nav-link">Flag Icons</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/icons/mdi-icons.html" class="nav-link">Mdi Icons</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Pages</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#general-pages" role="button" aria-expanded="false" aria-controls="general-pages">
                <i class="link-icon" data-feather="book"></i>
                <span class="link-title">Special pages</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="general-pages">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/general/blank-page.html" class="nav-link">Blank page</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/general/faq.html" class="nav-link">Faq</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/general/invoice.html" class="nav-link">Invoice</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/general/profile.html" class="nav-link">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/general/pricing.html" class="nav-link">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/general/timeline.html" class="nav-link">Timeline</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#authPages" role="button" aria-expanded="false" aria-controls="authPages">
                <i class="link-icon" data-feather="unlock"></i>
                <span class="link-title">Authentication</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="authPages">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/auth/login.html" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/auth/register.html" class="nav-link">Register</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#errorPages" role="button" aria-expanded="false" aria-controls="errorPages">
                <i class="link-icon" data-feather="cloud-off"></i>
                <span class="link-title">Error</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="errorPages">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="pages/error/404.html" class="nav-link">404</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/error/500.html" class="nav-link">500</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Docs</li>
        <li class="nav-item">
            <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
                <i class="link-icon" data-feather="hash"></i>
                <span class="link-title">Documentation</span>
            </a>
        </li>
    </ul>
</div>
</nav> --}}


<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.root') }}" class="sidebar-brand">
            <img src="{{get_setting('site_logo')}}" alt="{{get_setting('store_name')}}" height="40">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">

            {{-- ========================================== --}}
            {{-- MAIN DASHBOARD --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ request()->routeIs('admin.root') ? 'active' : '' }}">
                <a href="{{ route('admin.root') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            {{-- ========================================== --}}
            {{-- CATALOG MANAGEMENT --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">Catalog</li>

            <!-- Products -->
            @php $isProductActive = request()->routeIs('product.*'); @endphp
            <li class="nav-item {{ $isProductActive ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#products" role="button" aria-expanded="{{ $isProductActive ? 'true' : 'false' }}" aria-controls="products">
                    <i class="link-icon" data-feather="shopping-bag"></i>
                    <span class="link-title">Products</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isProductActive ? 'show' : '' }}" id="products">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('product.index') }}" class="nav-link {{ request()->routeIs('product.index', 'product.show', 'product.edit') ? 'active' : '' }}">All Products</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product.create') }}" class="nav-link {{ request()->routeIs('product.create') ? 'active' : '' }}">Add Product</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Categories -->
            @php $isCategoryActive = request()->routeIs('category.*', 'subCategory.*'); @endphp
            <li class="nav-item {{ $isCategoryActive ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#categories" role="button" aria-expanded="{{ $isCategoryActive ? 'true' : 'false' }}" aria-controls="categories">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Categories</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isCategoryActive ? 'show' : '' }}" id="categories">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('subCategory.index') }}" class="nav-link {{ request()->routeIs('subCategory.*') ? 'active' : '' }}">Sub Category</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Attributes & Tags -->
            @php $isAttributeActive = request()->routeIs('brand.*', 'color.*', 'size.*', 'tag.*'); @endphp
            <li class="nav-item {{ $isAttributeActive ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#attributes" role="button" aria-expanded="{{ $isAttributeActive ? 'true' : 'false' }}" aria-controls="attributes">
                    <i class="link-icon" data-feather="sliders"></i>
                    <span class="link-title">Attributes</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isAttributeActive ? 'show' : '' }}" id="attributes">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('brand.index') }}" class="nav-link {{ request()->routeIs('brand.*') ? 'active' : '' }}">Brands</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('color.index') }}" class="nav-link {{ request()->routeIs('color.*') ? 'active' : '' }}">Colors</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('size.index') }}" class="nav-link {{ request()->routeIs('size.*') ? 'active' : '' }}">Sizes</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tag.index') }}" class="nav-link {{ request()->routeIs('tag.*') ? 'active' : '' }}">Tags</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ========================================== --}}
            {{-- SALES & PROMOTIONS --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">Sales & Promotions</li>

            <!-- Orders -->
            @php $isOrderActive = request()->routeIs('admin.order.*'); @endphp
            <li class="nav-item {{ $isOrderActive ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#orders" role="button" aria-expanded="{{ $isOrderActive ? 'true' : 'false' }}" aria-controls="orders">
                    <i class="link-icon" data-feather="shopping-cart"></i>
                    <span class="link-title">Orders</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isOrderActive ? 'show' : '' }}" id="orders">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.order.index') }}" class="nav-link {{ request()->routeIs('admin.order.*') ? 'active' : '' }}">All Orders</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Coupons -->
            @php $isCouponActive = request()->routeIs('coupon.*'); @endphp
            <li class="nav-item {{ $isCouponActive ? 'active' : '' }}">
                <a href="{{ route('coupon.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="gift"></i>
                    <span class="link-title">Coupons</span>
                </a>
            </li>

            {{-- ========================================== --}}
            {{-- ACCOUNTS --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">Accounts</li>

            <!-- Customers -->
            @php $isCustomerActive = request()->routeIs('customer.*'); @endphp
            <li class="nav-item {{ $isCustomerActive ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#customers" role="button" aria-expanded="{{ $isCustomerActive ? 'true' : 'false' }}" aria-controls="customers">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Customers</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ $isCustomerActive ? 'show' : '' }}" id="customers">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}" class="nav-link {{ request()->routeIs('customer.*') ? 'active' : '' }}">All Customers</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ========================================== --}}
            {{-- CONFIG --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">Config</li>

            <!-- Settings -->
            <li class="nav-item {{ request()->routeIs('settings.') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

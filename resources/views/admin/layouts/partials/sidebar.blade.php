<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.root') }}" class="sidebar-brand">
            <img src="{{ get_setting('site_logo') }}" alt="{{ get_setting('store_name') }}" height="40">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body position-relative">
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

            <!-- Products (Collapse) -->
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

            <!-- Categories (Collapse) -->
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

            <!-- Attributes & Tags (Collapse) -->
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
            {{-- SALES & ORDERS --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">Sales & Orders</li>

            <!-- Orders (Single) -->
            @php
            $isOrderActive = request()->routeIs('admin.order.*');
            $orderCount = \App\Models\Order::where('order_status', 'pending')->count();
            @endphp
            <li class="nav-item {{ $isOrderActive ? 'active' : '' }}">
                <a href="{{ route('admin.order.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="shopping-cart"></i>
                    <span class="link-title">Orders</span>
                    @if($orderCount > 0)
                    <span class="badge badge-danger-muted text-white font-weight-bold ms-auto ml-auto">{{ $orderCount }}</span>
                    @endif
                </a>
            </li>

            <!-- Coupons (Single) -->
            <li class="nav-item {{ request()->routeIs('coupon.*') ? 'active' : '' }}">
                <a href="{{ route('coupon.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="gift"></i>
                    <span class="link-title">Coupons</span>
                </a>
            </li>

            {{-- ========================================== --}}
            {{-- USERS & ENGAGEMENT --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">Users & Engagement</li>

            <!-- Customers (Single) -->
            <li class="nav-item {{ request()->routeIs('customer.*') ? 'active' : '' }}">
                <a href="{{ route('customer.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Customers</span>
                </a>
            </li>

            <!-- Subscribers (Single) -->
            <li class="nav-item {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                <a href="{{ route('admin.subscribers.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Subscribers</span>
                </a>
            </li>

            <!-- Reviews (Single) -->
            <li class="nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <a href="{{ route('admin.reviews.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="star"></i>
                    <span class="link-title">Reviews</span>
                </a>
            </li>

            <!-- Inbox / Contact (Single) -->
            @php
            $isContactActive = request()->routeIs('admin.contact.*');
            $unreadContactCount = \App\Models\ContactMessage::where('is_read', false)->count();
            @endphp
            <li class="nav-item {{ $isContactActive ? 'active' : '' }}">
                <a href="{{ route('admin.contact.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="message-square"></i>
                    <span class="link-title">Inbox</span>
                    @if($unreadContactCount > 0)
                    <span class="badge badge-danger-muted text-white font-weight-bold ms-auto ml-auto">{{ $unreadContactCount }}</span>
                    @endif
                </a>
            </li>

            {{-- ========================================== --}}
            {{-- WEBSITE CONTENT --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">Website Content</li>

            <!-- Sliders -->
            <li class="nav-item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.sliders.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="image"></i>
                    <span class="link-title">Hero Sliders</span>
                </a>
            </li>

            <!-- Dynamic Pages -->
            <li class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pages.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">Pages</span>
                </a>
            </li>

            <!-- FAQs -->
            <li class="nav-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <a href="{{ route('admin.faqs.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="help-circle"></i>
                    <span class="link-title">FAQs</span>
                </a>
            </li>

            {{-- ========================================== --}}
            {{-- SYSTEM CONFIG --}}
            {{-- ========================================== --}}
            <li class="nav-item nav-category">System</li>

            <!-- Settings -->
            <li class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">Settings</span>
                </a>
            </li>

            {{-- logout --}}
            <li class="nav-item text-danger mt-3">
                <form class="nav-link" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn text-danger p-0" >
                        <i data-feather="log-out" class="mr-2"></i> <span class="link-title fw-bold m-0" style="font-size:16px;">Log Out</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</nav>

<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <form class="search-form">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i data-feather="search"></i>
                    </div>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
            </div>
        </form>
        
        <ul class="navbar-nav">
            
            <!-- View Site Button -->
            <li class="nav-item">
                <a href="{{ route('home') }}" target="_blank" class="nav-link text-primary border border-primary rounded-pill p-2 font-weight-bold d-flex" title="Visit Website">
                    <i data-feather="globe" class="icon-md"></i>
                    <span class="d-none d-md-inline-block ml-1 text-nowrap">View Site</span>
                </a>
            </li>

            <!-- Messages Dropdown -->
            @php
                $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->latest()->take(5)->get();
                $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count();
            @endphp
            
            <li class="nav-item dropdown nav-messages">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="mail"></i>
                    <!-- Indicator for Unread Messages -->
                    @if($unreadCount > 0)
                    <div class="indicator">
                        <div class="circle"></div>
                    </div>
                    @endif
                </a>
                <div class="dropdown-menu" aria-labelledby="messageDropdown" style="width: 350px;">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        <p class="font-weight-medium mb-0">{{ $unreadCount }} New Messages</p>
                    </div>
                    <div class="dropdown-body">
                        
                        @forelse($unreadMessages as $msg)
                        <a href="{{ route('admin.contact.index') }}" class="dropdown-item">
                            <div class="content w-100 pl-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="font-weight-bold">{{ $msg->name }}</p>
                                    <p class="sub-text text-muted">{{ $msg->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="sub-text text-muted">{{ Str::limit($msg->subject ?? $msg->message, 35) }}</p>
                            </div>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted">
                            <i data-feather="check-circle" class="mb-2"></i>
                            <p>No new messages.</p>
                        </div>
                        @endforelse

                    </div>
                    <div class="dropdown-footer d-flex align-items-center justify-content-center">
                        <a href="{{ route('admin.contact.index') }}">View all messages</a>
                    </div>
                </div>
            </li>

            <!-- Profile Dropdown -->
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ auth()->user()->thumbnail }}" alt="{{ auth()->user()->name }}" style="width: 40px; height: 40px; object-fit: cover;">
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3 text-center">
                            <img src="{{ auth()->user()->thumbnail }}" alt="{{ auth()->user()->name }}" style="width: 60px; height: 60px; object-fit: cover;">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0">{{ auth()->user()->name }}</p>
                            <p class="email text-muted mb-3">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <li class="nav-item">
                                <a href="{{ route('admin.profile.index') }}" class="nav-link">
                                    <i data-feather="user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <form class="nav-link" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item bg-white p-0">
                                        <i data-feather="log-out"></i> <span>Log Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
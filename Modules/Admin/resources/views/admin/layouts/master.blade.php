<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="{{ asset('backend/assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/custom.css') }}" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @stack('styles')
</head>

<body>
    @php
    $admin = auth('admin')->user();
    @endphp
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-navbarbg="skin6" data-theme="light" data-layout="vertical" data-sidebartype="full"
        data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header" data-logobg="skin5">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <div class="navbar-brand">
                        <a href="index.html" class="logo">
                            <b class="logo-icon">
                                <img src="{{ asset('backend/assets/images/logo-icon.png') }}" alt="homepage"
                                    class="dark-logo" />
                                <img src="{{ asset('backend/assets/images/logo-light-icon.png') }}" alt="homepage"
                                    class="light-logo" />
                            </b>
                            <span class="logo-text">
                                <img src="{{ asset('backend/assets/images/logo-text.png') }}" alt="homepage"
                                    class="dark-logo" />
                                <img src="{{ asset('backend/assets/images/logo-light-text.png') }}" class="light-logo"
                                    alt="homepage" />
                            </span>
                        </a>
                    </div>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin6">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item search-box">
                            <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-magnify font-20 mr-1"></i>
                                    <div class="ml-1 d-none d-sm-block">
                                        <span>Search</span>
                                    </div>
                                </div>
                            </a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter">
                                <a class="srh-btn">
                                    <i class="ti-close"></i>
                                </a>
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('backend/assets/images/users/1.jpg') }}" alt="user"
                                    class="rounded-circle" width="31">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="ti-user m-r-5 m-l-5"></i>
                                    My Profile</a>
                                <a class="dropdown-item" href="{{ route('admin.change-password') }}"><i class="fas fa-lock m-r-5 m-l-5"></i></i>
                                    Change Password</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i>
                                    Inbox</a>
                                <!--Logout admin -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="ti-power-off m-r-5 m-l-5"></i> Logout</a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar d-flex flex-column" data-sidebarbg="skin5">
            <div class="scroll-sidebar flex-grow-1" style="overflow-y: auto;">

                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        @admincan('dashboard')
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.dashboard') }}" aria-expanded="false">
                                <i class="mdi mdi-av-timer"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        @endadmincan

                        @admincan('admin_manager_list')
                        <li class="sidebar-item {{ Route::is('admin.admins.*') ? 'selected' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ Route::is('admin.admins.*') ? 'active' : '' }}"
                                href="{{ route('admin.admins.index') }}" aria-expanded="false">
                                <i class="fas fa-users"></i>
                                <span class="hide-menu">Admin Manager</span>
                            </a>
                        </li>
                        @endadmincan

                        @admincan('roles_manager_list|permission_manager_list')
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-account-key"></i>
                                <span class="hide-menu">Role Permission Manager</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @admincan('roles_manager_list')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.roles.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-account-key"></i>
                                        <span class="hide-menu">Role Manager</span>
                                    </a>
                                </li>
                                @endadmincan

                                @admincan('permission_manager_list')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.permissions.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-key"></i>
                                        <span class="hide-menu">Permission Manager</span>
                                    </a>
                                </li>
                                @endadmincan

                            </ul>
                        </li>
                        @endadmincan

                        @admincan('users_manager_list')
                        @php
                        $sidebarRoles = \DB::table('user_roles')
                        ->where('status', 1)
                        ->orderBy('name')
                        ->get();
                        @endphp

                        <li class="sidebar-item {{ Route::is('admin.users.*') ? 'selected' : '' }}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark {{ Route::is('admin.users.*') ? 'active' : '' }}" href="javascript:void(0)">
                                <i class="fas fa-users"></i>
                                <span class="hide-menu">Manage Users</span>
                            </a>
                            <ul aria-expanded="{{ Route::is('admin.users.*') ? 'true' : 'false' }}" class="collapse first-level {{ Route::is('admin.users.*') ? 'in' : '' }}">
                                @foreach ($sidebarRoles as $role)
                                <li class="sidebar-item {{ request('type') === $role->slug ? 'selected' : '' }}">
                                    <a href="{{ route('admin.users.index', ['type' => $role->slug]) }}" class="sidebar-link {{ request('type') === $role->slug ? 'active' : '' }}">
                                        <i class="fas fa-circle"></i>
                                        <span class="hide-menu">{{ $role->name }} Manager</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endadmincan

                        @admincan('categories_manager_list')
                        <li class="sidebar-item {{ Route::is('admin.categories.*') ? 'selected' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ Route::is('admin.categories.*') ? 'active' : '' }}"
                                href="{{ route('admin.categories.index') }}" aria-expanded="false">
                                <i class="fas fa-th-large"></i>
                                <span class="hide-menu">Category Manager</span>
                            </a>
                        </li>
                        @endadmincan


                        @admincan('pages_manager_list|emails_manager_list|faqs_manager_list|banners_manager_list')
                        @php
                        $activeRoutes = ['admin.pages.*', 'admin.emails.*', 'admin.banners.*', 'admin.faqs.*'];
                        @endphp
                        <li class="sidebar-item {{ Route::is($activeRoutes) ? 'selected' : '' }}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark {{ Route::is($activeRoutes) ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-folder-open"></i>
                                <span class="hide-menu">Manage Content</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ Route::is($activeRoutes) ? 'in' : '' }}">
                                @admincan('pages_manager_list')
                                <li class="sidebar-item" {{ Route::is('admin.pages.*') ? 'selected' : '' }}>
                                    <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ Route::is('admin.pages.*') ? 'active' : '' }}">
                                        <i class="fas fa-circle"></i>
                                        <span class="hide-menu">CMS Pages Manager</span>
                                    </a>
                                </li>
                                @endadmincan

                                @admincan('emails_manager_list')
                                <li class="sidebar-item {{ Route::is('admin.emails.*') ? 'selected' : '' }}">
                                    <a href="{{ route('admin.emails.index') }}" class="sidebar-link {{ Route::is('admin.emails.*') ? 'active' : '' }}">
                                        <i class="fas fa-circle"></i>
                                        <span class="hide-menu">Email Template Manager</span>
                                    </a>
                                </li>
                                @endadmincan

                                @admincan('faqs_manager_list')
                                <li class="sidebar-item {{ Route::is('admin.faqs.*') ? 'selected' : '' }}">
                                    <a href="{{ route('admin.faqs.index') }}" class="sidebar-link {{ Route::is('admin.faqs.*') ? 'active' : '' }}">
                                        <i class="fas fa-circle"></i>
                                        <span class="hide-menu">Faq Manager</span>
                                    </a>
                                </li>
                                @endadmincan

                                @admincan('banners_manager_list')
                                <li class="sidebar-item {{ Route::is('admin.banners.*') ? 'selected' : '' }}">
                                    <a href="{{ route('admin.banners.index') }}" class="sidebar-link {{ Route::is('admin.banners.*') ? 'active' : '' }}">
                                        <i class="fas fa-circle"></i>
                                        <span class="hide-menu">Banner Manager</span>
                                    </a>
                                </li>
                                @endadmincan
                            </ul>
                        </li>
                        @endadmincan

                        @admincan('settings_manager_list')
                        <li class="sidebar-item {{ Route::is('admin.settings.*') ? 'selected' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ Route::is('admin.settings.*') ? 'active' : '' }}"
                                href="{{ route('admin.settings.index') }}" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                                <span class="hide-menu">Setting Manager</span>
                            </a>
                        </li>
                        @endadmincan
                    </ul>
                </nav>
            </div>
            @admincan('package_manager_list')
            <div class="sidebar-bottom-link p-3 mt-auto" style="position: sticky; bottom: 0; background: #222d32;">
                <a class="sidebar-link d-flex align-items-center" href="{{ route('admin.packages') }}">
                    <i class="fas fa-box mr-2"></i>
                    <span class="hide-menu">Package Manager</span>
                </a>
            </div>
            @endadmincan
        </aside>
        <div class="page-wrapper">
            <!-- Bread crumb and right sidebar toggle -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">
                            @yield('page-title', 'Dashboard')
                        </h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Home</a>
                                    </li>
                                    @yield('breadcrumb')
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->

            @yield('content')

            <!-- footer -->
            <footer class="footer text-center">
                All Rights Reserved by Dotsquares Designed and Developed by <a href="https://www.dotsquares.com"
                    target="_blank">Dotsquares</a>.
            </footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->

    <!-- All Jquery -->
    <script src="{{ asset('backend/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('backend/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('backend/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('backend/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('backend/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('backend/dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="{{ asset('backend/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('backend/dist/js/pages/dashboards/dashboard1.js') }}"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- sweetalert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--custom script -->
    <script src="{{ asset('backend/custom.js') }}"></script>

    <script>
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif

        @if(session('info'))
        toastr.info("{{ session('info') }}");
        @endif

        @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
        @endif
    </script>

    @stack('scripts')
</body>

</html>
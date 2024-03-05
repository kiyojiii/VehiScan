<!-- Fonts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- Scripts -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<!-- App favicon -->
<link rel="shortcut icon" href="<?php echo url('theme') ?>/dist/assets/images/favicon.ico">

<!-- Bootstrap Css -->
<link href="<?php echo url('theme') ?>/dist/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?php echo url('theme') ?>/dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?php echo url('theme') ?>/dist/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<!-- App js -->
<script src="<?php echo url('theme') ?>/dist/assets/js/plugin.js"></script>

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="fas fa-tachometer-alt"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/') }}" class="waves-effect">
                    <i class='fas fa-globe-asia'></i>
                        <span key="t-guests">Explore Website</span>
                    </a>
                </li>

                <li class="menu-title" key="t-apps">Data</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users"></i>
                        <span key="t-blog">Applicants</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('applicants.index') }}" key="t-blog-list">Pending Staff Applicants</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('applicants.manage') }}" key="t-blog-list">Manage Staff Applicants</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('applicants.index-partner') }}" key="t-blog-list">Manage Partner/Supplier Applicants</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('applicants.rejected-partner') }}" key="t-blog-list">Rejected Partner/Supplier Applicants</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-id-badge"></i>
                        <span key="t-blog">Owners</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('owners.index') }}" key="t-blog-list">Manage Owners</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-address-card"></i>
                        <span key="t-blog">Drivers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('drivers.index') }}" key="t-blog-list">Manage Drivers</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-car"></i>
                        <span key="t-blog">Vehicles</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('vehicles.index') }}" key="t-blog-list">Manage Staff Vehicles</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" key="t-blog-list">Manage Partner/Supplier Vehicles</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-clock"></i>
                        <span key="t-blog">Time</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" key="t-blog-list">Manage Time</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('time.test') }}" key="t-blog-list">Record Vehicle Time</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('appointments.index') }}" class="waves-effect">
                        <i class="fas fa-list-alt"></i>
                        <span key="t-guests">Appointments</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('status.index') }}" class="waves-effect">
                        <i class="fas fa-check-square"></i>
                        <span key="t-guests">Role Status</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('violations.index') }}" class="waves-effect">
                        <i class="fas fa-exclamation-circle"></i>
                        <span key="t-guests">Violations</span>
                    </a>
                </li>

                <li class="menu-title" key="t-apps">Permissions</li>

                <li>
                    @canany(['create-role', 'edit-role', 'delete-role'])
                    <a href="{{ route('roles.index') }}" class="waves-effect">
                        <i class="fas fa-key"></i>
                        <span key="t-key">Roles</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-user', 'edit-user', 'delete-user'])
                    <a href="{{ route('users.index') }}" class="waves-effect">
                        <i class="fas fa-user"></i>
                        <span key="t-user">Users</span>
                    </a>
                    @endcanany
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

<!-- JAVASCRIPT -->
<script src="<?php echo url('theme') ?>/dist/assets/libs/jquery/jquery.min.js"></script>
<script src="<?php echo url('theme') ?>/dist/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo url('theme') ?>/dist/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo url('theme') ?>/dist/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo url('theme') ?>/dist/assets/libs/node-waves/waves.min.js"></script>

<!-- apexcharts -->
<script src="<?php echo url('theme') ?>/dist/assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- dashboard blog init -->
<script src="<?php echo url('theme') ?>/dist/assets/js/pages/dashboard-blog.init.js"></script>
<script src="<?php echo url('theme') ?>/dist/assets/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- dashboard blog init -->
<script src="assets/js/pages/dashboard-blog.init.js"></script>

<script src="assets/js/app.js"></script>
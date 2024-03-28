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
                    <a href="#" class="waves-effect">
                        <i class="fas fa-clipboard-list"></i>
                        <span key="t-guests">User Requests</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('time.record_vehicles') }}" class="waves-effect">
                        <i class="fas fa-tasks"></i>
                        <span key="t-guests">Record Vehicle Time</span>
                    </a>
                </li>

                <li>
                    @canany(['create-applicant', 'edit-applicant', 'delete-applicant', 'view-applicant'])
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
                        <li><a href="#" key="t-blog-list">Pending Partner/Supplier Applicants</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('applicants.index-partner') }}" key="t-blog-list">Manage Partner/Supplier Applicants</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('owners.index') }}" class="waves-effect">
                        <i class="fas fa-id-badge"></i>
                        <span key="t-blog">Owners</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-driver', 'edit-driver', 'delete-driver', 'view-driver'])
                    <a href="{{ route('drivers.index') }}" class="waves-effect">
                        <i class="fas fa-address-card"></i>
                        <span key="t-blog">Drivers</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-vehicle', 'edit-vehicle', 'delete-vehicle', 'view-vehicle'])
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
                    @endcanany
                </li>

                <li>
                    @canany(['create-time', 'edit-time', 'delete-time', 'view-time'])
                    <a href="{{ route('time.index') }}" class="waves-effect">
                        <i class="fas fa-clock"></i>
                        <span key="t-blog">Time</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-appointment', 'edit-appointment', 'delete-appointment', 'view-appointment'])
                    <a href="{{ route('appointments.index') }}" class="waves-effect">
                        <i class="fas fa-list-alt"></i>
                        <span key="t-guests">Appointments</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-status', 'edit-status', 'delete-status', 'view-status'])
                    <a href="{{ route('status.index') }}" class="waves-effect">
                        <i class="fas fa-check-square"></i>
                        <span key="t-guests">Role Status</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-violation', 'edit-violation', 'delete-violation', 'view-violation'])
                    <a href="{{ route('violations.index') }}" class="waves-effect">
                        <i class="fas fa-exclamation-circle"></i>
                        <span key="t-guests">Violations</span>
                    </a>
                    @endcanany
                </li>

                <li class="menu-title" key="t-apps">Permissions</li>

                <li>
                    <a href="{{ route('applicant_users.user_profile') }}" class="waves-effect">
                        <i class="far fa-user-circle"></i>
                        <span key="t-user">Profile</span>
                    </a>
                </li>

                <li>
                    @canany(['create-user', 'edit-user', 'delete-user', 'view-user'])
                    <a href="{{ route('users.index') }}" class="waves-effect">
                        <i class="fas fa-user"></i>
                        <span key="t-user">Users</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-role', 'edit-role', 'delete-role', 'view-role'])
                    <a href="{{ route('roles.index') }}" class="waves-effect">
                        <i class="fas fa-user-lock"></i>
                        <span key="t-key">Roles</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-permission', 'edit-permission', 'delete-permission', 'view-permission'])
                    <a href="{{ route('permissions.index') }}" class="waves-effect">
                        <i class="fas fa-user-cog"></i>
                        <span key="t-user">Permissions</span>
                    </a>
                    @endcanany
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
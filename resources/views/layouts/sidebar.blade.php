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

                <li>
                    @canany(['create-analytics', 'edit-analytics', 'delete-analytics', 'view-analytics'])
                    <a href="{{ route('analytics') }}" class="waves-effect">
                        <i class="fas fa-chart-area"></i>
                        <span key="t-blog">Analytics</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-reports', 'edit-reports', 'delete-reports', 'view-reports'])
                    <a href="{{ route('reports') }}" class="waves-effect">
                        <i class="fas fa-envelope-open-text"></i>
                        <span key="t-blog">Reports</span>
                    </a>
                    @endcanany
                </li>


                @php
                $accessiblePermissions = [
                'create-user-requests', 'edit-user-requests', 'delete-user-requests', 'view-user-requests',
                'create-record-vehicles', 'edit-record-vehicles', 'delete-record-vehicles', 'view-record-vehicles',
                'create-pending', 'edit-pending', 'delete-pending', 'view-pending',
                'create-applicant', 'edit-applicant', 'delete-applicant', 'view-applicant',
                'create-vehicle', 'edit-vehicle', 'delete-vehicle', 'view-vehicle',
                'create-owner', 'edit-owner', 'delete-owner', 'view-owner',
                'create-driver', 'edit-driver', 'delete-driver', 'view-driver',
                'create-time', 'edit-time', 'delete-time', 'view-time',
                'create-violation', 'edit-violation', 'delete-violation', 'view-violation',
                'create-appointment', 'edit-appointment', 'delete-appointment', 'view-appointment',
                'create-status', 'edit-status', 'delete-status', 'view-status'
                ];
                @endphp

                @canany($accessiblePermissions)
                <li class="menu-title" key="t-apps">Overview</li>
                @endcanany

                <li>
                    @canany(['create-user-requests', 'edit-user-requests', 'delete-user-requests', 'view-user-requests'])
                    <a href="{{ route('user_requests')}}" class="waves-effect">
                        <i class="fas fa-clipboard-list"></i>
                        <span key="t-guests">User Requests</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-record-vehicles', 'edit-record-vehicles', 'delete-record-vehicles', 'view-record-vehicles'])
                    <a href="{{ route('time.record_vehicles') }}" class="waves-effect">
                        <i class="fas fa-tasks"></i>
                        <span key="t-guests">Record Vehicle Time</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-pending', 'edit-pending', 'delete-pending', 'view-pending'])
                    <a href="{{ route('applicants.applicants_pending') }}" class="waves-effect">
                        <i class="fas fa-user-clock"></i>
                        <span key="t-guests">Pending Applicants</span>
                    </a>
                    @endcanany
                </li>

                <li>
                    @canany(['create-applicant', 'edit-applicant', 'delete-applicant', 'view-applicant'])
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users"></i>
                        <span key="t-blog">Applicants</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('applicants.manage') }}" key="t-blog-list">Manage Staff Applicants</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('applicants.index-partner') }}" key="t-blog-list">Manage Partner/Supplier Applicants</a></li>
                    </ul>
                    @endcanany
                </li>

                <li>
                    @canany(['create-vehicle', 'edit-vehicle', 'delete-vehicle', 'view-vehicle'])
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-car"></i>
                        <span key="t-blog">Vehicles</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('vehicles.index') }}" key="t-blog-list">Staff Vehicles</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('vehicles.index-partner-supplier') }}" key="t-blog-list">Partner/Supplier Vehicles</a></li>
                    </ul>
                    @endcanany
                </li>


                <li>
                    @canany(['create-owner', 'edit-owner', 'delete-owner', 'view-owner'])
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
                    @canany(['create-time', 'edit-time', 'delete-time', 'view-time'])
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-clock"></i>
                        <span key="t-blog">Time</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('time.index') }}" key="t-blog-list">Time Record</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('activity_feed') }}" key="t-blog-list">Activity Feed</a></li>
                    </ul>
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

                @canany(['create-user', 'edit-user', 'delete-user', 'view-user'])
                <li class="menu-title" key="t-apps">Permissions</li>

                <li>
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
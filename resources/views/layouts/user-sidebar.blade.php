<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('applicant_users.applicant_home') }}" class="waves-effect">
                        <i class="fas fa-tachometer-alt"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('applicant_users.applicant_violation') }}" class="waves-effect">
                        <i class="fas fa-exclamation-circle"></i>
                        <span key="t-dashboards">Violations</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/') }}" class="waves-effect">
                        <i class='fas fa-chart-bar'></i>
                        <span key="t-guests">Visit Analytics</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/') }}" class="waves-effect">
                        <i class='fas fa-chart-bar'></i>
                        <span key="t-guests">Application </span>
                    </a>
                </li>

                <li class="menu-title" key="t-apps">User</li>

                <li>
                    <a href="{{ route('applicant_users.user_profile') }}" class="waves-effect">
                        <i class="far fa-user-circle"></i>
                        <span key="t-user">Profile</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
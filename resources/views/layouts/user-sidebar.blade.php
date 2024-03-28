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
                    <a href="{{ route('applicant_users.applicant_vehicle') }}" class="waves-effect">
                        <i class="fas fa-car"></i>
                        <span key="t-dashboards">Vehicles</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('applicant_users.applicant_violation') }}" class="waves-effect">
                        <i class="fas fa-exclamation-circle"></i>
                        <span key="t-dashboards">Violations</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('applicant_users.applicant_analytics') }}" class="waves-effect">
                        <i class='fas fa-chart-bar'></i>
                        <span key="t-guests">Analytics</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('applicant_users.applicant_apply') }}" class="waves-effect">
                        <i class='fas fa-receipt'></i>
                        <span key="t-guests">Application </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('applicant_users.applicant_history') }}" class="waves-effect">
                        <i class='fas fa-history'></i>
                        <span key="t-guests">History </span>
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

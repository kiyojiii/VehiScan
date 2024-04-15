{{-- LAYOUT --}}
@extends("landing.layouts.layout")

@section("content")
<!-- ***** Main Banner Area Start ***** -->
<section class="section main-banner" id="top" data-section="section1">

    <img src="{{ asset('landing/assets/images/banner_2.png') }}" alt="Fallback Image">


    <div class="video-overlay header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="caption">
                        <h6>Hello!</h6>
                        <h2>Welcome to MVIS</h2>
                        <p>A vehicle inventory system designed for MSU-IIT. Our platform allows staff and security guards to efficiently record vehicle entries and exits using QR code scanning. Users can register to access applications where they can input personal, vehicle, and driver information.</p>
                        <div class="main-button-red">
                            @if (Route::has('login'))
                            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                                @auth
                                <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">You are Logged in as {{ auth()->user()->name }}</a>
                                @else
                                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                                @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                @endif
                                @endauth
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Main Banner Area End ***** -->

<section class="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-service-item owl-carousel">

                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('landing/assets/images/application.png') }}" alt="">
                        </div>
                        <div class="down-content">
                            <h4>Application</h4>
                            <p>Apply and manage applications including personal information, vehicle information, and driver information.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('landing/assets/images/car-solid.png') }}" alt="">
                        </div>
                        <div class="down-content">
                            <h4>Vehicles</h4>
                            <p>Manage vehicle records, including registration status, approval status and vehicle owner information.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('landing/assets/images/clock.png') }}" alt="">
                        </div>
                        <div class="down-content">
                            <h4>Record Time</h4>
                            <p>Record time in and time out of vehicles using QR code scanning for inventory management.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('landing/assets/images/violation.png') }}" alt="">
                        </div>
                        <div class="down-content">
                            <h4>Violation</h4>
                            <p>Monitor and manage violations, ensuring staff and vehicle owners are in compliance with regulations and policies.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('landing/assets/images/user.png') }}" alt="">
                        </div>
                        <div class="down-content">
                            <h4>Users</h4>
                            <p>Manage user accounts, roles, and permissions for system access and security.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="upcoming-meetings" id="meetings">
</section>

<section class="apply-now" id="apply">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="row">
                    <div class="col-lg-12">
                        @if (Route::has('login'))
                        @auth
                        <div class="item">
                            <h3>APPLY FOR AN APPLICATION</h3>
                            <p>Greetings {{ auth()->user()->name }}, If you have not applied yet, You can click this Button.</p>
                            <div class="main-button-red">
                                <a href="{{ route('applicant_users.applicant_apply') }}">Apply Now</a>
                            </div>
                        </div>
                        @else
                        @if (Route::has('register'))
                        <div class="item">
                            <h3>REGISTER AN ACCOUNT</h3>
                            <p>You must register an account first to create an application and apply for a Vehicle QR Code.</p>
                            <div class="main-button-red">
                                <a href="{{ route('register') }}">Register Now</a>
                            </div>
                        </div>
                        @endif
                        @endauth
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="accordions is-first-expanded">
                    <article class="accordion">
                        <div class="accordion-head">
                            <span>About MVIS</span>
                            <span class="icon">
                                <i class="icon fa fa-chevron-right"></i>
                            </span>
                        </div>
                        <div class="accordion-body">
                            <div class="content">
                                <p>MVIS is a comprehensive vehicle inventory system designed to streamline the process of recording vehicle movements using QR codes. With MVIS, users can efficiently track vehicle time-ins and time-outs, manage driver and vehicle information, and monitor vehicle violations. The system offers a user-friendly interface and robust features to ensure accurate and efficient management of vehicle records.</p>
                            </div>
                        </div>
                    </article>
                    <article class="accordion">
                        <div class="accordion-head">
                            <span>Features</span>
                            <span class="icon">
                                <i class="icon fa fa-chevron-right"></i>
                            </span>
                        </div>
                        <div class="accordion-body">
                            <div class="content">
                                <p>MVIS offers a range of features to meet the needs of vehicle management, including:</p>
                                <p>> Efficient recording of vehicle time-ins and time-outs using QR codes</p>
                                <p>> Comprehensive management of driver and vehicle information </p>
                                <p>> Monitoring and tracking of vehicle violations </p>
                                <p>> User-friendly interface for easy navigation and operation </p>
                                <p>> Customizable settings and permissions to suit specific requirements </p>

                            </div>
                        </div>
                    </article>
                    <article class="accordion">
                        <div class="accordion-head">
                            <span>Integration with Existing Systems</span>
                            <span class="icon">
                                <i class="icon fa fa-chevron-right"></i>
                            </span>
                        </div>
                        <div class="accordion-body">
                            <div class="content">
                                <p>MVIS can be seamlessly integrated with existing systems and databases, allowing for smooth data transfer and synchronization. Whether you're using an ERP system, a fleet management platform, or other software solutions, MVIS can be customized to fit your needs and enhance your existing workflows.</p>
                            </div>
                        </div>
                    </article>
                    <article class="accordion last-accordion">
                        <div class="accordion-head">
                            <span>Enhanced Security Measures</span>
                            <span class="icon">
                                <i class="icon fa fa-chevron-right"></i>
                            </span>
                        </div>
                        <div class="accordion-body">
                            <div class="content">
                                <p>MVIS prioritizes security and data protection, implementing advanced encryption protocols and access controls to safeguard sensitive information. With MVIS, you can trust that your vehicle records are secure and protected from unauthorized access or tampering.</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="our-courses" id="courses">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Our Popular Courses</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="owl-courses-item owl-carousel">
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-01.jpg') }}" alt="Course One">
                        <div class="down-content">
                            <h4>Morbi tincidunt elit vitae justo rhoncus</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$160</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-02.jpg') }}" alt="Course Two">
                        <div class="down-content">
                            <h4>Curabitur molestie dignissim purus vel</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$180</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-03.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Nulla at ipsum a mauris egestas tempor</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$140</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-04.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Aenean molestie quis libero gravida</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$120</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-01.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Lorem ipsum dolor sit amet adipiscing elit</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$250</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-02.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>TemplateMo is the best website for Free CSS</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$270</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-03.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Web Design Templates at your finger tips</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$340</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-04.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Please visit our website again</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$360</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-01.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Responsive HTML Templates for you</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$400</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-02.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Download Free CSS Layouts for your business</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$430</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-03.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Morbi in libero blandit lectus cursus</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$480</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('landing/assets/images/course-04.jpg') }}" alt="">
                        <div class="down-content">
                            <h4>Curabitur molestie dignissim purus</h4>
                            <div class="info">
                                <div class="row">
                                    <div class="col-8">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <span>$560</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="our-facts">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>A Few Details About Our System</h2>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="count-area-content">
                                    <div class="count-digit">{{$totalUsers}}</div>
                                    <div class="count-title">Users</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="count-area-content">
                                    <div class="count-digit">{{$totalVehicles}}</div>
                                    <div class="count-title">Vehicles</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="count-area-content new-students">
                                    <div class="count-digit">{{$totalOwners}}</div>
                                    <div class="count-title">Owners</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="count-area-content">
                                    <div class="count-digit">{{$totalDrivers}}</div>
                                    <div class="count-title">Drivers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="video">
                    <a href="https://www.youtube.com/watch?v=HndV87XpkWg" target="_blank"><img src="assets/images/play-icon.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-us" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 align-self-center">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="contact" action="" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2>Let's get in touch</h2>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <h4>ADMISSIONS</h4>
                                        <p>
                                            <i class="bx bx-envelope"></i> <a href="mailto:admissions@g.msuiit.edu.ph">admissions@g.msuiit.edu.ph</a><br>
                                            <i class="bx bx-phone"></i> +63 (063) 223 8641
                                        </p>
                                    </fieldset>
                                </div>
                                <br><br><br><br><br>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <h4>REGISTRAR</h4>
                                        <p>
                                            <i class="bx bx-envelope"></i> <a href="mailto:registrar@g.msuiit.edu.ph">registrar@g.msuiit.edu.ph</a><br>
                                            <i class="bx bx-phone"></i> +63 (063) 223 3794
                                        </p>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <h4>GUIDANCE COUNSELORS</h4>
                                        <p>
                                            <i class="bx bx-envelope"></i> <a href="mailto:guidance@g.msuiit.edu.ph">guidance@g.msuiit.edu.ph</a><br>
                                            <i class="bx bx-phone"></i> +63 (063) 225 4634 / 221 4050
                                        </p>
                                    </fieldset>
                                </div>
                                <br><br><br><br><br>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <h4>WEBTEAM</h4>
                                        <p>
                                            <i class="bx bx-envelope"></i> <a href="mailto:webteam@g.msuiit.edu.ph">webteam@g.msuiit.edu.ph</a>
                                        </p>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="right-info">
                    <ul>
                        <li>
                            <h6>Phone Number</h6>
                            <span>+63 (063) 221-4056</span>
                        </li>
                        <li>
                            <h6>Email Address</h6>
                            <span>opi@g.msuiit.edu.ph</span>
                        </li>
                        <li>
                            <h6>Street Address</h6>
                            <span>Andres Bonifacio Avenue, Tibanga,
                                9200 Iligan City, Philippines</span>
                        </li>
                        <li>
                            <h6>Website URL</h6>
                            <span>https://www.msuiit.edu.ph</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>Copyright © 2024 MVIS, Ltd. All Rights Reserved.</p>
    </div>
</section>
@endsection
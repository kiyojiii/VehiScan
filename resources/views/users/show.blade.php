<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Profile | Skote - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    </head>

    <style>
        .user-photo-container {
            width: 50px;
            height: 50px;
            overflow: hidden;
            border-radius: 50%;
        }

        .user-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-photo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 7px;
            color: #fff;
        }

        .verti-timeline .event-list:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

    </style>

<body data-sidebar="dark">

@extends('layouts.app')

@section('content')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Profile</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card overflow-hidden">
                                    <div class="bg-primary-subtle">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="text-primary p-3">
                                                    <h5 class="text-primary">Hello, Welcome!</h5>
                                                    <p>Crafting Stories, Inspiring Minds</p>
                                                </div>
                                            </div>
                                            <div class="col-4 align-self-end">
                                                <img src="<?php echo url('theme')?>/dist/assets/images/profile-img.png" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">

                                            <div class="col-sm-8">
                                                <div class="avatar-md profile-user-wid mb-4">
                                                    @if ($user->photo)
                                                        <img src="{{ asset('images/photos/' . $user->photo) }}" alt="Profile Photo" class="rounded-circle user-photo">
                                                    @else
                                                        <div class="no-photo" >No Photo</div>
                                                    @endif
                                                </div>
                                                <h5 class="font-size-15 text-truncate">{{ $user->name }}</h5>
                                                <p class="text-muted mb-0 text-truncate">                            
                                                    @forelse ($user->getRoleNames() as $role)
                                                    {{ $role }}
                                                    @empty
                                                    @endforelse
                                                </p>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="pt-4">
                                                   
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5 class="font-size-15">{{ $totalUserPosts }}</h5>
                                                            <p class="text-muted mb-0">Blog Posts</p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4">
                                                        <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light btn-sm">View Blogs <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Personal Information</h4>

                                        <p class="text-muted mb-4" style="text-align: justify;">
                                            Hello, I am {{ $user->name }} - a seasoned blogger known for providing insightful and engaging content. With a background in writing and a passion for sharing knowledge, I've become a trusted source in the industry. Join me on this journey of exploration and discovery through the world of words.
                                        </p>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Full Name :</th>
                                                        <td>{{ $user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">E-mail :</th>
                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">User Role :</th>
                                                        <td>
                                                            @forelse ($user->getRoleNames() as $role)
                                                            {{ $role }}
                                                            @empty
                                                            @endforelse
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-5">Popular Blog Posts</h4>
                                        <div class="">
                                            <ul class="verti-timeline list-unstyled">
                                                @foreach ($mostViewedTemplates as $template)
                                                    <li class="event-list active">
                                                        <div class="event-timeline-dot">
                                                            <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 me-3">
                                                                <i class="bx bx-detail h4 text-primary"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <h5 class="font-size-15">
                                                                        <a href="{{ route('templates.show', $template->id) }}" class="text-dark">{{ $template->header }}</a>
                                                                    </h5>
                                                                    <span class="text-primary">{{ $template->created_at->format('M d, Y  h:i A') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>


                                    </div>
                                </div>  
                                <!-- end card -->
                            </div>         
                            
                            <div class="col-xl-8">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium mb-2">Views Received</p>
                                                        <h4 class="mb-0">{{ $currentUserViews }}</h4>
                                                    </div>
        
                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bi bi-eye align-middle me-1 font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium mb-2">Likes Received</p>
                                                        <h4 class="mb-0">{{ $totalUserLikes }}</h4>
                                                    </div>
        
                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-like align-middle me-1 font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium mb-2">Comments Received</p>
                                                        <h4 class="mb-0">{{ $totalUserComments }}</h4>
                                                    </div>
        
                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-comment-dots align-middle me-1 font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Monthly Total Postings</h4>
                                        <div id="revenue-chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">{{ $user->name }}'s Published Blogs</h4>
                                        <div class="table-responsive">
                                            <div id="nissinoodles">
                                            @include('users.show_pagination')
                                            </div>
                                            @if(isset($yoser))
                                            {{ $yoser }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Skote.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        @endsection
    </body>
</html>

<script>
    var userId = {{ $user->id }};
    $(document).ready(function(){
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            show_pagination(page);
        });

        function show_pagination(page)
        {
            $.ajax({
                url:"/pagination/show_pagination",
                data: {
                    page: page,
                    user_id: userId,
                },
                success:function(data)
                {
                    $('#nissinoodles').html(data);
                }
            })
        }
    });
</script>


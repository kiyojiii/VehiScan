<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users | List</title>

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
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 7px;
            color: #fff;
        }
    </style>
</head>

<body>

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
                            <h4 class="mb-sm-0 font-size-18">Users List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                    <li class="breadcrumb-item active">Users List</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Users Lists</h5>
                                    <div class="flex-shrink-0">
                                        @can('create-role')
                                        <a href="{{ route('users.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New User</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle nowrap">
                                        <thead>
                                            <tr>
                                                <th scope="col">User Image</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Roles</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $user)
                                            <tr>
                                                <td style="text-align: center;">
                                                    <div class="user-photo-container">
                                                        @if ($user->photo)
                                                        <img src="{{ asset('images/photos/' . $user->photo) }}" alt="Profile Photo" class="rounded-circle user-photo" width="50" height="50">
                                                        @else
                                                        <div class="no-photo">No Photo</div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @forelse ($user->getRoleNames() as $role)
                                                    <span class="badge bg-primary">{{ $role }}</span>
                                                    @empty
                                                    @endforelse
                                                </td>
                                                <td>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i></a>

                                                        @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                                                        @if (Auth::user()->hasRole('Super Admin'))
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                                        @endif
                                                        @else
                                                        @can('edit-user')
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                                        @endcan

                                                        @can('delete-user')
                                                        @if (Auth::user()->id!=$user->id)
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this user?');"><i class="bi bi-trash"></i></button>
                                                        @endif
                                                        @endcan
                                                        @endif

                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <td colspan="5">
                                                <span class="text-danger">
                                                    <strong>No User Found!</strong>
                                                </span>
                                            </td>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    {{ $users->links() }}

                                </div>
                            </div>
                        </div><!--end card-->
                    </div><!--end col-->

                </div><!--end row-->


            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    @endsection

</body>

</html>
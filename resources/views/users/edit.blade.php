<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> MVIS | Users - Edit </title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

</head>

<body>

    @extends('layouts.app')

    @section('content')
    <!-- Page Content -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Edit User</h4>
                            <h4 id="digitalClock" class="clock"></h4>
                            @include('clock_js')
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                                    <li class="breadcrumb-item active">Edit User</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                
                <script>
                    // This code will execute when the page is loaded
                    document.addEventListener('DOMContentLoaded', function() {
                        // Check if the user creation success message exists in session
                        @if (session('user_created_success'))
                            // Show SweetAlert success message for user creation
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '{{ session('user_created_success') }}',
                                showConfirmButton: false,
                                timer: 3000 // Close the alert after 3 seconds
                            });
                        @endif

                        // Check if the user update success message exists in session
                        @if (session('user_updated_success'))
                            // Show SweetAlert success message for user update
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '{{ session('user_updated_success') }}',
                                showConfirmButton: false,
                                timer: 3000 // Close the alert after 3 seconds
                            });
                        @endif
                    });
                </script>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                        <a href="{{ route('users.index') }}" class="col-md-1 offset-md-0 btn btn-sm btn-danger"><i class="bx bx-arrow-back"></i> Go Back</a>
                            <div class="card-body">
                                <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method("PUT")

                                    <div class="mb-3 row">
                                        <label for="photo" class="col-md-4 col-form-label text-md-end text-start">User Photo</label>
                                        <div class="col-md-6 text-center">
                                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                            @if ($user->photo)
                                            <img src="{{ asset('images/photos/' . $user->photo) }}" alt="Current Photo" class="img-thumbnail" width="100" height="100">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">
                                            @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                            @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>
                                        <div class="col-md-6">
                                            <select class="form-select @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                                                @forelse ($roles as $role)

                                                @if ($role!='Super Admin')
                                                <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                                @else
                                                @if (Auth::user()->hasRole('Super Admin'))
                                                <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                                @endif
                                                @endif

                                                @empty

                                                @endforelse
                                            </select>
                                            @if ($errors->has('roles'))
                                            <span class="text-danger">{{ $errors->first('roles') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update User">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->
    </div>
    <!-- end main content-->
    @endsection

</body>

</html>
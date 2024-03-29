<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Applicant </title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner-chase">
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                </div>
            </div>
        </div>

    @extends('layouts.app2')

    @section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mx-n4 mt-n4 bg-info-subtle">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('images/photos/' . $user->photo) }}" alt="" class="avatar-md rounded-circle mx-auto d-block" />
                                    <h5 class="mt-3 mb-1">{{ auth()->user()->name }}</h5>
                                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                                    <div class="mx-auto">
                                        <span class="badge text-bg-info">
                                        @foreach($appointment as $appointment)
                                            {{ $appointment->appointment }}
                                        @endforeach
                                    </span>
                                        @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire(
                            'Success!',
                            '{{ session('success') }}',
                            'success'
                        );
                    </script>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <button id="editUserBtn" class="btn btn-primary">Edit User</button>
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var editUserBtn = document.getElementById("editUserBtn");
                                    var editUserForm = document.getElementById("editUserForm");

                                    editUserBtn.addEventListener("click", function() {
                                        if (editUserForm.style.display === "none") {
                                            editUserForm.style.display = "block";
                                        } else {
                                            editUserForm.style.display = "none";
                                        }
                                    });
                                });
                            </script>

                            <div class="row" id="editUserForm" style="display: none;">
                                <div class="col-lg-12">
                                    <div class="card">
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

                                                <div class="mb-3 row" style="display: none;">
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

                        </div> <!-- End card -->

                    </div><!--end col-->
                </div><!--end row-->


            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

    </div>
    <!-- end main content-->
</body>

</html>
@endsection
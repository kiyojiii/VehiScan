<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> VehiScan | Permissions - Edit </title>
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
                            <h4 class="mb-sm-0 font-size-18">Edit Permission</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permission</a></li>
                                    <li class="breadcrumb-item active">Edit</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                        <a href="{{ route('permissions.index') }}" class="col-md-1 offset-md-0 btn btn-sm btn-danger"><i class="bx bx-arrow-back"></i> Go Back</a>
                            <div class="card-body">
                                <form action="{{ route('permissions.update', $permission->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div id="permissionsContainer">
                                        <label for="name" class="form-label">Permissions</label>
                                            <div class="mb-3 permissionInputRow">
                                                <div class="d-flex">
                                                    <input type="text" class="form-control permissionInput" name="name[]" value="{{ $permission->name }}" required>
                                                    <button type="button" class="btn btn-danger removePermissionBtn"><i class="bi bi-x-circle"></i></button>
                                                </div>
                                            </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Permissions</button>
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

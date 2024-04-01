<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> VehiScan | Permissions - Create</title>

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
                            <h4 class="mb-sm-0 font-size-18">Create New Permission</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
                                    <li class="breadcrumb-item active">Create</li>
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
                                <form action="{{ route('permissions.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div id="permissionsContainer">
                                        <label for="name" class="form-label">Permissions</label>
                                        <!-- Initial input field for permission -->
                                        <div class="mb-3 permissionInputRow">
                                            <div class="d-flex">
                                                <input type="text" class="form-control permissionInput" name="name[]" required>
                                                <button type="button" class="btn btn-danger removePermissionBtn"><i class="bi bi-x-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Button to add more input fields -->
                                    <button type="button" class="btn btn-success" id="addPermissionBtn"><i class="bi bi-plus-circle"></i> More Permissions</button>
                                    <button type="submit" class="btn btn-primary">Create Permissions</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->
    </div>
    <!-- end main content-->
    <script>
        // Function to add more input fields for permissions
        document.getElementById('addPermissionBtn').addEventListener('click', function() {
            var permissionsContainer = document.getElementById('permissionsContainer');
            // Create a new input field
            var newPermissionInput = document.createElement('div');
            newPermissionInput.className = 'mb-3 permissionInputRow';
            newPermissionInput.innerHTML = `
                <div class="d-flex">
                    <input type="text" class="form-control permissionInput" name="name[]" required>
                    <button type="button" class="btn btn-danger removePermissionBtn"><i class="bi bi-x-circle"></i></button>
                </div>
            `;
            // Append the new input field to the container
            permissionsContainer.appendChild(newPermissionInput);
        });

        // Function to remove input fields for permissions
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('removePermissionBtn')) {
                event.target.closest('.permissionInputRow').remove();
            }
        });
    </script>
    @endsection
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles | Edit</title>

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
                            <h4 class="mb-sm-0 font-size-18">Edit Role</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                                    <li class="breadcrumb-item active">Edit Role</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                        <a href="{{ route('roles.index') }}" class="col-md-1 offset-md-0 btn btn-sm btn-danger"><i class="bx bx-arrow-back"></i> Go Back</a>
                            <div class="card-body">
                                <form action="{{ route('roles.update', $role->id) }}" method="post">
                                    @csrf
                                    @method("PUT")

                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                        <div class="col-md-6">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $role->name }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="permissions" class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                                        <div class="col-md-6">           
                                            <select class="form-select @error('permissions') is-invalid @enderror" multiple aria-label="Permissions" id="permissions" name="permissions[]" style="height: 210px;">
                                                @forelse ($permissions as $permission)
                                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions ?? []) ? 'selected' : '' }}>
                                                        {{ $permission->name }}
                                                    </option>
                                                @empty

                                                @endforelse
                                            </select>
                                            @if ($errors->has('permissions'))
                                                <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Role">
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
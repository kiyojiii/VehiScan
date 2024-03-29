<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles | Details</title>
</head>
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
                        <h4 class="mb-sm-0 font-size-18">Role Details</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Role</a></li>
                                <li class="breadcrumb-item active">Role Details</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $role->name }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="roles" class="col-md-4 col-form-label text-md-end text-start"><strong>Permissions:</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        @if ($role->name=='Super Admin')
                                            <span class="badge bg-primary">All</span>
                                        @else
                                            @forelse ($rolePermissions as $permission)
                                                <span class="badge bg-primary">{{ $permission->name }}</span>
                                            @empty
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                        </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end main content-->

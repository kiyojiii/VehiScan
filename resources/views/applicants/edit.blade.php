<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Applicant - Show</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <h4 class="mb-sm-0 font-size-18">Edit Applicant Details</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Applicant</a></li>
                                    <li class="breadcrumb-item active"> Edit Applicant Details</li>
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
                                <div class="pt-3">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-8">
                                            <div>
                                                O: {{ $owners->id }}
                                                V: {{ $owners->vehicle->id }}
                                                D: {{ $owners->vehicle->driver->id }}
                                            <form action="{{ route('applicants.update', ['id' => $owners->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                                <div class="text-center">
                                                    <div class="mb-4">
                                                        Approval Status:
                                                        @if($owners->approval_status == 'Approved')
                                                        <a href="javascript:void(0);" class="badge bg-success font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-white me-1"></i> {{ $owners->approval_status }}
                                                        </a>
                                                        @elseif($owners->approval_status == 'Rejected')
                                                        <a href="javascript:void(0);" class="badge bg-danger font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-white me-1"></i> {{ $owners->approval_status }}
                                                        </a>
                                                        @else
                                                        <a href="javascript:void(0);" class="badge bg-light font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> {{ $owners->approval_status }}
                                                        </a>
                                                        @endif
                                                    </div>
                                                    <p class="text-muted mb-4">Date Registered:<i class="mdi mdi-calendar me-1"></i>{{ \Carbon\Carbon::parse($owners->created_at)->isoFormat('D MMM, YYYY [at] h:mm A') }}</p>

                                                    <h5 class="mt-4">Personal Info</h5>
                                                    <div class="row">
                                                       <div class="col-md">
                                                            <label for="serial_number">Serial Number</label>
                                                            <input type="text" name="serial_number" id="serial_number" class="form-control" placeholder="Serial Number" value="{{ $owners->serial_number }}" >
                                                        </div>
                                                        <div class="col-md">
                                                            <label for="id_number">ID Number</label>
                                                            <input type="text" name="id_number" id="id_number" class="form-control" placeholder="ID Number" value="{{ $owners->id_number }}" >          
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md">
                                                            <label for="fname">First Name</label>
                                                            <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" value="{{ $owners->first_name }}" >
                                                        </div>
                                                        <div class="col-md">
                                                            <label for="mi">Middle Initial (Letter Only)</label>
                                                            <input type="text" name="mi" class="form-control" id="add_mi"  placeholder="Middle Initial" maxlength="1" value="{{ $owners->middle_initial }}" >                                                   
                                                        </div>
                                                        <div class="col-md">
                                                            <label for="lname">Last Name</label>
                                                            <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" value="{{ $owners->last_name }}" >
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md">
                                                            <label for="paddress">Present Address</label>
                                                            <input type="text" name="paddress" class="form-control" id="paddress" placeholder="Present Address" value="{{ $owners->present_address }}" >
                                                        </div>
                                                        <div class="col-md">
                                                            <label for="email">Email Address</label>
                                                            <input type="text" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ $owners->email_address }}" >
                                                        </div>
                                                        <div class="col-md">
                                                            <label for="contact">Contact Number (11 Digits)</label>
                                                            <input type="text" name="contact" class="form-control" id="add_contact"  placeholder="Contact" value="{{ $owners->contact_number }}" pattern="[0-9]{11}" title="Please enter 11 numbers only" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <h5 class="mt-4">Work Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="position">Position & Designation</label>
                                                        <input type="text" name="position" class="form-control" placeholder="Position & Designation" value="{{ $owners->position_designation }}" >                                                
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="wrapper">
                                                            <label for="appointment">Appointment</label>
                                                            <select name="appointment" id="appointment" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                                <option value="">Select Appointment</option> <!-- Placeholder option -->
                                                                @forelse($appointments as $appointment)
                                                                    <option value="{{ $appointment->id }}" {{ $owners->appointment_id == $appointment->id ? 'selected' : '' }}>{{ $appointment->appointment }}</option>
                                                                @empty
                                                                    <option value="">No Appointments Available</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="wrapper">
                                                            <label for="role_status">Role Status</label>
                                                            <select name="role_status" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                                <option value="">Select Role Status</option> <!-- Placeholder option -->
                                                                @forelse($role_status as $rs)
                                                                    <option value="{{ $rs->id }}" {{ $owners->status_id == $rs->id ? 'selected' : '' }}>{{ $rs->applicant_role_status }}</option>
                                                                @empty
                                                                    <option value="">No Role Status Available</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <label for="department">Office/Department</label>
                                                        <input type="text" name="department" class="form-control" placeholder="Office/Department/Agency" value="{{ $owners->office_department_agency }}" >
                                                        @error('department')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Photo -->
                                                <h5 class="mt-4">Photo</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="scan_or_photo_of_id">Scan or Photo of ID</label>
                                                        <input type="file" name="scan_or_photo_of_id" class="form-control" >
                                                    </div>
                                                    <img src="{{ asset('storage/images/' . $owners->scan_or_photo_of_id) }}" alt="Photo ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                </div>

                                                <hr>

                                                <div class="mt-4">
                                                    <div class="text-muted font-size-14">
                                                    <h5>Vehicle Info</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label for="owner_address" class="form-label">Owner Address</label>
                                                                <input type="text" class="form-control" name="owner_address" id="owner_address" value="{{ $owners->vehicle->owner_address }}" >
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="plate_number" class="form-label">Plate Number</label>
                                                                <input type="text" class="form-control" name="plate_number" id="plate_number" value="{{ $owners->vehicle->plate_number }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="vehicle_make" class="form-label">Vehicle Make</label>
                                                                <input type="text" class="form-control" name="vehicle_make" id="vehicle_make" value="{{ $owners->vehicle->vehicle_make }}">
                                                            </div>
                                                        </div>            
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label for="year_model" class="form-label">Year Model</label>
                                                                <input type="text" class="form-control" name="year_model" id="year_model" value="{{ $owners->vehicle->year_model }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="color" class="form-label">Color</label>
                                                                <input type="text" class="form-control" name="color" id="color" value="{{ $owners->vehicle->color }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="body_type" class="form-label">Body Type</label>
                                                                <input type="text" class="form-control" name="body_type" id="body_type" value="{{ $owners->vehicle->body_type }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label for="registration_status">Status</label>
                                                                <select name="registration_status" id="registration_status" class="form-control">
                                                                    <option value="Active" {{ $owners->vehicle->registration_status == 'Active' ? 'selected' : '' }}>Active</option>
                                                                    <option value="Inactive" {{ $owners->vehicle->registration_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                                    <option value="Other" {{ $owners->vehicle->registration_status == 'Other' ? 'selected' : '' }}>Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row mb-3">
                                                            <h4>Vehicle Documents</h4>
                                                            <div class="col-md-6">
                                                                <label for="official_receipt_image" class="form-label">Official Receipt Image</label>
                                                                <input type="file" class="form-control" name="official_receipt_image">
                                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->official_receipt_image) }}" alt="official_receipt_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="certificate_of_registration_image" class="form-label">Certificate of Registration Image</label>
                                                                <input type="file" class="form-control" name="certificate_of_registration_image">
                                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->certificate_of_registration_image) }}" alt="certificate_of_registration_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="deed_of_sale_image" class="form-label">Deed of Sale Image</label>
                                                                <input type="file" class="form-control" name="deed_of_sale_image">
                                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->deed_of_sale_image) }}" alt="deed_of_sale_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="authorization_letter_image" class="form-label">Authorization Letter Image</label>
                                                                <input type="file" class="form-control" name="authorization_letter_image">
                                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->authorization_letter_image) }}" alt="authorization_letter_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <h4>Vehicle Images</h4>
                                                            <div class="col-md-6">
                                                                <label for="front_photo" class="form-label">Front Photo</label>
                                                                <input type="file" class="form-control" name="front_photo">
                                                                <img src="{{ asset('storage/images/vehicles/' . $owners->vehicle->front_photo) }}" alt="front_photo" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="side_photo" class="form-label">Side Photo</label>
                                                                <input type="file" class="form-control" name="side_photo">
                                                                <img src="{{ asset('storage/images/vehicles/' . $owners->vehicle->side_photo) }}" alt="side_photo" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                        
                                                <div class="mt-4">
                                                    <div class="text-muted font-size-14">
                                                    <h5>Driver Info</h5>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <label for="dname">Driver Name</label>
                                                                <input type="text" name="dname" id="dname" class="form-control" placeholder="Driver Name" value="{{ $owners->vehicle->driver->driver_name }}" >
                                                            </div>
                                                            <div class="col-md">
                                                                <label for="driver_license_image">Driver's License</label>
                                                                <input type="file" name="driver_license_image" id="driver_license_image" class="form-control" >
                                                                <img src="{{ asset('storage/images/drivers/' . $owners->vehicle->driver->driver_license_image) }}" alt="driver_license_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                        </div>

                                                        <!-- Authorized Driver's Info -->
                                                        <h5 class="mt-4">Authorized Driver's Info</h5>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <label for="adname">Authorized Driver Name</label>
                                                                <input type="text" name="adname" class="form-control" id="adname" placeholder="Authorized Driver Name" value="{{ $owners->vehicle->driver->authorized_driver_name }}" >
                                                            </div>
                                                            <div class="col-md">
                                                                <label for="authorized_driver_license_image">Authorized Driver's License</label>
                                                                <input type="file" name="authorized_driver_license_image" class="form-control" >
                                                                <img src="{{ asset('storage/images/drivers/' . $owners->vehicle->driver->authorized_driver_license_image) }}" alt="authorized_driver_license_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md">
                                                                <label for="adaddress">Authorized Driver Address</label>
                                                                <input type="text" name="adaddress" class="form-control" id="adaddress" placeholder="Authorized Driver Address" value="{{ $owners->vehicle->driver->authorized_driver_address }}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <br>
                                                <div class="modal-footer">
                                                <button type="submit" id="edit_applicant" class="btn btn-primary" id="btn-save">Update Applicant</button>
                                                </div>
                                            </form>

                                                <blockquote class="p-4 border-light border rounded mb-4">
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <i class="bx bxs-quote-alt-left text-dark font-size-24"></i>
                                                        </div>
                                                        <div class="row">
                                                            <!-- Reason for Rejection -->
                                                            <div class="col">
                                                                <h6>Reason for Rejection:</h6>
                                                            </div>
                                                            <!-- Applicant Reason -->
                                                            <div class="col">
                                                                <div class="col">
                                                                    <h6>Applicant:</h6>
                                                                    <p>
                                                                        @if($owners->approval_status == 'Approved')
                                                                        <span class="badge bg-success">{{ $owners->reason ?? 'N/A' }}</span>
                                                                        @elseif($owners->approval_status == 'Rejected')
                                                                        <span class="badge bg-danger">{{ $owners->reason ?? 'N/A' }}</span>
                                                                        @else
                                                                        <span class="badge bg-secondary">Unknown Status</span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <!-- Vehicle Reason -->
                                                            <div class="col">
                                                                <h6>Vehicle:</h6>
                                                                <p>
                                                                    @if($owners->vehicle->approval_status == 'Approved')
                                                                    <span class="badge bg-success badge-lg">{{ $owners->vehicle->reason ?? 'N/A' }}</span>
                                                                    @else($owners->vehicle->approval_status == 'Rejected')
                                                                    <span class="badge bg-danger">{{ $owners->vehicle->reason ?? 'N/A' }}</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <!-- Driver Reason -->
                                                            <div class="col">
                                                                <h6>Driver:</h6>
                                                                <p>
                                                                    @if($owners->vehicle->driver->approval_status == 'Approved')
                                                                    <span class="badge bg-success">{{ $owners->vehicle->driver->reason ?? 'N/A' }}</span>
                                                                    @else($owners->vehicle->driver->approval_status == 'Rejected')
                                                                    <span class="badge bg-danger">{{ $owners->vehicle->driver->reason ?? 'N/A' }}</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </blockquote>

                                                <hr>

                                                </div>
                                            </div>
                                        </div>
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


</body>

</html>
@endsection
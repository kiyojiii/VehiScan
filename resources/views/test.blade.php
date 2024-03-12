<!DOCTYPE html>
<html>

<head>
    <title>Scratch Blade</title>
</head>

<body>

    @foreach ($applicants as $applicant)
    <h3>{{ $applicant->name }}</h3>
    @if (isset($applicantVehicles[$applicant->id]) && count($applicantVehicles[$applicant->id]) > 0)
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Plate Number</th>
                <th class="text-center">Vehicle Model</th>
                <th class="text-center">Date</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applicantVehicles[$applicant->id] as $index => $vehicle)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $vehicle->plate_number }}</td>
                <td class="text-center">{{ $vehicle->vehicle_model }}</td>
                <td class="text-center">{{ $vehicle->created_at->format('F d, Y \a\t h:i A') }}</td>
                <td class="text-center">
                    <a href="#" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>
                    <a href="#" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No vehicles found for this applicant.</p>
    @endif
    @endforeach


</body>

</html>
<div class="table-responsive">
    <table class="table table-bordered align-middle nowrap">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Appointment</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments ?? [] as $appointment)
            <tr>
                <td>{{ ($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration }}</td>
                <td>{{ ($appointment->appointment) }}</td>
                <td>
                    <a href="" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i></a>
                    <a href="" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                    <form action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this template?');"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No Appointments Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {!! $appointments->links() !!}
</div>
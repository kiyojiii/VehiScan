<div id="pagination-container">
<table class="table table-bordered align-middle nowrap">
    <thead>
        <tr>
            <th class="text-center" scope="col">No</th>
            <th class="text-center" scope="col">Role</th>
            <th class="text-center" scope="col">Date Created</th>
            <th class="text-center" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($roles ?? [] as $role)
        <tr>
        <th class="text-center" scope="col">{{ $roles->total() - ($roles->currentPage() - 1) * $roles->perPage() - $loop->iteration + 1 }}</th>
            <td class="text-center" scope="col">{{ $role->name }}</td>
            <td class="text-center" scope="col">{{ $role->created_at->format('M d, Y \a\t h:i A') }}</td>
            <td class="text-center" scope="col">
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm delete-btn delete-btn"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <td colspan="5">
                <span class="text-danger">
                    <strong>No Role Found!</strong>
                </span>
            </td>
        @endforelse
    </tbody>
</table>
{!! $roles->links() !!}
</div>



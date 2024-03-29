<div id="pagination-container">
    <table class="table table-bordered align-middle nowrap">
        <thead>
            <tr>
                <th class="text-center" scope="col">No</th>
                <th class="text-center" scope="col">Permission</th>
                <th class="text-center" scope="col">Date Created</th>
                <th class="text-center" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissions ?? [] as $permission)
            <tr>
                <th class="text-center" scope="col">{{ $permissions->total() - ($permissions->currentPage() - 1) * $permissions->perPage() - $loop->iteration + 1 }}</th>
                <td class="text-center" scope="col">{{ $permission->name }}</td>
                <td class="text-center" scope="col">{{ $permission->created_at->format('M d, Y \a\t h:i A') }}</td>
                <td class="text-center" scope="col">
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <a href="#" id="{{ $permission->id }}" class="btn btn-danger btn-sm delete-btn"><i class="bi-trash"></i></a>
                    </form>
                </td>
            </tr>
            @empty
            <td colspan="5">
                <span class="text-danger">
                    <strong>No Permission Found!</strong>
                </span>
            </td>
            @endforelse
        </tbody>
    </table>
    {!! $permissions->links() !!}
</div>
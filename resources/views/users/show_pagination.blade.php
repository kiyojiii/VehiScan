<table class="table table-nowrap table-hover mb-0">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Blog Title</th>
            <th scope="col">Views</th>
            <th scope="col">Likes</th>
            <th scope="col">Comments</th>
        </tr>
    </thead>
    <tbody>
        @forelse($userTemplates as $index => $template)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>
                    <h5 class="font-size-13 text-truncate mb-1">
                        <a href="javascript: void(0);" class="text-dark">
                            {!! $template->header ? \Illuminate\Support\Str::limit(strip_tags($template->header), 30, $end='...') : "Blog has no header" !!}
                        </a>
                    </h5>
                    <p class="text-muted mb-0">{{ $template->created_at->format('d M, Y') }}</p>
                </td>
                <td><i class="bi bi-eye align-middle me-1"></i>{{ $template->views }}</td>
                <td><i class="bx bx-like align-middle me-1"></i>{{ $template->likes()->count() }}</td>
                <td><i class="bx bx-comment-dots align-middle me-1"></i>{{ $template->comments()->count() }}</td>
                <td>
                    <div>
                        <a href="{{ route('templates.show', $template->id) }}" class="text-primary">Read more <i class="mdi mdi-arrow-right"></i></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-muted">No posts published.</td>
            </tr>
        @endforelse
        </tbody>

</table>
<div class="mt-4">{!! $userTemplates->links() !!}</div>

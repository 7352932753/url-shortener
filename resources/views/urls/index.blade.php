@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-link me-2"></i>Your Short URLs</h2>
        @if (auth()->user()->canCreateUrls())
            <a href="{{ route('urls.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Create New
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Short URL</th>
                            <th>Original URL</th>
                            <th>Clicks</th>
                            <th>Created</th>
                            <th>Author</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($urls as $url)
                            <tr>
                                <td>
                                    <a href="{{ $url->short_url }}" target="_blank" class="text-decoration-none">
                                        <code class="bg-light p-1 rounded">{{ $url->short_code }}</code>
                                    </a>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;" title="{{ $url->original_url }}">
                                        {{ $url->original_url }}
                                    </div>
                                </td>
                                <td><span class="badge bg-primary">{{ $url->clicks }}</span></td>
                                <td>{{ $url->created_at->format('M d, Y') }}</td>
                                <td>{{ $url->user->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox display-4 mb-3"></i>
                                    <p>No URLs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $urls->links() }}
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
                </div>
                <div class="card-body">
                    @if (auth()->user()->canCreateUrls())
                        <div class="alert alert-info">
                            <h6><i class="bi bi-star-fill me-2"></i>You can create short URLs!</h6>
                            <a href="{{ route('urls.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Create Short URL
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h6><i class="bi bi-info-circle me-2"></i>Read-only access</h6>
                            <p>Your role ({{ ucfirst(auth()->user()->role) }}) can only view URLs.</p>
                        </div>
                    @endif

                    @if (in_array(auth()->user()->role, ['superadmin', 'admin']))
                        <a href="{{ route('invitations.create') }}" class="btn btn-outline-success">
                            <i class="bi bi-person-plus me-2"></i>Invite Users
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('urls.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-list-ul me-2"></i>View Your URLs
            </a>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="bi bi-link-45deg me-2"></i>Create Short URL</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('urls.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Original URL</label>
                            <input type="url" name="original_url"
                                class="form-control @error('original_url') is-invalid @enderror"
                                value="{{ old('original_url') }}" required>
                            @error('original_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-magic me-2"></i>Shorten URL
                            </button>
                            <a href="{{ route('urls.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

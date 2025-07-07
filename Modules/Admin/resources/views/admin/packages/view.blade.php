@extends('admin::admin.layouts.master')

@section('title', 'Package Settings')
@section('page-title', 'Package Settings')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Manage Packages</li>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach($packages as $route => $displayName)
        @php
            $info = config('constants.package_info.' . $route);
            // For demo, let's assume all are installed. You can adjust this logic.
            $installed = true;
        @endphp
        <div class="col-md-6 mb-4">
            <div class="card position-relative">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        {{ $displayName }}
                        <span class="badge badge-pill badge-{{ $installed ? 'success' : 'danger' }} float-right" style="font-size: 0.9em;">
                            {{ $installed ? 'Installed' : 'Not Installed' }}
                        </span>
                    </h5>
                    <p class="card-text">
                        {{ $info['description'] ?? 'No description available.' }}
                    </p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
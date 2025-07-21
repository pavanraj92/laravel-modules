@extends('admin::admin.layouts.master')

@section('title', 'Roles Management')

@section('page-title', 'Role Details')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.roles.index') }}">Role Manager</a></li>
<li class="breadcrumb-item active" aria-current="page">Role Details</li>
@endsection

@section('content')
<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Role Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <td>{{ ucwords($role->name) ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $role->created_at ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Assigned Permissions</th>
                                    <td>
                                        @if($role->permissions && $role->permissions->count())
                                        <div class="row">
                                            @foreach($role->permissions as $permission)
                                            <div class="col-md-3 mb-2">
                                                <span class="badge bg-secondary text-white p-2">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </span>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <span class="text-muted">No permissions assigned</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End role Content -->
</div>
<!-- End Container fluid  -->
@endsection
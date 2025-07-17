@extends('admin::admin.layouts.master')

@section('title', 'Assign Permissions Management')

@section('page-title', 'Manage Assign Permissions')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Manage Assign Permissions</li>
@endsection

@section('content')
<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Assign Permission Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.roles.assign.permissions.update', $role) }}" method="POST">
                        @csrf
                        <h4 class="p-3" style="background-color: #dee2e633;">
                            Assign Permissions to: <strong>{{ ucfirst($role->name )}}</strong>
                        </h4>

                        @php
                        $permissionGroups = config('permissions.admin.permissions');
                        @endphp

                        @foreach($permissionGroups as $group => $groupPermissions)
                        <div class="form-group p-3 mb-4" style="background-color: #f8f9fa;">
                            <h5 class="mb-3"><b>{{ $group }}</b></h5>

                            @php
                            $chunks = array_chunk($groupPermissions, 2);
                            @endphp

                            @foreach($chunks as $permChunk)
                            <div class="row">
                                @foreach($permChunk as $perm)
                                @php
                                $permission = $permissions->firstWhere('slug', $perm['slug']);
                                if (!$permission) continue;
                                $isChecked = in_array($permission->id, $assignedPermissionIds ?? []);
                                $isDashboard = $perm['slug'] === 'dashboard';
                                @endphp

                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="{{ $permission->id }}"
                                            id="perm_{{ $permission->id }}"
                                            {{ $isChecked ? 'checked' : '' }}
                                            {{ $isDashboard ? 'checked disabled' : '' }}>

                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>

                                        @if($isDashboard)
                                        <input type="hidden" name="permissions[]" value="{{ $permission->id }}">
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Update Permissions</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End assign permission Content -->
</div>
<!-- End Container fluid  -->
@endsection
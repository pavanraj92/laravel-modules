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
                            <div class="d-flex ml-3">
                                <input type="checkbox" class="form-check-input me-2 group-checkbox" id="group_{{ Str::slug($group) }}" data-group="{{ $group }}">
                                <label for="group_{{ Str::slug($group) }}"><b>{{ $group }}</b></label>
                            </div>

                            @php $chunks = array_chunk($groupPermissions, 2); @endphp

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
                                        <input class="form-check-input permission-checkbox"
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                            id="perm_{{ $permission->id }}"
                                            data-group="{{ $group }}"
                                            data-slug="{{ $permission->slug }}"
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateGroupCheckbox = (group) => {
            const allPermissions = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
            const groupCheckbox = document.querySelector(`.group-checkbox[data-group="${group}"]`);

            // Ignore disabled checkboxes (e.g., dashboard)
            const activePermissions = Array.from(allPermissions).filter(cb => !cb.disabled);
            const allChecked = activePermissions.every(cb => cb.checked);

            groupCheckbox.checked = allChecked;
        };

        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
        const groupCheckboxes = document.querySelectorAll('.group-checkbox');

        // Handle individual permission changes
        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const group = this.dataset.group;
                const slug = this.dataset.slug;

                // Auto-check 'list' when any is selected
                if (slug !== 'list' && this.checked) {
                    const listCheckbox = document.querySelector(`.permission-checkbox[data-group="${group}"][data-slug$="list"]`);
                    if (listCheckbox && !listCheckbox.checked) {
                        listCheckbox.checked = true;
                    }
                }

                // Auto-uncheck all if 'list' is unchecked
                if (slug === 'list' && !this.checked) {
                    document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`).forEach(cb => {
                        if (!cb.disabled) cb.checked = false;
                    });
                }

                updateGroupCheckbox(group);
            });

            // Run once on load
            updateGroupCheckbox(checkbox.dataset.group);
        });

        // Handle group checkbox click
        groupCheckboxes.forEach(groupCheckbox => {
            groupCheckbox.addEventListener('change', function() {
                const group = this.dataset.group;
                const checkState = this.checked;

                document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`).forEach(cb => {
                    if (!cb.disabled) {
                        cb.checked = checkState;
                    }
                });

                // Ensure 'list' permission is checked if any is selected
                if (checkState) {
                    const listCheckbox = document.querySelector(`.permission-checkbox[data-group="${group}"][data-slug$="list"]`);
                    if (listCheckbox && !listCheckbox.checked) {
                        listCheckbox.checked = true;
                    }
                }
            });
        });
    });
</script>
@endpush
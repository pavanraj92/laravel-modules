@extends('admin::admin.layouts.master')

@section('title', 'Settings Management')

@section('page-title', 'Manage Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Manage Settings</li>
@endsection

@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Setting Content -->
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <h4 class="card-title">Filter</h4>
                    <form action="{{ route('admin.settings.index') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control"
                                        value="{{ app('request')->query('keyword') }}" placeholder="Enter title">                                   
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" form="filterForm" class="btn btn-primary mb-3">Filter</button>
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary mb-3">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @admincan('settings_manager_create')
                        <div class="text-right">
                            <a href="{{ route('admin.settings.create') }}" class="btn btn-primary mb-3">Create New Setting</a>
                        </div>
                        @endadmincan

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($settings) && $settings->count() > 0)
                                        @php
                                            $i = ($settings->currentPage() - 1) * $settings->perPage() + 1;
                                        @endphp
                                        @foreach ($settings as $setting)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{ $setting->title ?? '' }}</td>
                                                <td>{{ $setting->slug ?? '' }}</td>
                                                <td>
                                                    {{ $setting->created_at
                                                        ? $setting->created_at->format(config('GET.admin_date_time_format') ?? 'Y-m-d H:i:s')
                                                        : '—' }}
                                                </td>
                                                <td>
                                                    @admincan('settings_manager_edit')
                                                    <a href="{{ route('admin.settings.edit', $setting) }}"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Edit this record"
                                                        class="btn btn-success btn-sm"><i class="mdi mdi-pencil"></i></a>
                                                    @endadmincan

                                                    @admincan('settings_manager_view')
                                                    <a href="{{ route('admin.settings.show', $setting) }}" 
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="View this record"
                                                        class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i></a>
                                                    @endadmincan
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No settings found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!--pagination move the right side-->
                            @if ($settings->count() > 0)
                                {{ $settings->links('admin::pagination.custom-admin-pagination') }}
                            @endif                        
                            
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- End setting Content -->
    </div>
    <!-- End Container fluid  -->
@endsection

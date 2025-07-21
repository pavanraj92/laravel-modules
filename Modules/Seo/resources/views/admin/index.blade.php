@extends('admin::admin.layouts.master')

@section('title', 'SEO Meta Management')

@section('page-title', 'Seo Manager')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Seo Manager</li>
@endsection

@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start SEO Meta Content -->
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <h4 class="card-title">Filter</h4>
                    <form action="{{ route('admin.seo.index') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="keyword">Keyword</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control"
                                        value="{{ app('request')->query('keyword') }}" placeholder="Enter meta title or model name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="model_name">Model</label>
                                    <select name="model_name" id="model_name" class="form-control select2">
                                        <option value="">All Models</option>
                                        @foreach($modelOptions as $value => $label)
                                            <option value="{{ $value }}" {{ app('request')->query('model_name') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto mt-1 text-right">
                                <div class="form-group">
                                    <label for="created_at">&nbsp;</label>
                                    <button type="submit" form="filterForm" class="btn btn-primary mt-4">Filter</button>
                                    <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary mt-4">Reset</a>
                                </div>
                            </div>
                        </div>                       
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @admincan('seo_manager_create')
                        <div class="text-right">
                            <a href="{{ route('admin.seo.create') }}" class="btn btn-primary mb-3">Create New SEO Meta</a>
                        </div>
                        @endadmincan

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">S. No.</th>
                                        <th>@sortablelink('model_name', 'Model Name', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                        <th scope="col">Model Record ID</th>
                                        <th>@sortablelink('meta_title', 'Meta Title', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                        <th scope="col">Meta Description</th>
                                        <th>@sortablelink('created_at', 'Created At', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($seoMetas) && $seoMetas->count() > 0)
                                        @php
                                            $i = ($seoMetas->currentpage() - 1) * $seoMetas->perpage() + 1;
                                        @endphp
                                        @foreach ($seoMetas as $seoMeta)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{ $seoMeta->model_name }}</td>
                                                <td>{{ $seoMeta->model_record_id }}</td>
                                                <td>{{ Str::limit($seoMeta->meta_title, 50) }}</td>
                                                <td>{{ Str::limit($seoMeta->meta_description, 50) }}</td>
                                                <td>
                                                    {{ $seoMeta->created_at
                                                        ? $seoMeta->created_at->format(config('GET.admin_date_time_format') ?? 'Y-m-d H:i:s')
                                                        : '—' }}
                                                </td>
                                                <td style="width: 10%;">
                                                    @admincan('seo_manager_view')
                                                    <a href="{{ route('admin.seo.show', $seoMeta) }}" 
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="View this record"
                                                        class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i></a>
                                                    @endadmincan
                                                    @admincan('seo_manager_edit')
                                                    <a href="{{ route('admin.seo.edit', $seoMeta) }}"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Edit this record"
                                                        class="btn btn-success btn-sm"><i class="mdi mdi-pencil"></i></a>
                                                    @endadmincan                                                  
                                                    @admincan('seo_manager_delete')
                                                    <a href="javascript:void(0)" 
                                                        data-toggle="tooltip" 
                                                        data-placement="top"
                                                        title="Delete this record" 
                                                        data-url="{{ route('admin.seo.destroy', $seoMeta) }}"
                                                        data-text="Are you sure you want to delete this record?"                                                    
                                                        data-method="DELETE"
                                                        class="btn btn-danger btn-sm delete-record" ><i class="mdi mdi-delete"></i></a>
                                                    @endadmincan
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No SEO meta found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!--pagination move the right side-->
                            @if ($seoMetas->count() > 0)
                                {{ $seoMetas->links('admin::pagination.custom-admin-pagination') }}
                            @endif                        
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End SEO Meta Content -->
    </div>
    <!-- End Container fluid  -->
@endsection

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush

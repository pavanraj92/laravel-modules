@extends('admin::admin.layouts.master')

@section('title', 'Categories Management')

@section('page-title', 'Category Manager')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Category Manager</li>
@endsection

@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start category Content -->
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <h4 class="card-title">Filter</h4>
                    <form action="{{ route('admin.categories.index') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control"
                                        value="{{ app('request')->query('keyword') }}" placeholder="Enter title">                                   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control select2">
                                        <option value="">All</option>
                                        <option value="0" {{ app('request')->query('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                        <option value="1" {{ app('request')->query('status') == '1' ? 'selected' : '' }}>Active</option>
                                    </select>                                   
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" form="filterForm" class="btn btn-primary mb-3">Filter</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @admincan('categories_manager_create')
                        <div class="text-right">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>
                        </div>
                        @endadmincan
                    
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">S. No.</th>
                                        <th scope="col">@sortablelink('title', 'Title', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                        <th scope="col">@sortablelink('parent_category_id', 'Parent Category', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                        <th scope="col">@sortablelink('slug', 'Slug', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                        <th scope="col">@sortablelink('status', 'Status', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                        <th scope="col">@sortablelink('created_at', 'Created At', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($categories) && $categories->count() > 0)
                                        @php
                                            $i = ($categories->currentPage() - 1) * $categories->perPage() + 1;
                                        @endphp
                                        @foreach ($categories as $category)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{ $category->title }}</td>
                                                <td>
                                                    @if($category->parent)
                                                        {{ $category->parent->title }}
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td>{{ $category->slug }}</td>
                                                <td>
                                                    <!-- create update status functionality-->
                                                    @if ($category->status == '1')
                                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top"
                                                            title="Click to change status to inactive"
                                                            data-url="{{ route('admin.categories.updateStatus') }}"
                                                            data-method="POST" data-status="0" data-id="{{ $category->id }}"
                                                            class="btn btn-success btn-sm update-status">Active</a>
                                                    @else
                                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top"
                                                            title="Click to change status to active"
                                                            data-url="{{ route('admin.categories.updateStatus') }}"
                                                            data-method="POST" data-status="1"
                                                            data-id="{{ $category->id }}"
                                                            class="btn btn-warning btn-sm update-status">InActive</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $category->created_at
                                                        ? $category->created_at->format(config('GET.admin_date_time_format') ?? 'Y-m-d H:i:s')
                                                        : '—' }}
                                                </td>
                                                <td>
                                                    @admincan('categories_manager_edit') 
                                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Edit this record"
                                                        class="btn btn-success btn-sm"><i class="mdi mdi-pencil"></i></a>
                                                    @endadmincan
                                                    @admincan('categories_manager_view')
                                                    <a href="{{ route('admin.categories.show', $category) }}" 
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="View this record"
                                                        class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i></a>
                                                    @endadmincan
                                                    @admincan('categories_manager_delete')
                                                    <a href="javascript:void(0)" 
                                                        data-toggle="tooltip" 
                                                        data-placement="top"
                                                        title="Delete this record" 
                                                        data-url="{{ route('admin.categories.destroy', $category) }}"
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
                                            <td colspan="6" class="text-center">No category found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!--pagination move the right side-->
                            @if ($categories->count() > 0)
                                {{ $categories->links('admin::pagination.custom-admin-pagination') }}
                            @endif                        
                            
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- End category Content -->
    </div>
    <!-- End Container fluid  -->
@endsection

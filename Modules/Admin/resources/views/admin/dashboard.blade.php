{{-- filepath: d:\laragon\www\php8.2.0-projects\laravel-modules\Modules\Admin\resources\views\dashboard.blade.php --}}
@extends('admin::admin.layouts.master')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- widgets -->
    <div class="row d-flex align-items-stretch">
        <!-- User Roles with Counts -->
        @foreach($userRoles as $role)
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.users.index', ['type' => $role->slug]) }}" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title">{{ $role->name }}</h4>
                        <div class="my-3">
                            <strong>{{ $role->user_count }}</strong>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

        <!-- Total Categories -->
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.categories.index') }}" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title">Categories</h4>
                        <div class="my-3">
                            <strong>{{ $totalCategories ?? 0 }}</strong>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Enquiries -->
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.enquiries.index') }}" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title">Enquiries</h4>
                        <div class="my-2">
                            <strong>Total: {{ $totalEnquiries ?? 0 }}</strong>
                        </div>
                        <div class="my-1 text-muted" style="font-size: 14px;">
                            <div>New: {{ $totalNew ?? 0 }}</div>
                            <div>Draft: {{ $totalDraft ?? 0 }}</div>
                            <div>Replied On: {{ $totalReply ?? 0 }}</div>
                            <div>Closed: {{ $totalClose ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
    <!-- widgets end -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sales Ratio</h4>
                    <div class="sales ct-charts mt-3"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title m-b-5">Referral Earnings</h5>
                    <h3 class="font-light">$769.08</h3>
                    <div class="m-t-20 text-center">
                        <div id="earnings"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title m-b-0">Users</h4>
                    <h2 class="font-light">35,658 <span class="font-16 text-success font-medium">+23%</span></h2>
                    <div class="m-t-30">
                        <div class="row text-center">
                            <div class="col-6 border-right">
                                <h4 class="m-b-0">58%</h4>
                                <span class="font-14 text-muted">New Users</span>
                            </div>
                            <div class="col-6">
                                <h4 class="m-b-0">42%</h4>
                                <span class="font-14 text-muted">Repeat Users</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Latest Sales</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="border-top-0">NAME</th>
                                <th class="border-top-0">STATUS</th>
                                <th class="border-top-0">DATE</th>
                                <th class="border-top-0">PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td class="txt-oflo">Elite admin</td>
                                <td><span class="label label-success label-rounded">SALE</span> </td>
                                <td class="txt-oflo">April 18, 2017</td>
                                <td><span class="font-medium">$24</span></td>
                            </tr>
                            <tr>

                                <td class="txt-oflo">Real Homes WP Theme</td>
                                <td><span class="label label-info label-rounded">EXTENDED</span></td>
                                <td class="txt-oflo">April 19, 2017</td>
                                <td><span class="font-medium">$1250</span></td>
                            </tr>
                            <tr>

                                <td class="txt-oflo">Ample Admin</td>
                                <td><span class="label label-purple label-rounded">Tax</span></td>
                                <td class="txt-oflo">April 19, 2017</td>
                                <td><span class="font-medium">$1250</span></td>
                            </tr>
                            <tr>

                                <td class="txt-oflo">Medical Pro WP Theme</td>
                                <td><span class="label label-success label-rounded">Sale</span></td>
                                <td class="txt-oflo">April 20, 2017</td>
                                <td><span class="font-medium">-$24</span></td>
                            </tr>
                            <tr>

                                <td class="txt-oflo">Hosting press html</td>
                                <td><span class="label label-success label-rounded">SALE</span></td>
                                <td class="txt-oflo">April 21, 2017</td>
                                <td><span class="font-medium">$24</span></td>
                            </tr>
                            <tr>

                                <td class="txt-oflo">Digital Agency PSD</td>
                                <td><span class="label label-danger label-rounded">Tax</span> </td>
                                <td class="txt-oflo">April 23, 2017</td>
                                <td><span class="font-medium">-$14</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Container fluid  -->
@endsection
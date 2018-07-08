@extends('layouts.main')
@section('content')
<h1 class="page-header">Dashboard</h1>
<div class="row">
    <!-- start -->
    <div class="col-md-12">
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ count($users) }}</div>
                            <div>Users</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- end -->
        <!-- start -->
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-piggy-bank fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">₱ {{ $sales }}</div>
                            <div>Total Sales on active Pins</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- end -->

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>System Logs</h3>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sys_logs as $log)
                        <tr>
                            <td>{{ $log->user->fullName() }}</td>
                            <td>{{ $log->message }}</td>
                            <td>{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.admin-nav')
@endsection
@section('scripts')
    <script>
        $("table").DataTable();
    </script>
@endsection
<!-- Navigation & Others -->
@section('profile')
    <a href="{{ route('adminprofile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
@endsection
<!-- Navigation & Others -->
@section('title')
Admin
@endsection

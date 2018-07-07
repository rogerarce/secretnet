@extends('layouts.main')
@section('content')
<h1 class="page-header">Dashboard</h1>

<div class="row">
    <div class="col-md-3 col-xs-12 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-sun"></i>
                    <b>Direct Referral Bonus</b>
                </h4>
            </div>
            <div class="panel-body">
                <h1>₱ {{ $income_list['direct_referral'] }}</h1>
            </div>
        </div>  
    </div>
    <div class="col-md-3 col-xs-12 col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-gem"></i>
                    <b>Pairing Bonus</b>
                </h4>
            </div>
            <div class="panel-body">
                <h1>₱ {{ $income_list['pairing'] }}</h1>
            </div>
        </div>  
    </div>
    <div class="col-md-3 col-xs-12 col-lg-3">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-hands"></i>
                    <b>Profit Sharing</b>
                </h4>
            </div>
            <div class="panel-body">
                <h1>₱ {{ $income_list['package'] }}</h1>
            </div>
        </div>  
    </div>
    <div class="col-md-3 col-xs-12 col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-piggy-bank"></i>
                    <b>Total Income</b>
                </h4>
            </div>
            <div class="panel-body">
                <h1>₱ {{ $income_list['total_income'] }}</h1>
            </div>
        </div>  
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>System Logs</h4>
            </div>
            <ul class="list-group">
                @foreach ($sys_logs as $log)
                    <li class="list-group-item">
                        <div class="row">
                            <b class="col-md-9">{{ $log->message }}</b>
                            <b class="col-md-3">{{ $log->created_at->diffForHumans() }}</b>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.recruit-nav')
@endsection
@section('title')
Admin
@endsection

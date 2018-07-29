@extends('layouts.main')
@section('content')
<div class="page-header">
    <button class="btn btn-success pull-right" data-toggle="modal" data-target="#upgradeaccount">Upgrade Account</button>
    <h1>Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-6 col-xs-12 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-sun"></i>
                    <b>Direct Referral Bonus</b> </h4>
            </div>
            <div class="panel-body">
                <h1>₱ {{ $income_list['direct_referral'] }}</h1>
            </div>
        </div>  
    </div>
    <div class="col-md-6 col-xs-12 col-lg-6">
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
    <div class="col-md-6 col-xs-12 col-lg-6">
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
    <div class="col-md-6 col-xs-12 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-piggy-bank"></i>
                    <span class="pull-right">
                        <i class="fa fa-arrow-circle-right"></i> <a href="/user/payout">Request Payout</a>
                    </span>
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
    <div class="col-md-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4>Account Summary</h4>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Account Type</td>
                        <td><h4>{{ ucfirst(auth()->user()->accountType->type) }}</h4></td>
                    </tr>
                    <tr>
                        <td>My Downlines</td>
                        <td>{{ $downlines['total'] ? $downlines['total'] : 0 }} Member(s)</td>
                    </tr>
                    <tr>
                        <td>My Left Group</td>
                        <td>{{ $downlines['left'] ? $downlines['left'] : 0 }} Member(s)</td>
                    </tr>
                    <tr>
                        <td>My Right Group</td>
                        <td>{{ $downlines['right'] ? $downlines['right'] : 0 }} Member(s)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-7">
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
    @include('recruit.includes.upgrade')
</div>

@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.recruit-nav')
@endsection
<!-- Navigation & Others -->
@section('profile')
    <a href="{{ route('recruitprofile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
@endsection
<!-- Navigation & Others -->
@section('title')
TheSecretNetwork - {{ auth()->user()->fullName() }}
@endsection

@extends('layouts.main')
@section('content')
<h1 class="page-header">Register Form</h1>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" action="{{ url('admin/account_manager') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <h4>User Information</h4>
                        <hr>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Activation Code</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="activation_code" type="string" value="{{ old('activation_code') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Email</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Firstname</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="first_name" type="string" value="{{ old('first_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Lastname</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="last_name" type="string" value="{{ old('last_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Address</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="address" type="string" value="{{ old('address') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Mobile</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="mobile" type="string" value="{{ old('mobile') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="password" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Referral & Downline Positon Information</h4>
                        <hr>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Upline</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="upline_id" value="{{ old('upline_id') }}">
                                    <option>--select--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Downline Position</label>
                            <div class="col-sm-8">
                                <input type="radio" name="position" value="left"> Left&nbsp;&nbsp;
                                <input type="radio" name="position" value="right"> Right
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Direct Referral 
                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The person that will receive the DR bonus"></i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="direct_referral_id" value="{{ old('direct_referral_id') }}">
                                    <option>--select--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4" for="">Default ProfitShare Value</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="string" name="default_profitshare">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info">Register User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.admin-nav')
@endsection
@section('title')
TheSecretNetwork - {{ auth()->user()->fullName() }}
@endsection
<!-- Navigation & Others -->
@section('profile')
    <a href="{{ route('adminprofile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
@endsection
<!-- Navigation & Others -->

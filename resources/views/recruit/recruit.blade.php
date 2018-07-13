@extends('layouts.main')
@section('content')
<h1 class="page-header">Recruit Form</h1>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('registerrecruit') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <h4>User Information</h4>
                        <hr>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Activation Code</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="activation_code" type="string">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Email</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="email" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Firstname</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="first_name" type="string">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Lastname</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="last_name" type="string">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Address</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="address" type="string">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Mobile</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="mobile" type="string">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="password" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2">Confirm Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="password" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Referral & Downline Positon Information</h4>
                        <hr>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Upline</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="upline_id" id="upline">
                                    <option>--select--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" 
                                            data-left="{{ $user->tree ? $user->tree->left_user_id : 0 }}" 
                                            data-right="{{ $user->tree ? $user->tree->right_user_id : 0 }}">
                                            {{ $user->fullName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Downline Position</label>
                            <div class="col-sm-8">
                                <input type="radio" name="position" value="left" id="left"> Left&nbsp;&nbsp;
                                <input type="radio" name="position" value="right" id="right"> Right
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Direct Referral 
                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="The person that will receive the DR bonus"></i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="direct_referral_id">
                                    <option>--select--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                                    @endforeach
                                </select>
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
    @include('includes.recruit-nav')
@endsection
@section('title')
TheSecretNetwork - {{ auth()->user()->fullName() }}
@endsection
<!-- Navigation & Others -->
@section('profile')
    <a href="{{ route('recruitprofile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#upline").on('change', function() {
                let left_points = $('option:selected', this).attr('data-left');
                let right_points = $('option:selected', this).attr('data-right');
                    
                if (left_points > 0) {
                    $("#left").attr('disabled', true);   
                } else {
                    $("#left").attr('disabled', false);   
                }

                if (right_points > 0) {
                    $("#right").attr('disabled', true);   
                } else {
                    $("#right").attr('disabled', false);   
                }
            })
        });
    </script>
@endsection

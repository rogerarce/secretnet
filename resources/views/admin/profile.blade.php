@extends('layouts.main')
@section('content')
<h1 class="page-header">Profile</h1>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <form action="{{ route('recruitprofileupdate') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">First name:</label>
                        <div><input class="form-control" type="string" disabled value="{{ auth()->user()->first_name }}"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Last name:</label>
                        <div><input class="form-control" type="string" disabled value="{{ auth()->user()->last_name }}"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Email: </label>
                        <div><input class="form-control" type="string" disabled value="{{ auth()->user()->email }}"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Address: </label>
                        <div><input class="form-control" type="string" name="address" value="{{ auth()->user()->address }}"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Mobile: </label>
                        <div><input class="form-control" type="string" name="mobile" value="{{ auth()->user()->mobile }}"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Password: </label>
                        <div><input class="form-control" type="password" name="password"></div>
                    </div>
                    <button class="btn btn-primary">Save Changes</button>
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
    <a href="{{ route('recruitprofile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
@endsection
<!-- Navigation & Others -->

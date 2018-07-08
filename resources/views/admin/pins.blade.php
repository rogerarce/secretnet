@extends('layouts.main')
@section('content')
<div class="page-header">
    <h1>Pins</h1>
</div>

<div class="row" ng-app="adminapp" ng-controller="Pins">
    <form class="form form-inline" ng-submit="generate()">
        <div class="form-group">
            <label for="">* Account Type</label>
            <select id="" class="form-control" name="account_type">
                @foreach ($account_types as $type)
                    <option value="{{ $type->id }}">{{ ucfirst($type->type) }} - {{ $type->price }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">* Upline</label>
            <select id="" class="form-control" name="upline_id">
                <option selected disabled>--select--</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->fullName() }} - {{ $user->email }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">
            Generate Token &nbsp;
            <i class="fa fa-plus"></i>
        </button>
    </form>
    <br />
    <table class="table table-bordered table-hover" id="pinstbl">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pin</th>
                <th>Status</th>
                <th>Type</th>
                <th>Activated By</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="pin in pins track by $index" ng-cloak>
                <td>@{{ pin.id }}</td>
                <td>@{{ pin.pin.toUpperCase() }}</td>
                <td>
                    <span class="label label-success" ng-show="pin.status == 'active'">@{{ pin.status }}</span>
                    <span class="label label-default" ng-show="pin.status == 'inactive'">@{{ pin.status }}</span>
                </td>
                <td>@{{ pin.type.type }}</td>
                <td>@{{ pin.user.email }}</td>
                <td>@{{ pin.created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
    @include('includes.adminjs')
@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.admin-nav')
@endsection
<!-- Navigation & Others -->
@section('profile')
    <a href="{{ route('adminprofile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
@endsection
<!-- Navigation & Others -->
@section('title')
Admin - Pins
@endsection

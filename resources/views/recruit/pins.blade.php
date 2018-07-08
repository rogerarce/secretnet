@extends('layouts.main')
@section('content')
<h1 class="page-header"></h1>
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
<!-- Navigation & Others -->

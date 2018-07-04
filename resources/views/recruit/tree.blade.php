@extends('layouts.main')
@section('content')
<h1 class="page-header">Tree</h1>

<div class="row">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
            <h1><i class="fa fa-user text-info"></i></h1>       
            <b>{{ $user->fullName() }}</b>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-6 text-center">
            @if ($user->tree->left)
                <h1><i class="fa fa-user"></i></h1>       
                <b>{{ $user->tree->left->fullName() }}</b>
            @endif
        </div>
        <div class="col-md-6 text-center">
            @if ($user->tree->right)
                <h1><i class="fa fa-user"></i></h1>       
                <b>{{ $user->tree->right->fullName() }}</b>
            @endif
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="left">
            <div class="col-md-3 text-center">
                @if ($left = $user->tree->left->tree->left)
                <h1><i class="fa fa-user"></i></h1>       
                <b>{{ $left->fullName() }}</b>
                @endif
            </div>
            <div class="col-md-3 text-center">
                @if ($right = $user->tree->left->tree->right)
                <h1><i class="fa fa-user"></i></h1>       
                <b>{{ $right->fullName() }}</b>
                @endif
            </div>
        </div>
        <div class="right">
            <div class="col-md-3 text-center">
                @if ($left = $user->tree->right->tree->left)
                <h1><i class="fa fa-user"></i></h1>       
                <b>{{ $left->fullName() }}</b>
                @endif
            </div>
            <div class="col-md-3 text-center">
                @if ($right = $user->tree->right->tree->right)
                <h1><i class="fa fa-user"></i></h1>       
                <b>{{ $right->fullName() }}</b>
                @endif
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
The Secret Network - Tree
@endsection

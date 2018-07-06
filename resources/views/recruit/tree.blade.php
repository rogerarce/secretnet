@extends('layouts.main')
@section('content')
<h1 class="page-header">Tree</h1>

<div class="row">
    <ol class="breadcrumb">
        @foreach ($breadcrumb as $user)
            <li>
                @if ($loop->last)
                    <span>{{ $user->fullName() }}</span>
                @else
                    <a href="/user/tree?user_id={{$user->id}}">{{ $user->fullName() }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</div>

<div class="row">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
            <h1><i class="fa fa-user text-info"></i></h1>       
            <b>{{ $tree['first']->fullName() }}</b>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-6 text-center">
            @if ($user = $tree['tree']['left'])
                <h1><i class="fa fa-user"></i></h1>       
                <b><a href="/user/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
            @endif
        </div>
        <div class="col-md-6 text-center">
            @if ($user = $tree['tree']['right'])
                <h1><i class="fa fa-user"></i></h1>       
                <b><a href="/user/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
            @endif
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="left">
            <div class="col-md-3 text-center">
                @if ($user = $tree['inner_left']['left'])
                    <h1><i class="fa fa-user"></i></h1>       
                    <b><a href="/user/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                @endif
            </div>
            <div class="col-md-3 text-center">
                @if ($user = $tree['inner_left']['right'])
                    <h1><i class="fa fa-user"></i></h1>       
                    <b><a href="/user/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                @endif
            </div>
        </div>
        <div class="right">
            <div class="col-md-3 text-center">
                @if ($user = $tree['inner_right']['left'])
                    <h1><i class="fa fa-user"></i></h1>       
                    <b><a href="/user/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                @endif
            </div>
            <div class="col-md-3 text-center">
                @if ($user = $tree['inner_right']['right'])
                    <h1><i class="fa fa-user"></i></h1>       
                    <b><a href="/user/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
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

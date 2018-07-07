@extends('layouts.main')
@section('content')
<div class="page-header">
    <h1>Tree</h1>
</div>

<div class="row">
    <ol class="breadcrumb">
        @foreach ($breadcrumb as $user)
            <li>
                @if ($loop->last)
                    <span>{{ $user->fullName() }}</span>
                @else
                    @if ($user)
                        <a href="/admin/tree?user_id={{$user->id}}">{{ $user->fullName() }}</a>
                    @endif
                @endif
            </li>
        @endforeach
    </ol>
</div>

<div class="row">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
            <div class="box {{ $tree['first']->accountType ? $tree['first']->accountType->type : 'diamond' }}">
                <h1><i class="fa fa-user text-info"></i></h1>
                <b>{{ $tree['first']->fullName() }}</b>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-6 text-center">
            @if ($user = $tree['tree']['left'])
                <div class="box {{ $user->accountType->type }}">
                    <h1><i class="fa fa-user"></i></h1>       
                    <b><a href="/admin/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                </div>
            @endif
        </div>
        <div class="col-md-6 text-center">
            @if ($user = $tree['tree']['right'])
                <div class="box {{ $user->accountType->type }}">
                    <h1><i class="fa fa-user"></i></h1>       
                    <b><a href="/admin/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                </div>
            @endif
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="left">
            <div class="col-md-3 text-center">
                @if ($user = $tree['inner_left']['left'])
                    <div class="box {{ $user->accountType->type }}">
                        <h1><i class="fa fa-user"></i></h1>       
                        <b><a href="/admin/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                    </div>
                @endif
            </div>
            <div class="col-md-3 text-center">
                @if ($user = $tree['inner_left']['right'])
                    <div class="box {{ $user->accountType->type }}">
                        <h1><i class="fa fa-user"></i></h1>       
                        <b><a href="/admin/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                    </div>
                @endif
            </div>
        </div>
        <div class="right">
            <div class="col-md-3 text-center">
                @if ($user = $tree['inner_right']['left'])
                    <div class="box {{ $user->accountType->type }}">
                        <h1><i class="fa fa-user"></i></h1>       
                        <b><a href="/admin/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                    </div>
                @endif
            </div>
            <div class="col-md-3 text-center">
                @if ($user = $tree['inner_right']['right'])
                    <div class="box {{ $user->accountType->type }}">
                        <h1><i class="fa fa-user"></i></h1>       
                        <b><a href="/admin/tree?user_id={{ $user->id }}">{{ $user->fullName() }}</a></b>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @include('includes.adminjs')
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.admin-nav')
@endsection
@section('title')
Admin - Tree 
@endsection

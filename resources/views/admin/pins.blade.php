@extends('layouts.main')
@section('content')
<div class="page-header">
    <h1>Pins</h1>
    <button class="btn btn-info"><i class="fa fa-plus"></i></button>
</div>

<div class="row">
    <table class="table table-bordered table-hover" id="pinstbl">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pin</th>
                <th>Status</th>
                <th>Activated By</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pins as $pin)
            <tr>
                <td>{{ $pin->id }}</td>
                <td>{{ strtoupper($pin->pin) }}</td>
                <td>
                    @if ($pin->status === 'active')
                        <span class="label label-success">{{ $pin->status }}</span>
                    @else
                        <span class="label label-default">{{ $pin->status }}</span>
                    @endif
                </td>
                <td>
                    @if ($pin->user_id && $pin->activatedBy())
                        <span>{!! $pin->activatedBy()->first()->email !!}</span>
                    @endif
                </td>
                <td>{{ $pin->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/admin/main.js') }}"></script>
@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.admin-nav')
@endsection
@section('title')
Admin - Pins
@endsection

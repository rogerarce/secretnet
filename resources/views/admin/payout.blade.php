@extends('layouts.main')
@section('content')
<h1 class="page-header">Payout Requests</h1>
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Note</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payouts as $payout)
                <tr>
                    <td>{{ $payout->id }}</td>
                    <td>{{ $payout->amount }}</td>
                    <td>{{ $payout->note }}</td>
                    <td>{{ $payout->created_at->diffForHumans() }}</td>
                    <td>
                        @if ($payout->status == 'pending')
                            <span class="label label-default">{{ $payout->status }}</span>
                        @else 
                            <span class="label label-success">{{ $payout->status }}</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('completepayout', $payout->id) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{ $payout->user->" />
                            <button class="btn btn-sm btn-primary">Completed</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.admin-nav')
@endsection
@section('title')
Admin
@endsection

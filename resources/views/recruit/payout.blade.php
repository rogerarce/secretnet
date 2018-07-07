@extends('layouts.main')
@section('content')
<h1 class="page-header">Payout History</h1>

<!-- Request -->
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel">
            <div class="panel-body">
                <div class="col-sm-10"><h4>You currently have <b>$ {{ money_format("%.2n", $total_income) }}</b> in your account</h4></div>
                <div class="col-sm-2"><button class="btn btn-success" data-toggle="modal" data-target="#payoutrequest">Start a Payout</button></div>
            </div>
        </div>
    </div>
</div>

<!-- Request -->
<div class="row">
    <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Note</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payouts as $payout)
                    <tr>
                        <td>{{ $payout->created_at->toDateTimeString() }}</td>
                        <td>{{ $payout->note }}</td>
                        <td>₱ {{ $payout->amount }}</td>
                        <td>
                            @if ($payout->status == 'pending')
                                <span class="label label-default">{{ $payout->status }}</span>
                            @else
                                <span class="label label-success">{{ $payout->status }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="payoutrequest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Payout Request</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('createpayout') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Amount</label>
                        <div><input class="form-control" type="number" min=1" max="{{ $total_income }}" step="any" name="amount"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Note</label>
                        <div><textarea id="" class="form-control" name="note" cols="30" rows="5"></textarea></div>
                    </div>
                    <button class="btn btn-primary">Send Request</button>
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

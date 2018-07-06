@extends('layouts.main')
@section('content')
<div class="page-header">
    <h1>Sales</h1>
</div>

<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Type</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Sold Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ ucfirst($product->type->type) }}</td>
                <td>{{ money_format("%.2n", $product->type->price) }}</td>
                <td>{{ ucfirst($product->status) }}</td>
                <td>{{ $product->created_at->toDateString() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
    <script>
        $("table").DataTable();
    </script>
@endsection

<!-- Navigation & Others -->
@section('sidenavigation')
    @include('includes.admin-nav')
@endsection
@section('title')
Admin - Pins
@endsection

@extends('layouts.main')
@section('content')
<h1 class="page-header">User List</h1>

<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Account Type</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->fullName() }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->accountType->type) }}</td>
                <td>{{ $user->created_at->toFormattedDateString() }}</td>
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
@section('scripts')
    <script>
        $("table").DataTable()
    </script>
@endsection
@section('title')
Admin
@endsection
<!-- Navigation & Others -->
@section('profile')
    <a href="{{ route('adminprofile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
@endsection
<!-- Navigation & Others -->

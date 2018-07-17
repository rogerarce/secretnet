@extends('layouts.main')
@section('content')
<div ng-app="adminapp" ng-controller="Users">
    <div class="page-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#adduser">Add User</button>
        <h1>User List</h1>
    </div>
    
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
                @verbatim
                <tr ng-repeat="user in users">
                    <td>{{ user.id }}</td>
                    <td>{{ user.first_name }} {{ user.last_name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.created_at }}</td>
                </tr>
                @endverbatim
            </tbody>
        </table>
    </div>
    
    <div id="adduser" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add User</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form ng-submit="addUser()">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <div><input class="form-control" type="email" name="email" ng-model="form.user.email"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Firstname</label>
                                    <div><input class="form-control" type="string" name="firstname" ng-model="form.user.first_name"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Lastname</label>
                                    <div><input class="form-control" type="string" name="lastname" ng-model="form.user.last_name"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <div><input class="form-control" type="string" name="address" ng-model="form.user.address"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Mobile</label>
                                    <div><input class="form-control" type="string" name="mobile" ng-model="form.user.mobile"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <div><input class="form-control" type="password" name="password" ng-model="form.user.password"></div>
                                </div>
                                <button class="btn btn-primary">Add User</button>
                            </div> <!-- col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Activation Code</label>
                                    <div>
                                        <select id="pin" class="form-control" name="pin">
                                            @foreach (App\Models\Pins::where('status', 'inactive')->get() as $pin)
                                            <option value="{{ $pin->id }}">{{ strtoupper($pin->pin) }}-{{ ucfirst($pin->type->type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Upline ID</label>
                                    <div>
                                        <select id="uplineid" class="form-control" name="upline_id">
                                            @foreach (App\Models\User::where('user_type', 'customer')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Downline Position</label>
                                    <div>
                                        <input type="radio" name="position" value="left"> Left &nbsp;&nbsp;
                                        <input type="radio" name="position" value="right"> Right
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Profit Sharing</label>
                                    <div>
                                        <input type="checkbox" name="profitshare" value="max"> Max Profit Sharing &nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Direct Referral</label>
                                    <div>
                                        <select id="directref" class="form-control" name="direct_referral_id">
                                            @foreach (App\Models\User::where('user_type', 'customer')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ asset('js/admin/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/controller/user.controller.js') }}" type="text/javascript"></script>
@endsection
@section('title')
Admin
@endsection
<!-- Navigation & Others -->
@section('profile')
    <a href="{{ route('adminprofile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
@endsection
<!-- Navigation & Others -->

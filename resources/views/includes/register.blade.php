<form id="registerform" class="form-horizontal" action="{{ route('register') }}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="">Activation Code</label>
                <input class="form-control" type="string" name="activation_code" value="{{ old('activation_code') }}">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input class="form-control" type="password" name="password">
            </div>
            <div class="form-group">
                <label for="">First Name</label>
                <input class="form-control" type="string" name="first_name" value="{{ old('first_name') }}">
            </div>
            <div class="form-group">
                <label for="">Last Name</label>
                <input class="form-control" type="string" name="last_name" value="{{ old('last_name') }}">
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="">Address</label>
                <input class="form-control" type="string" name="address" value="{{ old('address') }}">
            </div>
            <div class="form-group">
                <label for="">Mobile #</label>
                <input class="form-control" type="string" name="mobile" value="{{ old('mobile') }}">
            </div>
            <div class="form-group">
                <label for="">Account Type</label>
                <select id="user_type" class="form-control" name="account_type" disabled>
                    <option selected disabled>--select--</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button id="signup" class="btn btn-info">Signup</button>
        <a href="{{ url('/') }}">Login</a>
    </div>
</form>

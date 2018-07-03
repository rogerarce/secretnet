<form id="registerform" class="form-horizontal" action="{{ route('register') }}" method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="">Activation Code</label>
        <input class="form-control" type="string" name="activation_code">
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input class="form-control" type="email" name="email">
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input class="form-control" type="password" name="password">
    </div>
    <div class="form-group">
        <label for="">First Name</label>
        <input class="form-control" type="string" name="first_name">
    </div>
    <div class="form-group">
        <label for="">Last Name</label>
        <input class="form-control" type="string" name="last_name">
    </div>
    <div class="form-group">
        <label for="">Address</label>
        <input class="form-control" type="string" name="address">
    </div>
    <div class="form-group">
        <label for="">Mobile #</label>
        <input class="form-control" type="string" name="mobile">
    </div>
    <div class="form-group">
        <button class="btn btn-info">Signup</button>
        <a href="javascript:void(0)" id="btnlogin">Login</a>
    </div>
</form>

<form id="loginform" class="form-horizontal hidden" action="{{ route('login') }}" method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="">Email</label>
        <input class="form-control" type="email" name="email">
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input class="form-control" type="password" name="password">
    </div>
    <div class="form-group">
        <button class="btn btn-info">Login</button>
        <a href="javascript:void(0)" id="btnregister">Signup</a>
    </div>
</form>
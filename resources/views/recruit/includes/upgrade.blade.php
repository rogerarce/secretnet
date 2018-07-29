<div id="upgradeaccount" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-heading">
                <h3 class="modal-header">Upgrade Account Form</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('upgrade') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Enter Activation Code:</label>
                        <div><input class="form-control" type="text" name="pin" required></div>
                    </div>
                    <div class="form-group">
                        <label for="">Direct Referral <i class="mute">(select name of person who invited you)</i></label>
                        <select id="" class="form-control" name="direct_referral" required>
                            @foreach ($possible_dr as $user)
                            <option value="{{ $user->id }}">{{ $user->fullName() }} - {{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-info">Upgrade Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

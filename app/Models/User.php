<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'address', 'account_type', 'user_type', 'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fullName()
    {
        return strtoupper($this->first_name . ' ' . $this->last_name);
    }

    public function isAdmin()
    {
        return $this->user_type == 'admin';
    }

    public function pin()
    {
        return $this->hasOne(Pins::class, 'id', 'user_id');
    }

    public function tree()
    {
        return $this->hasOne(Tree::class, 'user_id', 'id');
    }

    public function accountType()
    {
        return $this->hasOne(AccountType::class, 'id', 'account_type');
    }
    
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function pairing()
    {
        return $this->hasOne(Pairing::class, 'user_id', 'id');
    }

    public function directReferral()
    {
        return $this->hasOne(DirectReferral::class, 'user_id', 'id');
    }

    public function payout()
    {
        return $this->hasMany(Payout::class, 'id', 'user_id');
    }
}

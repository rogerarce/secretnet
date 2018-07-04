<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $primaryKey = "id";
    
    protected $table = "tree";

    protected $fillable = [
        "position",
        "user_id",
        "left_user_id",
        "right_user_id",
        "direct_referral_id",
    ];

    public function scopeLeft()
    {
        return User::where('id', 'left_user_id')->first();
    } 

    public function scopeRight()
    {
        return User::where('id', 'right_user_id')->first();
    }

    public function left()
    {
        return $this->hasOne(User::class, 'id', 'left_user_id');
    }

    public function right()
    {
        return $this->hasOne(User::class, 'id', 'right_user_id');
    }
}

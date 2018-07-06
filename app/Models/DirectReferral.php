<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirectReferral extends Model
{
    protected $table = "direct_referrals";

    protected $primaryKey = "id";

    protected $fillable = [
        "total_earning",
        "user_id",
    ];
}

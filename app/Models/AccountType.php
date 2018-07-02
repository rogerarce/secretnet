<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $primaryKey = "id";

    protected $table = "account_type";

    protected $fillable = [
        "type",
        "price",
        "pairing_bonus",
        "direct_referral",
        "daily_pairs",
    ];
}

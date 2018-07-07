<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $primaryKey = "id";

    protected $table = "wallets";

    protected $fillable = [
        "max_amount",
        "current_amount",
        "deducted",
        "user_id",
    ];
}

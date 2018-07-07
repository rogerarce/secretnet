<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $table = "payouts";

    protected $primaryKey = "id";

    protected $fillable = [
        "user_id",
        "note",
        "amount",
        "admin_note",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

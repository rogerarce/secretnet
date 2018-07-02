<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pins extends Model
{
    protected $primaryKey = "id";

    protected $table = "pins";

    protected $fillable = [
        "pin",
        "status",
        "user_id",
    ];

    public function activatedBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

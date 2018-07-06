<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = "id";

    protected $table = "logs";

    protected $fillable = [
        "action",
        "message",
        "user_id",
    ];
}

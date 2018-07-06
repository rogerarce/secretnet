<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pairing extends Model
{
    protected $primaryKey = "id";

    protected $table = "pairings";
    
    protected $fillable = [
        "user_id",
        "match_count",
        "total_earned",
        "todays_match_count",
    ];
}

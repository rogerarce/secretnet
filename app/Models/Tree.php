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
    ];
}

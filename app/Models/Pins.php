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
        "account_type_id",
        "assign_to",
    ];

    /**
     * The user of pin code
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Type of Package the pin will be used
     */
    public function type()
    {
        return $this->hasOne(AccountType::class, 'id', 'account_type_id');
    }

    /**
     * The user which the pin is assigned
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }
}

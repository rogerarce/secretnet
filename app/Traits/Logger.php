<?php

namespace App\Traits;

use App\Models\Log as SystemLog;

trait Logger
{
    protected function profit($amount, $type, $user_id)
    {
        SystemLog::create([
            'action' => 'profit',
            'message' => "Received $amount from $type",
            'user_id' => $user_id,
        ]);
    }
}

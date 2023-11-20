<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'user_id',
        'sender_info_id',
        'balance',
        'amount',
        'expired_at',
        'status',
    ];
}

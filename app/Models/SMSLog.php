<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSLog extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'api_key',
        'mobile_number',
        'our_api',
        'our_api_response',
        'status',
        'type',
        'message',
        'customer_response',
        'created_date_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

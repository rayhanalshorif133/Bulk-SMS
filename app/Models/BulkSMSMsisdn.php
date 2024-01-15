<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSMSMsisdn extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulk_s_m_s_file_id',
        'api_key',
        'sender_id',
        'mobile_number',
        'message',
        'status',
        'type',
        'created_date_time',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSMSMsisdn extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulk_s_m_s_file_id',
        'user_id',
        'api_key',
        'sender_id',
        'mobile_number',
        'message',
        'status',
        'sms_count',
        'type',
        'created_date_time',
    ];

    public function bulkSMSFile(){
        return $this->belongsTo(BulkSMSFile::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

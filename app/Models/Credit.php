<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'sender_info_id',
        'fund_id',
        'amount',
        'balance',
        'transaction_id',
        'note',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function senderInfo()
    {
        return $this->belongsTo(SenderInfo::class);
    }

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
    
}

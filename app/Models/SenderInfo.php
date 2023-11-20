<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenderInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_id',
        'api_key',
    ];


    public function getUniqueApiKey()
    {
        $api_key = bin2hex(openssl_random_pseudo_bytes(20));
        $senderInfo = SenderInfo::where('api_key', $api_key)->first();
        if ($senderInfo) {
            return $this->getUniqueApiKey();
        }
        return $api_key;
    }


    function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

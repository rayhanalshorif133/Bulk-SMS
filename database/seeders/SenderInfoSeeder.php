<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SenderInfo;

class SenderInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $senderInfo = new SenderInfo();
        $senderInfo->user_id =  2;
        $senderInfo->sender_id =  $this->generateRandomString(20);
        $senderInfo->api_key =  $senderInfo->getUniqueApiKey();
        $senderInfo->save();

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

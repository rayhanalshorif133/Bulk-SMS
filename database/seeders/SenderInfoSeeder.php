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
        $senderInfo->sender_id =  $senderInfo->generateRandomString(20);
        $senderInfo->api_key =  $senderInfo->getUniqueApiKey();
        $senderInfo->save();

    }
}

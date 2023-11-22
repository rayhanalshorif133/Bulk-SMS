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
        $senderInfo->sender_id =  "8809612436500";
        $senderInfo->api_key =  "C2008076616cf7bb7a6291.47303916";
        $senderInfo->save();

    }
}

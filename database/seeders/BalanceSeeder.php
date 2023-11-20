<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Balance;

class BalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $balance = new Balance();
        $balance->user_id = 1;
        $balance->sender_info_id = 1;
        $balance->balance = 300;
        $balance->amount = 40.20;
        $balance->expired_at = now();
        $balance->save();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Credit;

class CreditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credit = new Credit();
        $credit->user_id = 1;
        $credit->sender_info_id = 1;
        $credit->fund_id = 1;
        $credit->amount = 40.50;
        $credit->balance = 300;
        $credit->transaction_id = $this->generateRandomString(15);
        $credit->note = "something note";
        $credit->save();
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

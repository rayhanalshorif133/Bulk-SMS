<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fund;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fund = new Fund();
        $fund->name = "Bkash";
        $fund->save();

        $fund = new Fund();
        $fund->name = "Nagad";
        $fund->save();

        $fund = new Fund();
        $fund->name = "Rocket";
        $fund->save();
    }
}

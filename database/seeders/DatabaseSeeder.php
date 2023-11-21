<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // SenderInfoSeeder::class,
        // BalanceSeeder::class,
        $this->call([
            UserSeeder::class,
            FundSeeder::class,
            // CreditSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AtmCash;

class ATMCashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AtmCash::insert([

            [
                'currency' => 'AZN',
                'denomination' => 200,
                'count' => 10,
            ],
            [
                'currency' => 'AZN',
                'denomination' => 100,
                'count' => 10,
            ],
            [
                'currency' => 'AZN',
                'denomination' => 50,
                'count' => 10,
            ],
            [
                'currency' => 'AZN',
                'denomination' => 20,
                'count' => 10,
            ],
            [
                'currency' => 'AZN',
                'denomination' => 10,
                'count' => 10,
            ],
            [
                'currency' => 'AZN',
                'denomination' => 5,
                'count' => 10,
            ],
            [
                'currency' => 'USD',
                'denomination' => 100,
                'count' => 10,
            ],
            [
                'currency' => 'USD',
                'denomination' => 50,
                'count' => 10,
            ],
            [
                'currency' => 'USD',
                'denomination' => 20,
                'count' => 10,
            ],
            [
                'currency' => 'USD',
                'denomination' => 10,
                'count' => 10,
            ],
            [
                'currency' => 'USD',
                'denomination' => 5,
                'count' => 10,
            ],

        ]);
    }
}

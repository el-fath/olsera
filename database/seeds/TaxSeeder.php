<?php

use App\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::Insert([
            [
                'name' => 'ppn',
                'rate' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'pph',
                'rate' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

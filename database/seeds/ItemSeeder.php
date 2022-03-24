<?php

use App\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Item::class, 5)->create();
        $data = Item::get();
        foreach ($data as $value) {
            $value->taxes()->sync([1,2]);
        }
    }
}

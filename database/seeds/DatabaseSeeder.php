<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Account::class, 50)->create();
        factory(App\Models\CurrencyRate::class, 300)->create();
    }
}

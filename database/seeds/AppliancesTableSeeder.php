<?php

use Illuminate\Database\Seeder;

class AppliancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\Appliance::class, 10)->create();
    }
}

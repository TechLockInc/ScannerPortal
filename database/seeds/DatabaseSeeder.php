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
        $this->call(AppliancesTableSeeder::class);
        $this->call(RoutesTableSeeder::class);
    }
}

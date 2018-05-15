<?php

use Illuminate\Database\Seeder;

class RouteShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\RouteShip::class,2000)->create();

    }
}

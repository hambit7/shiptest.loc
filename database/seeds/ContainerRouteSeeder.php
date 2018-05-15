<?php

use Illuminate\Database\Seeder;

class ContainerRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ContainerRoute::class, 500)->create();

    }
}

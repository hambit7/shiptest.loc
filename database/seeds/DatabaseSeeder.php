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
         $this->call(UsersTableSeeder::class);
         $this->call(ShipsTableSeeder::class);
         $this->call(RoutesTableSeeder::class);
        $this->call(ContainerRouteSeeder::class);
        $this->call(ContainersTableSeeder::class);
        $this->call(RouteShipSeeder::class);
        $this->call(TrackTableSeeder::class);
         $this->call(RouteTrackSeeder::class);
    }
}

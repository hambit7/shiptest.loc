<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouteShip extends Model
{
    public $timestamps = false;

    public $table = 'route_ship';

    protected  $fillable = ['route_id','ship_id'];
}

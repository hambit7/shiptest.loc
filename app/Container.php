<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $fillable = ['name', 'price', 'status'];

    public $timestamps = false;

    public function routes()
    {
        return $this->belongsToMany('App\Route', 'container_route', 'container_id', 'route_id');
    }
}

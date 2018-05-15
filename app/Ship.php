<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{

    protected $fillable = ['name', 'status'];
    /**
     * routes relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function routes()
    {
        return $this->belongsToMany('App\Route', 'route_ship', 'ship_id', 'route_id');
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['latitude', 'longitude', 'speed', 'timestamp'];

    public $timestamps = false;

    public $table = 'tracks';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function routes()
    {
        return $this->belongsToMany('App\Route', 'route_track', 'track_id', 'route_id');
    }
}

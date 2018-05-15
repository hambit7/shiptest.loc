<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Route extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'total_time',
        'total_distance',
        'average_speed'
    ];


    /**
     * routes relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ships()
    {
        return $this->belongsToMany('App\Ship', 'route_ship', 'route_id', 'ship_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function containers()
    {
        return $this->belongsToMany('App\Container', 'container_route', 'route_id', 'container_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tracks()
    {
        return $this->belongsToMany('App\Track', 'route_track', 'route_id', 'track_id');
    }

    /**
     * @return null
     */
    public  function getTracksFromRedis()
    {
        $data = [];
        if(!is_null($this->getPointsNames())){
            foreach ($this->getPointsNames() as $pointsName) {
                $data['speed'] = $this->getSpeed($pointsName);
                $data['latitude'] = $this->getPoints($pointsName)['latitude'];
                $data['longitude'] = $this->getPoints($pointsName)['longitude'];
                $data['timestamp'] = $this->getTime($pointsName);
                $tracks[] = $data;
                unset($data);
            }
        }
        return $tracks?? null;
    }
    /**
     * @return float
     */
    public function getTotalDistanceOfRoutes(): float
    {
        $distance = 0;
        for ($i = 0; $i < count($pointsNames = $this->getPointsNames()) - 1; $i++) {
            $distance += $this->getDistance($pointsNames, $i);
        }
        return $distance;
    }

    /**
     * @return float
     */
    public function getAverageSpeedOfRoute($speed = 0): float
    {
        $trackKeyName = $this->getPointsNames();
        foreach ($trackKeyName as $name) {
            $speed += $this->getSpeed($name);
        }
        return $speed / count($trackKeyName);
    }

    /**
     * @param array $timeArr
     * @return float
     */
    public function getTotalTimeOfRoute($timeArr = []): float
    {
        $trackKeyName = $this->getPointsNames();
        foreach ($trackKeyName as $key => $name) {
            $timeArr[$key] = strtotime($this->getTime($name));
        }
        return max($timeArr) - min($timeArr);
    }

    /**
     * @return null
     */
    public function getPointsNames()
    {
        return !empty(Redis::ZRANGE("route - " . $this->id, 0, -1)) ? Redis::ZRANGE("route - " . $this->id, 0, -1) : null;
    }


    public function getTime($name)
    {
        return Redis::get("route -" . $this->id . ":" . $name . " - time");
    }

    public function getDistance($pointsNames, $i)
    {
        return Redis::GEODIST("route - " . $this->id, $pointsNames[$i], $pointsNames[$i + 1], "km");
    }

    public function getPoints($pointsNames)
    {
        $points = array_flatten(Redis::GEOPOS("route - " . $this->id, $pointsNames));

        return [
            'latitude' => $points[0],
            'longitude' => $points[1],
        ];
    }

    public function getSpeed($name)
    {
        return Redis::get("route -" . $this->id . ":" . $name . " - speed");
    }
}

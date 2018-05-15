<?php

namespace App\Listeners;

use App\Events\ShipDeliverEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Track;


class ShipDeliverListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle(ShipDeliverEvent $event)
    {
        foreach ($event->ship->routes->all() as $model) {
            if (!is_null($model->getPointsNames())) {
                $model->update(
                    [
                        'total_time' => $model->getTotalTimeOfRoute(),
                        'total_distance' => $model->getTotalDistanceOfRoutes(),
                        'average_speed' => $model->getAverageSpeedOfRoute()
                    ]
                );
            }
            if (!is_null($model->getPointsNames())) {
                foreach ($model->getTracksFromRedis() as $tracks) {
                    Track::create([
                        'latitude' => $tracks['latitude'],
                        'longitude' => $tracks['longitude'],
                        'speed' => $tracks['speed'],
                        'timestamp' => $tracks['timestamp'],
                    ]);
                }
            }
        };
    }
}

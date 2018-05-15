<?php

namespace App\Traits;

use \Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFound;
use App\Container;
use App\Route;
use App\Track;

trait ModelTrait
{

    public function getRoute()
    {
        return (count($this->getRoutesFromSingleShip()) <> 0) ? $this->getRoutesFromSingleShip() : (new Route)->all();
    }

    /**
     * @return mixed
     */
    public function getRoutesFromSingleShip()
    {
        return Route::whereHas('ships', function ($query) {
            $query->where('id', request('shipID'));
        })->get();
    }

    /**
     * @return mixed
     */
    public function getContainer()
    {

        if (!is_null(request('shipID')) && !is_null(request('routeID'))) {

            if (!$this->getSingleRouteFromSingleShip()->isEmpty()) {

                return $this->getContainersFromSingleRoute();
            }
            throw new ModelNotFound;

        } else
            return (new Container)->all();
    }

    /**
     * @return mixed
     */
    public function getSingleRouteFromSingleShip()
    {

        return $this->getRoutesFromSingleShip()->where('id', request('routeID'));

    }

    /**
     * @return mixed
     */
    public function getContainersFromSingleRoute()
    {
        return Container::whereHas('routes', function ($query) {
            $query->where('id', request('routeID'));
        })->get();
    }


    public function getTracksFromSingleRoute()
    {
        return Track::whereHas('routes', function ($query) {
            $query->where('id', request('routeID'));
        })->get();
    }

    /**
     * @return Track[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTrack()
    {
        if (!is_null(request('shipID')) && !is_null(request('routeID'))) {

            if (!$this->getSingleRouteFromSingleShip()->isEmpty()) {

                return $this->getTracksFromSingleRoute();
            }

            throw new ModelNotFound;

        } else
            return (new Track)->all();
    }
}
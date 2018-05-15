<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrackResource;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\TrackRequest;
use App\Extensions\GPXLoader;
use Illuminate\Support\Facades\Redis;
use App\Ship;

class TrackController extends ApiController
{
    const IS_STANDING = 0;
    const IS_DEPARTURE = 1;
    const IS_ARRIVED = 2;

    public $resource;
    public $model;

    public function __construct()
    {
        $this->model = $this->getTrack();

        $this->resource = new  TrackResource($this->model);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrackRequest $request)
    {
        $ship = Ship::findOrFail(request('shipID'));
        if($ship->status == self::IS_DEPARTURE){
            return Response::json([
                "error" => 'Cannot add a new track to this route (ship)!'
            ], 201);
        }
        $fileName = "route_" . request('routeID') . '.' . $request->file('fileGpx')->getClientOriginalExtension();
        $request->fileGpx->storeAs('filesGpx', $fileName);

        $gpxLoader = new GPXLoader\GPXLoader($request->fileGpx);

        Redis::pipeline(function ($pipe) use ($gpxLoader) {
            foreach ($gpxLoader->getPoints() as $key => $point) {
                $pipe->geoadd("route - " . request('routeID'), $point->getLatitude(), $point->getLongitude(), "track:" . $key);
                $pipe->set("route -" . request('routeID') . ":track:" . $key . " - speed", $point->getSpeedTrack());
                $pipe->set("route -" . request('routeID') . ":track:" . $key . " - time", $point->getTime());
            }
        });
        return Response::json([
            "success" => 'Created!'
        ], 201);

    }
}

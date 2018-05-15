<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use App\Http\Requests\RouteRequest;
use App\Http\Resources\RouteResource;
use App\RouteShip;
use App\Route;

class RouteController extends ApiController
{

    public function __construct()
    {

        $this->model =  $this->getRoute();

        $this->resource = new  RouteResource($this->model);

    }

    /**
     * @param RouteRequest $request
     * @return mixed
     */
    public function store(RouteRequest $request)
    {

        $model = new Route;

        $model->fill
        ([
            'total_time' => $request->total_time,
            'total_distance' => $request->total_distance,
            'average_speed' => $request->average_speed
        ])
            ->save();

        if (!is_null(request('shipID'))) {
            $relation = new RouteShip;
            $relation->fill(
                [
                    'route_id' => $model->id,
                    'ship_id' => request('shipID')
                ]
            )
                ->save();
        }

        return Response::json([
            "success" => "Created"
        ], 201);
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request $request
//     * @param  int $id
//     * @return \Illuminate\Http\Response
//     */

    public function update(RouteRequest $request, $id)
    {
        $model = $this->model->where('id', $id)->first();

        if (!is_null($model)) {

            $model->update(
                [
                    'total_time' => $request->total_time,
                    'total_distance' => $request->total_distance,
                    'average_speed' => $request->average_speed
                ]
            );
            return Response::json([
                'success' => 'Record updated!'
            ], 201);
        }
        return Response::json([
            'error' => 'Record not found'
        ], 404);

    }
}

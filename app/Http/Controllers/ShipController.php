<?php

namespace App\Http\Controllers;

use App\Events\ShipDeliverEvent;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\ShipRequest;
use App\Http\Resources\ShipResource;
use App\Ship;
use App\Http\Requests\ShipStatusRequest;

class ShipController extends ApiController
{

    const IS_DELIVERED = 2;

    public $resource;
    public $model;


    public function __construct()
    {
        $this->model = (new Ship)->all();
        $this->resource = new  ShipResource($this->model);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShipRequest $request)
    {
        //insert into dtabase
        $model = new Ship;

        $model->fill
        ([
            'name' => $request->name,
            'status' => $request->status,
        ])
            ->save();

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
    public function update(ShipRequest $request, $id)
    {
        $model = $this->model->where('id', $id)->first();

        if (!is_null($model)) {
            $model->update(
                [
                    'name' => $request->name,
                    'status' => $request->status
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

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function changeShipStatus(ShipStatusRequest $request, $id)
    {
        $model = $this->model->where('id', $id)->first();
        if (!is_null($model)) {
            $model->update(
                [
                    'status' => $request->status
                ]
            );

            if ($request->status == self::IS_DELIVERED || !$model->routes->isEmpty()) {

                event(new ShipDeliverEvent($model));
            }

            return Response::json([
                'success' => 'Ship status updated!'
            ], 201);
        }
        return Response::json([
            'error' => 'Record not found'
        ], 404);
    }


}

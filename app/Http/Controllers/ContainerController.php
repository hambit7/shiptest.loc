<?php

namespace App\Http\Controllers;

use App\ContainerRoute;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\ContainerRequest;
use App\Http\Resources\ContainerResource;
use App\Container;


class ContainerController extends ApiController
{

    public $resource;
    public $model;

    public function __construct()
    {

        $this->model = $this->getContainer();

        $this->resource = new  ContainerResource($this->model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContainerRequest $request)
    {

        $model = new Container;

        $model->fill
        ([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
        ])
            ->save();

        if (!is_null(request('routeID'))) {
            $relation = new ContainerRoute;
            $relation->fill(
                [
                    'container_id' => $model->id,
                    'route_id' => request('routeID')
                ]
            )
                ->save();
        }

        return Response::json([
            "success" => "Created"
        ], 201);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContainerRequest $request, $id)
    {

        $model = $this->model->where('id', $id)->first();

        if (!is_null($model)) {

            $model->update(
                [
                    'name' => $request->name,
                    'price' => $request->price,
                    'status' => $request->status,
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

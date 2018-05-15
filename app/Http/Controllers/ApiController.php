<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use App\Traits\ModelTrait;

class ApiController extends Controller
{
    public $resource;
    public $model;


    use ModelTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if ($this->model->count() <> 0) {
            return $this->resource::collection($this->model);
        }
        return Response::json([
            'error' => 'Record not found'
        ], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $model = $this->model->where('id', $id);

        if ($model->count() <> 0) {
            return $this->resource::collection($model);
        }
        return Response::json([
            'error' => 'Record not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->model->where('id', $id)->first();

        if (!is_null($model)) {
            $model->delete();
            return Response::json([
                "success" => "Delete"
            ], 200);
        }
        return Response::json([
            'error' => 'Record not found'
        ], 404);
    }

}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Ship;

class RouteResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total_time' => $this->total_time,
            'total_distance' => $this->total_distance,
            'average_speed' => $this->average_speed,
        ];
    }
}

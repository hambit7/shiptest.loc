<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TrackResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
            'latitude' =>$this->latitude,
            'longitude' =>$this->longitude,
            'speed' =>$this->speed,
            'created_at' =>$this->created_at,
            'updated_at' =>$this->updated_at,
        ];
    }
}

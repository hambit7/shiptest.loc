<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\RouteResource;

class ShipResource extends Resource
{
    const IS_STANDING = 0;
    const IS_DEPARTURE = 1;
    const IS_ARRIVED = 2;



    /**
     * return string status value
     * @param $status
     * @return string
     */
    protected function statusRender($status)
    {
        switch ($status) {
            case $this->IS_STANDING:
                return 'standing';
                break;

            case $this->IS_DEPARTURE:
                return 'departure';
                break;

            default:
                return 'arrived';
        }
    }

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
            'name' => $this->name,
            'status' => $this->statusRender($this->status),
        ];
    }
}

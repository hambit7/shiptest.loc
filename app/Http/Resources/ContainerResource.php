<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ContainerResource extends Resource
{
const IS_LOADING = 0;
const IS_DEPARTURE = 1;
const IS_DELIVERED = 2;

    protected function statusRender($status)
    {
        switch ($status) {
            case $this->IS_LOADING:
                return 'loading';
                break;

            case $this->IS_DEPARTURE:
                return 'departure';
                break;

            default:
                return 'delivered';
        }
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'status' => $this->statusRender($this->status)
        ];
    }
}

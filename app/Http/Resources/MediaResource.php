<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            "type" => $this->type,
            "path" => asset('/products/'.$this->type).'/'.$this->path,
            "thumbnail_path" => $this->thumbnail_path ? asset('/products/'.$this->type).'/'.$this->thumbnail_path : null
        ];
    }
}

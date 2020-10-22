<?php

namespace App\Http\Resources;

use App\Category;
use App\Media;
use App\Merchant;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'merchant' => Merchant::find($this->merchant_id)->business_name,
            'category_id' => Category::find($this->category_id)->name,
            'name' => $this->name,
            'model' => $this->model,
            'description' => $this->description,
            'specification' => $this->specification,
            'other_details' => $this->other_details,
            'price' => $this->price,
            'is_new' => $this->is_new == 1,
            'is_negotiable' => $this->is_negotiable == 1,
            'media' => MediaResource::collection(Media::where('product_id', $this->id)->get())
        ];
    }
}

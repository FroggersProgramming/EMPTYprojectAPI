<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'id'    =>  $this->id,
            'name'  =>  $this->name,
            'value' =>  $this->value,
            'category_id'   =>  $this->category()->first()->id,
            'category_name'   =>  $this->category()->first()->name,
        ];
    }
}

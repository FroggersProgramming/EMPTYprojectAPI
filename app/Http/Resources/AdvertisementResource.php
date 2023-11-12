<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'title'    =>  $this->title,
            'description'    =>  $this->description,
            'location'    =>  $this->location,
            'user'    =>  UserResource::make($this->user),
            'categoryFields'    =>  CategoryFieldResource::collection($this->categoryFields)
        ];
    }
}

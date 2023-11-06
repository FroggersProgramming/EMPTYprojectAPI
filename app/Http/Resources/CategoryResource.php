<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    =>  $this->id,
            'name'  =>  $this->name,
            'category_fields'  =>  CategoryFieldResource::collection($this->categoryFields),
//            'parent_category'   =>  ($this->parent)? [
//                'id'    =>  $this->parent->id,
//                'name'  =>  $this->parent->name,
//            ] : null,
            'children_categories'   =>  ($this->children) ?
                CategoryResource::collection($this->children) : null,
        ];
    }
}

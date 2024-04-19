<?php

namespace App\Http\Resources;

use App\Enums\TransactionType;
use App\Models\Category;
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
        /** @var Category */
        $category = $this;

        return [
            'id' => $category->id,
            'type_id' => $category->type,
            'type' => TransactionType::from($category->type)->name,
            'name' => $category->name,
            'description' => $category->description,
        ];
    }
}

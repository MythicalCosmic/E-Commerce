<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'slug' => $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }
}

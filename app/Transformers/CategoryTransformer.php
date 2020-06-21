<?php

namespace App\Transformers;

use App\Category;
use Illuminate\Support\Facades\Schema;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => (int)$category->id,
            'title' => (string)$category->name,
            'details' => (string)$category->description,
            'createDate' => $category->created_at,
            'lastChange' => $category->updated_at,
            'deletedDate' => isset($category->deleted_at) ? (string)$category->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show', $category->id),
                ],
                [
                    'rel' => 'category.buyers',
                    'href' => route('categories.buyers.index', $category->id),
                ],
                [
                    'rel' => 'category.products',
                    'href' => route('categories.products.index', $category->id),
                ],
                [
                    'rel' => 'category.sellers',
                    'href' => route('categories.sellers.index', $category->id),
                ],
                [
                    'rel' => 'category.transactions',
                    'href' => route('categories.transactions.index', $category->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {

        $attributes = [
            'title' => 'name',
            'details' => 'description',
            'createDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',

        ];
        if (!Schema::hasColumn('categories', $index) and !isset($attributes[$index])) {
            return null;
        }
        return isset($attributes[$index]) ? $attributes[$index] : $index;
    }
}

<?php

namespace App\Transformers;

use App\Product;
use Illuminate\Support\Facades\Schema;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
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
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => (int)$product->id,
            'title' => (string)$product->name,
            'details' => (string)$product->description,
            'stock' => (int)$product->quantity,
            'situation' => (string)$product->status,
            'picture' => url("images/{$product->image}"),
            'seller' => (int)$product->seller_id,
            'createDate' => $product->created_at,
            'lastChange' => $product->updated_at,
            'deletedDate' => isset($product->deleted_at) ? (string) $product->deleted_at : null,
        ];
    }
    public static function originalAttribute($index)
    {

        $attributes = [
            'title' => 'name',
            'details' => 'description',
            'stock' => 'quantity',
            'situation' => 'status',
            'picture' => 'image',
            'seller' => 'seller_id',
            'createDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' =>  'deleted_at',

        ];
        if (!Schema::hasColumn('products',$index) and !isset($attributes[$index])){
            return null;
        }
        return isset($attributes[$index]) ? $attributes[$index] : $index;
    }
}

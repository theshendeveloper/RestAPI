<?php

namespace App\Transformers;

use App\Buyer;
use Illuminate\Support\Facades\Schema;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
     * @param Buyer $buyer
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'id' => (int)$buyer->id,
            'name' => (string)$buyer->name,
            'email' => (string)$buyer->email,
            'verified_at' => (string)$buyer->email_verified_at,
            'createDate' => $buyer->created_at,
            'lastChange' => $buyer->updated_at,
            'deletedDate' => isset($buyer->deleted_at) ? (string) $buyer->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $buyer->id),
                ],
                [
                    'rel' => 'buyer.categories',
                    'href' => route('buyers.categories.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.products',
                    'href' => route('buyers.products.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href' => route('buyers.sellers.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.user',
                    'href' => route('users.show', $buyer->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {

        $attributes = [
            'verified_at' => 'email_verified_at',
            'createDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' =>  'deleted_at',

        ];
        if (!Schema::hasColumn('users',$index) and !isset($attributes[$index])){
            return null;
        }
        return isset($attributes[$index]) ? $attributes[$index] : $index;
    }
    public static function transformedAttribute($index)
    {

        $attributes = [
            'email_verified_at' => 'verified_at',
            'created_at' => 'createDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',

        ];
        if (!Schema::hasColumn('users',$index) and !isset($attributes[$index])){
            return null;
        }
        return isset($attributes[$index]) ? $attributes[$index] : $index;
    }
}

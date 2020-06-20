<?php

namespace App\Transformers;

use App\Transaction;
use Illuminate\Support\Facades\Schema;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
     * @param Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id' => (int)$transaction->id,
            'quantity' => (int)$transaction->quantity,
            'buyer' => (int)$transaction->buyer_id,
            'product' => (int)$transaction->product_id,
            'createDate' => $transaction->created_at,
            'lastChange' => $transaction->updated_at,
            'deletedDate' => isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null,
        ];
    }
    public static function originalAttribute($index)
    {

        $attributes = [
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
            'createDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' =>  'deleted_at',

        ];
        if (!Schema::hasColumn('transactions',$index) and !isset($attributes[$index])){
            return null;
        }
        return isset($attributes[$index]) ? $attributes[$index] : $index;
    }
}

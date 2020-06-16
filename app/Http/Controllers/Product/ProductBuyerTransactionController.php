<?php

namespace App\Http\Controllers\Product;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Product $product, User $buyer,Transaction $transaction)
    {
        $request->validate([
           'quantity' => 'required|integer|min:1'
        ]);
        if ($buyer->id == $product->seller_id){
            return $this->errorResponse('The buyer must be different from the seller.',409);
        }
        if (!$product->isAvailable()){
            return $this->errorResponse('The product is not available.',409);
        }
        if ($product->quantity < $request->quantity){
            return $this->errorResponse('The product does not have enough units for this transaction.',409);
        }
        return DB::transaction(function () use ($request,$product,$buyer){
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction,201);
        });
    }

}

<?php

namespace App\Http\Controllers\Seller;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Seller;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $categories = $seller->products()
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->unique('id')
            ->collapse();
        return $this->showAll($categories);
    }

}

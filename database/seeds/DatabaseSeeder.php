<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        $usersQuantity= 100;
        $categoriesQuantity= 10;
        $productsQuantity= 50;
        $transactionsQuantity= 50;
        factory(\App\User::class,$usersQuantity)->create();
        factory(\App\Category::class,$categoriesQuantity)->create();
        factory(\App\Product::class,$productsQuantity)->create()->each(
            function ($product){
                $categories= \App\Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            }
        );
        factory(\App\Transaction::class,$transactionsQuantity)->create();

    }
}

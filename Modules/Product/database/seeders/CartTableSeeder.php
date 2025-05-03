<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Cart;

class CartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(env('IS_DUMMY_DATA')) {
        Cart::Create([
          "product_id" => 1,
          "product_variation_id"=> 1,
          "qty"=> 1,
          "user_id"=> 3,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 1,
          "product_variation_id"=> 1,
          "qty"=> 1,
          "user_id"=> 4,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 1,
          "product_variation_id"=> 1,
          "qty"=> 1,
          "user_id"=> 5,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 1,
          "product_variation_id"=> 1,
          "qty"=> 1,
          "user_id"=> 6,
          "location_id" => 1
        ]);
      }
    }
}

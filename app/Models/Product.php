<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];
    /**
     * Get the offers for the product.
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function getSubTotalPrice($price, $quantity)
    {
        return $price * $quantity;
    }
    public function getProductOffers($product_name)
    {
        $offers = Product::find(1)->with('offers') // check for the date
            ->where('products.name', $product_name)->first()->toArray();
    }

    public function checkProductOffers($product_name, $product_quantity, &$products_cart)
    {
        $total_discounts = array();
        $product_offers = Product::whereHas('offers', function ($q) {
            $q->where('start_date', '<=', date('Y-m-d'));
            $q->where('end_date', '>=', date('Y-m-d'));
        })->with('offers')->where('products.name', $product_name)->get()->toArray();

        if (isset($product_offers[0]['offers'])) {
            foreach ($product_offers[0]['offers'] as $offer) {
                //self discount
                if ($offer['type'] == 0) {
                    //self
                    $total_discounts['details'] = $offer['discounts'] . ' off ' . $product_name . ' is ' . (($product_offers[0]['price'] * $offer['discounts']) * $product_quantity) / 100;
                    $total_discounts['discount'] = (($product_offers[0]['price'] * $offer['discounts']) * $product_quantity) / 100;
                }
                // discount on another item
                if ($offer['type'] == 1) {
                    $product_to = Product::find(1)->where('products.id', $offer['to_product_id'])->first()->toArray();
                    $check_product_exist = array_key_exists($product_to['name'], $products_cart);
                    if ($check_product_exist) {
                        if ($offer['to_product_quantity'] == $products_cart[$product_to['name']]) {
                            $total_discounts['details'] = $offer['discounts'] . ' off ' . $product_name . ' is ' . (($product_offers[0]['price'] * $offer['discounts']) * $product_quantity) / 100;
                            $total_discounts['discount'] = (($product_offers[0]['price'] * $offer['discounts']) * $product_quantity) / 100;
                        }
                    }
                }
                // get offer on the same item
                // if($offer['type'] == 2){
                //     // check for quantity
                //     //akbar 
                //     // a2al
                //     // ysawy
                //     if($offer['from_product_quantity'] == $product_quantity){

                //     } 
                // }
            }
        }
        return $total_discounts;
    }
}

<?php
 
namespace App\Http\Controllers;
 
use App\Models\Product;
use App\Models\Offer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
class CartController extends Controller{
    public $productInfo;
    public $tax = 14;
    public function __construct()
    { 
        $this->productInfo= new \App\Models\Product();
    }
    public function getSubtotal(array $subtotal){
        return array_sum($subtotal);
    }
    
	public function applyTax($subtotal)
	{
		$tax = $subtotal * ($this->tax / 100);
		return  $tax;
    }
    public function getTotalPrice($subtotal, $tax, $discounts){
        return $subtotal + $tax - $discounts;
    }
  public function CalculateInTheCart(Request $request){
      //body raw //{"cart": ["T-shirt", "T-shirt", "Shoes", "Jacket"]}
    $cart_items = $request->input('cart');
    $products_cart = array_count_values($cart_items);
    //$categories = Category::with('images')->get();
    //->offers() not working
    $offers ='';
    $sub_total_discount = $total_discounts = $offers_array= array();
    foreach($products_cart as $product_name => $product_quantity){
        $product = Product::find(1)
                ->where('products.name', $product_name)
                ->first()->toArray();
        $sub_total_discount[] = $this->productInfo->getSubTotalPrice($product['price'], $product_quantity);
        $offers = $this->productInfo->checkProductOffers($product_name, $product_quantity, $products_cart);
        if($offers){
            $offers_array['details'][] = $offers['details'];
            $offers_array['discount'][] = $offers['discount'];
        }
    }
    $calc_subTotal = $this->getSubtotal($sub_total_discount);
    $tax = $this->applyTax($calc_subTotal);
    $total = $this->getTotalPrice($calc_subTotal, $tax, array_sum($offers_array['discount']));
    $result = array('subtotal' => $calc_subTotal,
                    'Taxes' => $tax,
                    'Discounts' => $offers_array['details'],
                    'Total' => $total);
    return response()->json($result,200);

  }
 }

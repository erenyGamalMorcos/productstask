<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model {
    protected $fillable = [
        'type',
        'from_product_id',
        'from_product_quantity',
        'to_product_id',
        'to_product_quantity',
        'discounts',
        'start_date',
        'end_date',
    ];
    /**
     * Get the product that owns the offer.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
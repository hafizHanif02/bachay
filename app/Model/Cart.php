<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = [
        'product_id',
        'price',
        'discount',
    ];

    
    protected $casts = [
        'price' => 'float',
        'discount' => 'float',
        'tax' => 'float',
        'seller_id' => 'integer',
        'quantity' => 'integer',
        'shipping_cost'=>'float'
    ];

    public function cart_shipping(){
        return $this->hasOne(CartShipping::class,'cart_group_id','cart_group_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->where('status', 1);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function all_product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


}

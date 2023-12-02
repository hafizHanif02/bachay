<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = [
        'cart_group_id',
        'customer_id',
        'product_id',
        'product_type',
        'digital_product_type',
        'color',
        'choices',
        'variations',
        'variant',
        'quantity',
        'price',
        'tax',
        'discount',
        'slug',
        'name',
        'thumbnail',
        'seller_id',
        'seller_is',
        'shop_info',
        'shipping_cost',
        'shipping_type',
        'is_guest',

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

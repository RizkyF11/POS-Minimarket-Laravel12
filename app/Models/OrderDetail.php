<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $primaryKey = 'id_detail';
    protected $table = 'order_detail'; 
    protected $fillable = ['id_orders', 'id_product', 'qty', 'harga'];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'id_orders');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'id_product');
    }
}

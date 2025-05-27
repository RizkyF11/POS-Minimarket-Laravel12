<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $primaryKey = 'id_orders';
    protected $fillable = ['invoice', 'customer_id', 'id_user', 'total'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'id_orders');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}

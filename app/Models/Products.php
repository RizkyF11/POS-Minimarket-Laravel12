<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $primaryKey = 'id_product';

    protected $table = 'products';

    protected $fillable = [
         'nama_product','sku', 'stok', 'harga', 'id_category', 'gambar_product'
    ];

    public function categories()
    {
        return $this->hasOne('\App\Models\Categories', 'id_category', 'id_category');
    }
}

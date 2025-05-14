<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public $primaryKey = 'id_category';

    protected $table = 'categories';

    protected $fillable = [
        'nama_kategori', 'deskripsi'
    ];
}

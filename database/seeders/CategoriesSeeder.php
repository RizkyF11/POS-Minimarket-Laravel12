<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'nama_kategori' => 'Makanan',
            'deskripsi' => 'Makanan berat',
        ];
        DB::table('categories')->insert($data);

        $data = [
            'nama_kategori' => 'Minuman',
            'deskripsi' => 'Minuman segar',
        ];
        DB::table('categories')->insert($data);
    }
}

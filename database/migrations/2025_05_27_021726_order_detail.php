<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_detail', function(Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedBigInteger('id_orders');
            $table->unsignedBigInteger('id_product');
            $table->integer('qty');
            $table->integer('harga');
            $table->timestamps();

            $table->foreign('id_orders')->references('id_orders')->on('orders')->onDelete('cascade');
            $table->foreign('id_product')->references('id_product')->on('products')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('product_name');
        $table->decimal('product_price', 8, 2);
        $table->integer('quantity');
        $table->decimal('total', 8, 2);
        $table->text('note')->nullable();
        $table->string('product_image')->nullable();
        $table->timestamps();
    });
}



    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bopos', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // عمود للاسم
            $table->string('imagepath')->nullable(); // عمود لمسار الصورة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bopos');
    }
};

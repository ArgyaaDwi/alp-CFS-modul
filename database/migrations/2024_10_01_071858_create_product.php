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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code');
            $table->text('product_description');
            $table->integer('product_price');
            $table->string('product_image');
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->unsignedBigInteger('category_lubricant_id');
            $table->unsignedBigInteger('sub_category_lubricant_id');
            $table->foreign('category_lubricant_id')->references('id')->on('category_lubricant')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sub_category_lubricant_id')->references('id')->on('sub_category_lubricant')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

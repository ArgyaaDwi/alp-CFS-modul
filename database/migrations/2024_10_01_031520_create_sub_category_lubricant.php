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
        Schema::create('sub_category_lubricant', function (Blueprint $table) {
            $table->id();
            $table->string('sub_category_name');
            $table->text('sub_category_description');
            $table->string('sub_category_code')->unique();
            $table->unsignedBigInteger('category_lubricant_id');
            $table->foreign('category_lubricant_id')->references('id')->on('category_lubricant')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_category_lubricant');
    }
};

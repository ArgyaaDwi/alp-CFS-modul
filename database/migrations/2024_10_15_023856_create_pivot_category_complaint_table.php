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
        Schema::create('pivot_category_complaint', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('category_complaint_id');
            $table->string('other_category_name')->nullable();
            $table->foreign('complaint_id')->references('id')->on('complaints')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_complaint_id')->references('id')->on('category_complaints')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_category_complaint');
    }
};

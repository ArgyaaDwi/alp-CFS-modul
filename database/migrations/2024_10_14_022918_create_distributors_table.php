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
        Schema::create('distributors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_type_id');
            $table->string('company_name');
            $table->string('company_code');
            $table->unsignedBigInteger('company_distributor_id');
            $table->unsignedBigInteger('company_province_id');
            $table->unsignedBigInteger('company_city_id');
            $table->string('company_address');
            $table->string('company_phone');
            $table->string('company_email');
            $table->string('company_website');
            $table->foreign('company_distributor_id')->references('id')->on('main_distributors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('company_type_id')->references('id')->on('company_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('company_province_id')->references('id')->on('province')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('company_city_id')->references('id')->on('city')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributors');
    }
};

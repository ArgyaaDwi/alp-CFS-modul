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
        Schema::create('main_distributors', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_name');
            $table->string('distributor_email');
            $table->string('distributor_code');
            $table->string('distributor_phone');
            $table->string('distributor_address');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_distributors');
    }
};

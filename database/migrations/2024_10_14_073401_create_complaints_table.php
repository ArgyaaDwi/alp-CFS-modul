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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('distributor_id');
            $table->unsignedBigInteger('main_distributor_id');
            $table->text('complaint_title');
            $table->text('complaint_description');
            $table->text('complaint_hopeful_solution');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('main_distributor_id')->references('id')->on('main_distributors')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};

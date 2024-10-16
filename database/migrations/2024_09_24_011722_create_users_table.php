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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('no_telephone');
            $table->string( 'profile_pic')->nullable();
            $table->text('address');
            $table->unsignedBigInteger( 'role_id')->default(1);
            $table->unsignedBigInteger('distributor_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('distributor_id')->references('id')->on('distributor')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean( 'is_active')->default(true);
            $table->boolean('is_verified')->default(false);
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

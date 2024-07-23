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
        Schema::create('role_and_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role');
            $table->unsignedBigInteger('permission');

            $table->foreign('role')->references('role_id')->on('roles')->cascadeOnDelete();            
            $table->foreign('permission')->references('permission_id')->on('permission')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_and_permission');
    }
};

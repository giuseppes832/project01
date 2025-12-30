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
        Schema::table('f_k_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_resource_id')->nullable();
            $table->foreign('fk_resource_id')->references('id')->on('resources');
            $table->unsignedBigInteger('fk_field_id')->nullable();
            $table->foreign('fk_field_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('f_k_fields', function (Blueprint $table) {
            Schema::dropIfExists('fk_resource_id');
            Schema::dropIfExists('fk_field_id');
        });
    }
};

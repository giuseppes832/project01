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
        Schema::create('html_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('html_form_id')->nullable();
            $table->foreign('html_form_id')->references('id')->on('html_forms');
            $table->unsignedBigInteger('html_tr_id')->nullable();
            $table->foreign('html_tr_id')->references('id')->on('html_trs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('html_tables');
    }
};

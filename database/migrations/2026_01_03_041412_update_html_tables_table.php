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
        Schema::table('html_tables', function (Blueprint $table) {
            $table->unsignedBigInteger('html_table_id')->nullable();
            $table->foreign('html_table_id')->references('id')->on('html_tables');
            $table->unsignedBigInteger('html_select_id')->nullable();
            $table->foreign('html_select_id')->references('id')->on('html_selects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('html_tables', function (Blueprint $table) {
            Schema::dropIfExists('html_table_id');
            Schema::dropIfExists('html_select_id');
        });
    }
};

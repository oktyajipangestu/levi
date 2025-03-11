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
        Schema::table('overtime_transactions', function (Blueprint $table) {
            $table->time('start_time')->nullable()->min('0')->change();
            $table->time('end_time')->nullable()->min('0')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overtime_transactions', function (Blueprint $table) {
             $table->time('start_time')->change();
             $table->time('end_time')->change();
        });
    }
};

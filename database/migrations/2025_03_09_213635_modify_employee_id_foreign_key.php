<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::table('overtime_transactions', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['employee_id']);

            // Tambahkan foreign key baru yang mengacu ke tabel users
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overtime_transactions', function (Blueprint $table) {
            // Hapus foreign key yang mengacu ke tabel users
            $table->dropForeign(['employee_id']);

            // Tambahkan kembali foreign key yang mengacu ke tabel employees
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }
};

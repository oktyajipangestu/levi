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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['annual','big', 'sick', 'maternity', 'important'])->default('annual');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->enum('status_supervisor', ["pending","approve","reject"])->default("pending");
            $table->enum('status_hr', ["pending","approve","reject"])->default("pending");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};

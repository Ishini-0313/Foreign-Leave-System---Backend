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
        Schema::create('office_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('office_id')->unique()->constrained('offices')->cascadeOnDelete();

            $table->foreignId('subject_officer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('check_officer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('recommended_officer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('admin_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Person who performed the assignment
            $table->foreignId('assigned_by')->constrained('users')->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_assignments');
    }
};

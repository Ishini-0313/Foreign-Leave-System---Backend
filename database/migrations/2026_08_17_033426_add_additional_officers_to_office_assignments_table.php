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
        Schema::table('office_assignments', function (Blueprint $table) {
            $table->foreignId('recommended_officer2_id')->nullable()->after('recommended_officer_id')->constrained('users')->nullOnDelete();

            $table->foreignId('recommended_officer3_id')->nullable()->after('recommended_officer2_id')->constrained('users')->nullOnDelete();

            $table->foreignId('chief_sec_id')->nullable()->after('recommended_officer3_id')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('office_assignments', function (Blueprint $table) {
            $table->dropForeign(['recommended_officer2_id']);
            $table->dropForeign(['recommended_officer3_id']);
            $table->dropForeign(['chief_sec_id']);

            $table->dropColumn([
                'recommended_officer2_id',
                'recommended_officer3_id',
                'chief_sec_id',
            ]);
        });
    }
};

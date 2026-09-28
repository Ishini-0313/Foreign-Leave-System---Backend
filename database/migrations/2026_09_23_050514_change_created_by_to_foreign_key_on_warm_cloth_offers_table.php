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
        Schema::table('warm_cloth_offers', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });

        Schema::table('warm_cloth_offers', function (Blueprint $table) {
            // Add created_by as a foreign key to users.id
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warm_cloth_offers', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::table('warm_cloth_offers', function (Blueprint $table) {
            $table->string('created_by')->nullable();
        });
    }
};

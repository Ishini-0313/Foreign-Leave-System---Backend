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
        Schema::create('available_leave_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();

            $table->integer('vacation_months')->default(0);
            $table->integer('vacation_days')->default(0);

            $table->integer('commuted_halfpay_months')->default(0);
            $table->integer('commuted_halfpay_days')->default(0);

            $table->integer('halfpay_months')->default(0);
            $table->integer('halfpay_days')->default(0);

            $table->integer('nopay_months')->default(0);
            $table->integer('nopay_days')->default(0);

            $table->integer('total_months')->default(0);
            $table->integer('total_days')->default(0);

            $table->foreignId('filled_by');

            $table->timestamp('filled_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_leave_infos');
    }
};

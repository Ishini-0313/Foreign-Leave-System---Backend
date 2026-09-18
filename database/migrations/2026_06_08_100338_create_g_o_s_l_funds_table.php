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
        Schema::create('g_o_s_l_funds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();

            $table->boolean('air_travel_selected');
            $table->decimal('air_travel_amount', 12, 2)->nullable();

            $table->boolean('subsistence_selected');
            $table->decimal('subsistence_amount', 12, 2)->nullable();

            $table->boolean('course_fees_selected');
            $table->decimal('course_fees_amount', 12, 2)->nullable();

            $table->boolean('additional_expenses_selected');
            $table->decimal('additional_expenses_amount', 12, 2)->nullable();

            $table->boolean('other_personal_expenses_selected');
            $table->decimal('other_personal_expenses_amount', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g_o_s_l_funds');
    }
};

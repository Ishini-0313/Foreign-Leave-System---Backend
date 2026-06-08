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
            $table->int('application_id');
            $table->string('air_travel');
            $table->string('subsistence');
            $table->string('course_fees');
            $table->string('additional_expenses');
            $table->string('other_personal_expenses');
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

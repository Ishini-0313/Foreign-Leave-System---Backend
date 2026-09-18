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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('departure_time')->nullable()->after('departure_date');
            $table->string('return_time')->nullable()->after('return_date');
            $table->string('provides_other_allowances_that_provide_by_awarding_institution')->nullable()->after('institution_designated_in_that_manner');
            $table->string('amount_to_be_paid')->nullable()->after('provides_other_allowances_that_provide_by_awarding_institution');
            $table->string('have_received_warm_clothing_allowance_within_five_years')->nullable()->after('amount_to_be_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('departure_time');
            $table->dropColumn('return_time');
            $table->dropColumn('provides_other_allowances_that_provide_by_awarding_institution');
            $table->dropColumn('amount_to_be_paid');
            $table->dropColumn('have_received_warm_clothing_allowance_within_five_years');
        });
    }
};

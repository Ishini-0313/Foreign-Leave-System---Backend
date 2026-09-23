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
            $table->string('is_country_in_the_northern_hemisphere')->nullable()->after('have_received_warm_clothing_allowance_within_five_years');
            $table->string('north_latitude')->nullable()->after('is_country_in_the_northern_hemisphere');
            $table->string('is_country_in_the_southern_hemisphere')->nullable()->after('north_latitude');
            $table->string('south_latitude')->nullable()->after('is_country_in_the_southern_hemisphere');
            $table->string('situated_more_than_5000_feet_above_sea_level')->nullable()->after('south_latitude');
            $table->string('height')->nullable()->after('situated_more_than_5000_feet_above_sea_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'is_country_in_the_northern_hemisphere',
                'north_latitude',
                'is_country_in_the_southern_hemisphere',
                'south_latitude',
                'situated_more_than_5000_feet_above_sea_level',
                'height'
            ]);
        });
    }
};

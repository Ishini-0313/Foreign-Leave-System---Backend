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
            $table->string('is_country_in_the_northern_hemisphere')->nullable();
            $table->string('north_latitude')->nullable();
            $table->string('is_country_in_the_southern_hemisphere')->nullable();
            $table->string('south_latitude')->nullable();
            $table->string('situated_more_than_5000_feet_above_sea_level')->nullable();
            $table->string('height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warm_cloth_offers', function (Blueprint $table) {
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

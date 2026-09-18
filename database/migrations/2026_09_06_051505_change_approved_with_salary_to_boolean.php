<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //convert existing string values to 0 or 1
        DB::statement("
            UPDATE applications SET approved_with_salary = 
                CASE
                    WHEN LOWER(approved_with_salary) IN ('true', '1', 'yes') THEN '1'
                    ELSE '0'
                END
        ");

        // change column to boolean
        Schema::table('applications', function (Blueprint $table) {
            $table->boolean('approved_with_salary')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('approved_with_salary')->nullable()->change();
        });
    }
};

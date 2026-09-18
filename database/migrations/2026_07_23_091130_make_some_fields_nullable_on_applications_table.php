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
        Schema::table('applications', function(Blueprint $table){
            $table->string('awarding_agency')->nullable()->change();
            $table->string('foreign_loan_project_particulars_thereof')->nullable()->change();
            $table->string('foreign_fax')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function(Blueprint $table){
            $table->string('awarding_agency')->nullable()->change();
            $table->string('foreign_loan_project_particulars_thereof')->nullable()->change();
            $table->string('foreign_fax')->nullable()->change();
        });
    }
};

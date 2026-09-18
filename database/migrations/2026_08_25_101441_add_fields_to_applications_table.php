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
            $table->string('leave_nature')->nullable()->after('relationship_of_person_meeting_expenditure');
            $table->string('has_letter_of_invitation_for_training')->nullable()->after('leave_nature');
            $table->string('has_approval_letter')->nullable()->after('has_letter_of_invitation_for_training');
            $table->string('has_government_also_been_invited_for_training')->nullable()->after('has_approval_letter');
            $table->string('has_government_nominated_to_participate_in_it')->nullable()->after('has_government_also_been_invited_for_training');
            $table->string('institution_designated_in_that_manner')->nullable()->after('has_government_nominated_to_participate_in_it');
            $table->string('approved_with_salary')->nullable()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('leave_nature');
            $table->dropColumn('has_letter_of_invitation_for_training');
            $table->dropColumn('has_approval_letter');
            $table->dropColumn('has_government_also_been_invited_for_training');
            $table->dropColumn('has_government_nominated_to_participate_in_it');
            $table->dropColumn('institution_designated_in_that_manner');
        });
    }
};

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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->integer('user_id');

            $table->foreignId('workflow_id')->constrained('workflow_templates');
            $table->integer('current_step_id');

            $table->foreignId('current_assigned_user_id')->nullable()->constrained('users');
            $table->foreignId('current_assigned_office_id')->nullable()->constrained('offices');

            $table->string('status');

            $table->Date('approved_at')->nullable();

            $table->string('name');
            $table->string('position');
            $table->foreignId('institute_id')->constrained('offices');
            $table->string('purpose');
            $table->string('nature_of_trip');
            $table->string('leave_category');
            $table->date('commencement_date_of_trainig');
            $table->date('completion_date_of_trainig');
            $table->date('departure_date');
            $table->date('return_date');
            $table->string('country');
            $table->string('signature_path')->nullable();
            $table->string('leave_nature_additional')->nullable();
            $table->string('leave_nature_warm')->nullable();
            $table->string('has_letter_of_invitation_for_training');
            $table->string('has_approval_letter');
            $table->string('has_government_also_been_invited_for_training')->nullable();
            $table->string('has_government_nominated_to_participate_in_it')->nullable();
            $table->string('institution_designated_in_that_manner')->nullable();
            $table->time('departure_time')->nullable();
            $table->time('return_time')->nullable();
            $table->string('provides_other_allowances_that_provide_by_awarding_institution')->nullable();
            $table->string('amount_to_be_paid')->nullable();
            $table->string('have_received_warm_clothing_allowance_within_five_years')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};

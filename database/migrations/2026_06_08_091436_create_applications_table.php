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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->int('user_id');
            $table->int('workflow_id');
            $table->int('current_step_id');
            $table->string('service');
            $table->string('class or grade');
            $table->date('first_appoinment_date');
            $table->date('last_return_date');
            $table->date('leave_start_date');
            $table->date('leave_end_date');
            $table->string('reason_for_leave');
            $table->boolean('is_travel_on_a_pre_paid_ticket');
            $table->string('relationship_of_the_person_sending_it');
            $table->string('cost_maintanence_abroad');
            $table->string('relationship_of_person_meeting_expenditure');
            $table->string('foreign_address');
            $table->date('dob');
            $table->string('arrangement_made_to_cover_duty');
            $table->string('purpose');
            $atble->string('awarding_agency');
            $table->string('expenses_mainly_to_be_met');
            $table->string('foreign_loan/project/particulars_thereof');
            $table->date('commencement_date_of_trainig');
            $table->date('completion_date_of_trainig');
            $table->date('departure_date');
            $table->date('return_date');
            $table->string('country');
            $table->string('foreign_phone');
            $table->string('foreign_fax');
            $table->string('foreign_email');
            $table->boolean('has_previous_trip_report_submitted');
            $table->timestamps('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

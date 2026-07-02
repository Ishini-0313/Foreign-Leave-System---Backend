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
            $table->integer('user_id');

            $table->foreignId('workflow_id')->constrained('workflow_templates');
            $table->integer('current_step_id');

            $table->foreignId('current_assigned_user_id')->nullable()->constrained('users');
            $table->foreignId('current_assigned_office_id')->nullable()->constrained('offices');

            $table->string('status');

            $table->Date('approved_at')->nullable();

            $table->string('name');
            $table->string('position');
            $table->string('service_id');

            $table->date('dob');
            $table->string('nic');

            $table->foreignId('ministry_id')->constrained('offices');
            $table->foreignId('institute_id')->nullable()->constrained('offices');

            $table->string('arrangement_made_to_cover_duty');

            $table->string('purpose');
            $table->string('nature_of_trip');
            $table->string('awarding_agency');
            $table->string('expenses_mainly_to_be_met');
            $table->string('foreign_loan_project_particulars_thereof');
            $table->date('commencement_date_of_trainig');
            $table->date('completion_date_of_trainig');
            $table->date('departure_date');
            $table->date('return_date');
            $table->string('country');
            $table->string('foreign_address');
            $table->string('foreign_phone');
            $table->string('foreign_fax');
            $table->string('foreign_email');
            $table->boolean('has_previous_trip_report_submitted');

            $table->string('name_and_designation');
            $table->string('class_or_grade');
            $table->date('first_appoinment_date');
            $table->date('last_return_date');
            $table->date('leave_start_date');
            $table->date('leave_end_date');
            $table->string('reason_for_leave');
            $table->string('is_travel_on_a_pre_paid_ticket');
            $table->string('relationship_of_the_person_sending_it');
            $table->string('cost_maintanence_abroad');
            $table->string('relationship_of_person_meeting_expenditure');

            $table->string('signature_path')->nullable();
            
            $table->timestamps();
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

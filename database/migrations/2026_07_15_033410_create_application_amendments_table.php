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
        Schema::create('application_amendments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications');
            $table->date('new_leave_start_date');
            $table->date('new_leave_end_date');
            $table->string('reason_for_change');

            $table->foreignId('workflow_id')->constrained('workflow_templates');
            $table->integer('current_step_id');
            $table->foreignId('current_assigned_user_id')->nullable()->constrained('users');
            $table->foreignId('current_assigned_office_id')->nullable()->constrained('offices');
            $table->string('status');
            $table->Date('approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_amendments');
    }
};

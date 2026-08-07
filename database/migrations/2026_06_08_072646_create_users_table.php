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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('nic');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->foreignId('designation_id')->constrained('designations');
            $table->foreignId('office_id')->constrained('offices');
            $table->integer('role_id')->default(1);
            $table->string('username')->unique();
            $table->string('hash_password');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

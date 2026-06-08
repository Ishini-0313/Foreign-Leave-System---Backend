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
            $table->string('designation');
            $table->int('ministry_id');
            $table->int('role_id');
            $table->string('username');
            $table->string('hash_password');
            //$table->string('sign_path');
            $table->timestamps('created_at');
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

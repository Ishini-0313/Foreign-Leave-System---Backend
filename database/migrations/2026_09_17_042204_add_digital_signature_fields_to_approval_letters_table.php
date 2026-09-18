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
        Schema::table('approval_letters', function (Blueprint $table) {
            $table->string('pdf_hash', 64)->nullable()->after('pdf_path');
            $table->longText('digital_signature')->nullable()->after('pdf_hash');
            $table->string('signature_algorithm')->nullable()->after('digital_signature');
            $table->string('signed_by')->nullable()->after('signature_algorithm');
            $table->timestamp('digitally_signed_at')->nullable()->after('signed_by');
            $table->string('public_key_path')->nullable()->after('digitally_signed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approval_letters', function (Blueprint $table) {
            $table->dropColumn([
                'pdf_hash',
                'digital_signature',
                'signature_algorithm',
                'signed_by',
                'digitally_signed_at',
                'public_key_path',
            ]);
        });
    }
};

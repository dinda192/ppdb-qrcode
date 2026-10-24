<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('kartu_keluarga')->nullable()->after('dokumen');
            $table->string('akte_lahir')->nullable()->after('kartu_keluarga');
            $table->string('ktp')->nullable()->after('akte_lahir');
            $table->string('ijazah')->nullable()->after('ktp');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['kartu_keluarga', 'akte_lahir', 'ktp', 'ijazah']);
        });
    }
};

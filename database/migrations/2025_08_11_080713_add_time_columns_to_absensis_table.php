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
        Schema::table('absensis', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('waktu');
            $table->time('jam_masuk')->nullable()->after('tanggal');
            $table->time('jam_keluar')->nullable()->after('jam_masuk');
            $table->string('status_masuk')->nullable()->after('jam_keluar');
            $table->string('status_keluar')->nullable()->after('status_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn(['tanggal', 'jam_masuk', 'jam_keluar', 'status_masuk', 'status_keluar']);
        });
    }
};

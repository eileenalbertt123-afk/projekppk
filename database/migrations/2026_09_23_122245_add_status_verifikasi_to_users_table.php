<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan status verifikasi sementara
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status_verifikasi', [
                'menunggu',
                'diverifikasi',
                'ditolak'
            ])->nullable()->after('status_akun');
        });

        // Semua pengguna yang sudah ada dianggap sudah diverifikasi
        DB::table('users')->update([
            'status_verifikasi' => 'diverifikasi',
        ]);

        // Pengguna baru akan otomatis masuk status menunggu
        DB::statement("
            ALTER TABLE users
            MODIFY status_verifikasi ENUM(
                'menunggu',
                'diverifikasi',
                'ditolak'
            ) NOT NULL DEFAULT 'menunggu'
        ");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi');
        });
    }
};
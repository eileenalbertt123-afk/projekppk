<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan kolom name terlebih dahulu
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 255)->nullable()->after('id');
        });

        // Pindahkan data dari nama ke name
        DB::statement('UPDATE users SET name = nama WHERE name IS NULL');

        // Hapus kolom nama lama
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nama');
        });

        // Tambahkan kolom yang dibutuhkan Laravel/Breeze
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->rememberToken()->after('password');
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    public function down(): void
    {
        // Kembalikan kolom nama
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama', 100)->nullable()->after('id');
        });

        // Pindahkan kembali data name ke nama
        DB::statement('UPDATE users SET nama = name WHERE nama IS NULL');

        // Hapus kolom tambahan Breeze/Laravel
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'email_verified_at',
                'remember_token',
                'updated_at',
            ]);
        });
    }
};
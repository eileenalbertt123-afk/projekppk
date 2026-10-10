<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 50);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('user_type_id')->nullable()->index();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->json('preferences')->nullable();
            $table->string('identifier', 50)->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'petugas', 'pengguna'])->default('pengguna');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->enum('status_akun', ['aktif', 'nonaktif', 'menunggu'])->default('aktif');
            $table->enum('status_verifikasi', ['menunggu', 'diverifikasi', 'ditolak'])->default('menunggu');
            $table->rememberToken();
        });

        Schema::create('registrable_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier', 50)->unique();
            $table->string('name');
            $table->integer('user_type_id')->index();
            $table->boolean('is_registered')->default(false);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('facilities', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 100);
            $table->enum('type', ['ruangan','laboratorium','area_olahraga','peralatan_presentasi','audio_multimedia','lainnya']);
            $table->string('location', 150);
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->json('equipment')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['tersedia','dalam_perbaikan','nonaktif'])->default('tersedia');
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('reservation_code', 20)->unique();
            $table->integer('user_id')->index();
            $table->string('purpose')->nullable();
            $table->text('activity_description')->nullable();
            $table->integer('participant_count')->nullable();
            $table->string('document')->nullable();
            $table->enum('status', ['menunggu','disetujui','ditolak','dibatalkan','selesai'])->default('menunggu');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
        });

        Schema::create('reservation_detail', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('reservation_id')->index();
            $table->integer('facility_id')->index();
        });

        Schema::create('reservation_status_histories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('reservation_id')->index();
            $table->enum('status', ['menunggu','disetujui','ditolak','dibatalkan','selesai']);
            $table->string('reason_category', 100)->nullable();
            $table->text('reason')->nullable();
            $table->integer('changed_by')->nullable()->index();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('report_code', 10)->nullable()->unique();
            $table->integer('user_id')->index();
            $table->integer('facility_id')->index();
            $table->enum('category', ['elektronik_av','struktur_bangunan','mekanikal_utilitas','furnitur','jaringan_it','kebersihan','lainnya']);
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->enum('status', ['baru','diproses','selesai','ditolak'])->default('baru');
            $table->text('resolution_note')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
        });

        Schema::create('report_status_histories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('report_id')->index();
            $table->string('status', 50);
            $table->string('reason_category', 100)->nullable();
            $table->text('reason')->nullable();
            $table->integer('changed_by')->nullable()->index();
            $table->timestamp('created_at')->useCurrent()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_status_histories');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('reservation_status_histories');
        Schema::dropIfExists('reservation_detail');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('registrable_users');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_types');
    }
};
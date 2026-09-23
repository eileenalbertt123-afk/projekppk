<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('facility_access');
    }

    public function down(): void
    {
        Schema::create('facility_access', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_type_id')
                ->constrained('user_types')
                ->cascadeOnDelete();

            $table->foreignId('facility_id')
                ->constrained('facilities')
                ->cascadeOnDelete();

            $table->unique(['user_type_id', 'facility_id']);
        });
    }
};

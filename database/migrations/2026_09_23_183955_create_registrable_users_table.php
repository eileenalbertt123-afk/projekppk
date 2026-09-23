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
        Schema::create('registrable_users', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 50)->unique();
            $table->string('name', 255);
            $table->integer('user_type_id');

            $table->foreign('user_type_id')
                ->references('id')
                ->on('user_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->boolean('is_registered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrable_users');
    }
};
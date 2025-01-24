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
        Schema::create('classification_codes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('title');
            $table->integer('active');
            $table->string('ket_active');
            $table->integer('inactive');
            $table->string('ket_inactive');
            $table->string('keterangan');
            $table->string('security');
            $table->string('hak_akses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classification_codes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\TestStatus\Risky;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classification_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('classification_code_id');
            $table->string('bagian');
            $table->string('nomor_berkas');
            $table->integer('nomor_item_berkas');
            $table->string('uraian_berkas');
            $table->date('date');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->string('perkembangan');
            $table->enum('lokasi', ['rak','shelf', 'box']);
            $table->string('box_number');
            $table->integer('tahun_inactive');
            $table->integer('tahun_musnah');
            $table->string('status');
            $table->string('klasifikasi_box');
            $table->string('status_box');
            $table->string('rak_number');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('classification_code_id')->references('id')->on('classification_codes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classification_tables');
    }
};

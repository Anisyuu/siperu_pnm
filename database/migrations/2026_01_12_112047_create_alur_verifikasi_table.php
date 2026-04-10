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
        Schema::create('alur_verifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pemohon', 25); // Contoh: 'mahasiswa' , 'ormawa'
            $table->integer('urutan');
            $table->string('role_verifikator', 25); // Contoh: 'admin' , 'kasubag'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alur_verifikasi');
    }
};

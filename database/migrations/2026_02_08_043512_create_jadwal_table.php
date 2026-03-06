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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            // FK ke ruangan
            $table->foreignId('ruangan_id')->constrained('ruangan')->onDelete('cascade');
            $table->date('tanggal');
            //opsional (utk tampilan/laporan)
            $table->string('hari', 10)->nullable();
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');

            $table->string('mata_kuliah', 100);
            $table->string('dosen_pengampu', 100);

            $table->text('catatan')->nullable();
            $table->timestamps();

            // percepat cek bentrok berdasarkan ruangan+tanggal
            $table->index(['ruangan_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};

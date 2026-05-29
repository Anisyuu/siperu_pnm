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
            $table->foreignId('ruangan_id')
                ->constrained('ruangan')
                ->onDelete('cascade');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->time('waktu_mulai');
            $table->time('waktu_selesai');

            $table->string('kegiatan', 150);
            $table->string('penanggung_jawab', 100)->nullable();

            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['ruangan_id', 'tanggal_mulai', 'tanggal_selesai']);
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

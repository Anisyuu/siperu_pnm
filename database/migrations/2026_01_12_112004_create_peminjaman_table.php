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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('no_peminjaman', 10)->unique();
            $table->string('pemohon_id', 20);

            $table->foreign('pemohon_id')
                ->references('nomor_induk')
                ->on('user')
                ->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained('ruangan')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->text('kegiatan');
            $table->string('dokumen_bukti')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['ruangan_id', 'tanggal']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};

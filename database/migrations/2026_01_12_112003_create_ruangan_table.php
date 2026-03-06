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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jenis_ruang')->constrained('jenis_ruang')->onDelete('cascade');
            $table->foreignId('id_gedung')->constrained('gedung')->onDelete('cascade');
            $table->integer('lantai');
            $table->string('nomor_ruang', 5);
            $table->string('nama_ruang', 25);
            $table->timestamps();

            $table->unique(['id_gedung', 'lantai', 'nomor_ruang']);

            $table->index(['id_gedung']);
            $table->index(['id_jenis_ruang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};

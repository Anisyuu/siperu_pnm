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
        Schema::create('gedung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kampus_id')->constrained('kampus')->onDelete('cascade');
            $table->string('nama', 25);
            $table->integer('lantai');
            $table->string('slug', 50)->unique()->nullable();
            $table->string('id_user'); // atau sesuai tipe kolomnya
            $table->foreign('id_user')->references('nomor_induk')->on('user')->onDelete('cascade');
            $table->timestamps();
            $table->unique([
                'nama',
                'kampus_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gedung');
    }
};

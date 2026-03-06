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

        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->string('id_user', 20);

            $table->foreign('id_user')
                ->references('nomor_induk')
                ->on('user')
                ->onDelete('cascade');
            $table->foreignId('id_role')->constrained('role')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['id_user', 'id_role']); //tambahan, katanya wajib unik
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};

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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id('idInscripciones');
            $table->year('cicloLectivo');
            $table->enum('estadoInscrip', ['aprobada', 'rechazada', 'pendiente'])->default('pendiente');
            $table->foreignId('idUsuario')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreignId('idMateria')->references('id')->on('materias')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcions');
    }
};

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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('idAsist');
            $table->date('asisFecha');
            $table->boolean('asisJustificada')->default(false);
            $table->enum('estadoAsistencia', ['Presente', 'Ausente', 'Llegada Tarde']);
            $table->foreignId('idInscripcion')->references('idInscripciones')->on('inscripciones')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};

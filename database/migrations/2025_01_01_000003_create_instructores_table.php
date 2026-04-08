<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: instructores
 * Propósito: Perfil de los instructores SENA que supervisan proyectos.
 * Relaciones: usuarios (1:1)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                  ->unique()
                  ->constrained('usuarios', 'id', 'fk_instructores_usuario_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('especialidad', 150)->nullable();
            $table->boolean('activo')->default(true);
            $table->enum('disponibilidad', ['disponible', 'ocupado', 'no_disponible'])
                  ->default('disponible');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructores');
    }
};

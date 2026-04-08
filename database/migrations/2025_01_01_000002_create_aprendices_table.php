<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: aprendices
 * Propósito: Perfil de los aprendices SENA vinculados a un usuario del sistema.
 * Relaciones: usuarios (1:1)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aprendices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                  ->unique()
                  ->constrained('usuarios', 'id', 'fk_aprendices_usuario_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('programa_formacion', 150);            // Programa SENA del aprendiz
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aprendices');
    }
};

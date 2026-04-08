<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: administradores
 * Propósito: Perfil de los administradores del sistema.
 * Relaciones: usuarios (1:1)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                  ->unique()
                  ->constrained('usuarios', 'id', 'fk_administradores_usuario_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};

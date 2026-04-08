<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: usuarios
 * Propósito: Credenciales de autenticación de todos los usuarios del sistema.
 * Relaciones: roles (N:1)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero_documento')->unique();  // Número de cédula o NIT
            $table->string('correo', 100)->unique();
            $table->string('contrasena', 255);
            $table->foreignId('rol_id')
                  ->constrained('roles', 'id', 'fk_usuarios_rol_id')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

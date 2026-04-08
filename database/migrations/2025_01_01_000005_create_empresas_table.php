<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: empresas
 * Propósito: Perfil de empresas que publican proyectos en la bolsa.
 * Relaciones: usuarios (1:1)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                  ->unique()
                  ->constrained('usuarios', 'id', 'fk_empresas_usuario_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->unsignedBigInteger('nit')->unique();           // NIT de la empresa
            $table->string('nombre', 150);                         // Razón social
            $table->string('representante', 100);                  // Representante legal
            $table->string('correo_contacto', 100)->unique();
            $table->string('ubicacion', 255)->nullable();          // Dirección o ciudad
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: proyectos
 * Propósito: Proyectos publicados por empresas en la bolsa SENA.
 * Relaciones:
 *   - empresas    (N:1) → empresa que publica
 *   - usuarios    (N:1) → instructor asignado (nullable)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();

            // FK → empresas.nit (Usamos NIT como referencia según requerimiento previo, o id si referenciamos tabla empresas)
            // Ya que 'empresas' tiene un 'nit' unique, podemos referenciar 'empresas.nit'.
            $table->unsignedBigInteger('empresa_nit');
            $table->foreign('empresa_nit', 'fk_proyectos_empresa_nit')
                  ->references('nit')
                  ->on('empresas')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            // FK → usuarios.id (instructor asignado, opcional)
            $table->foreignId('instructor_usuario_id')
                  ->nullable()
                  ->constrained('usuarios', 'id', 'fk_proyectos_instructor_usuario_id')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();

            $table->string('titulo', 200);
            $table->string('categoria', 100);
            $table->text('descripcion');
            $table->string('requisitos_especificos', 300)->nullable();
            $table->string('habilidades_requeridas', 300)->nullable();
            $table->date('fecha_publicacion');
            $table->unsignedSmallInteger('duracion_estimada_dias');       // Duración en días
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'en_progreso', 'completado'])
                  ->default('pendiente');
            $table->string('imagen_url', 255)->nullable();
            $table->unsignedInteger('numero_postulantes')->default(0);

            // Ubicación geográfica
            $table->string('ubicacion', 255)->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índices para consultas frecuentes
            $table->index('estado');
            $table->index('categoria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};

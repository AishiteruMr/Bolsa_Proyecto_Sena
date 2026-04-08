<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: postulaciones
 * Propósito: Postulaciones de aprendices a proyectos.
 * Relaciones:
 *   - aprendices (N:1)
 *   - proyectos    (N:1)
 * Restricción: un aprendiz solo puede postularse una vez por proyecto.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aprendiz_id')
                  ->constrained('aprendices', 'id', 'fk_postulaciones_aprendiz_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('proyecto_id')
                  ->constrained('proyectos', 'id', 'fk_postulaciones_proyecto_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->timestamp('fecha_postulacion')->useCurrent();
            $table->enum('estado', ['pendiente', 'en_revision', 'aceptada', 'rechazada'])
                  ->default('pendiente');

            $table->timestamps();

            // Un aprendiz no puede postularse dos veces al mismo proyecto
            $table->unique(['aprendiz_id', 'proyecto_id'], 'uq_postulaciones_aprendiz_proyecto');

            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
};

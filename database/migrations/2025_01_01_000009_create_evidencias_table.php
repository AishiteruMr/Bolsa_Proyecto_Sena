<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: evidencias
 * Propósito: Evidencias cargadas por aprendices para revisión del instructor.
 * Relaciones:
 *   - aprendices (N:1)
 *   - etapas      (N:1)
 *   - proyectos    (N:1)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aprendiz_id')
                  ->constrained('aprendices', 'id', 'fk_evidencias_aprendiz_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('etapa_id')
                  ->constrained('etapas', 'id', 'fk_evidencias_etapa_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('proyecto_id')
                  ->constrained('proyectos', 'id', 'fk_evidencias_proyecto_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->string('ruta_archivo', 255);                      // Ruta del archivo cargado
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
            $table->text('comentario_instructor')->nullable();        // Feedback del instructor
            $table->timestamp('fecha_envio')->useCurrent();

            $table->timestamps();

            $table->index(['aprendiz_id', 'proyecto_id'], 'idx_evidencias_aprendiz_proyecto');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};

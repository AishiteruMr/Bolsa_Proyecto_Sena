<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: entregas_etapa
 * Propósito: Entregas formales del aprendiz por etapa del proyecto.
 * Relaciones:
 *   - aprendices (N:1)
 *   - etapas      (N:1)
 *   - proyectos    (N:1)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas_etapa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aprendiz_id')
                  ->constrained('aprendices', 'id', 'fk_entregas_etapa_aprendiz_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('etapa_id')
                  ->constrained('etapas', 'id', 'fk_entregas_etapa_etapa_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('proyecto_id')
                  ->constrained('proyectos', 'id', 'fk_entregas_etapa_proyecto_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->string('url_archivo', 255)->nullable();           // URL del archivo entregado
            $table->text('descripcion')->nullable();                  // Descripción de la entrega
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');

            $table->timestamps();

            $table->index(['aprendiz_id', 'etapa_id', 'proyecto_id'], 'idx_entregas_etapa_contexto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas_etapa');
    }
};

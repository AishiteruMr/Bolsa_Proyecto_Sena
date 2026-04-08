<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: etapas
 * Propósito: Etapas o fases que componen un proyecto.
 * Relaciones:
 *   - proyectos (N:1)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etapas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                  ->constrained('proyectos', 'id', 'fk_etapas_proyecto_id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->unsignedTinyInteger('orden');                  // Orden de la etapa dentro del proyecto
            $table->string('nombre', 200);
            $table->text('descripcion');

            $table->timestamps();

            $table->index('proyecto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etapas');
    }
};

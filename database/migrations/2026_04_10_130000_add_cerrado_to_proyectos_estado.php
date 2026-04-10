<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar 'cerrado' al enum de estado en proyectos
        Schema::table('proyectos', function ($table) {
            // MySQL: modificar el enum
            DB::statement("ALTER TABLE proyectos MODIFY estado ENUM('pendiente', 'aprobado', 'rechazado', 'en_progreso', 'completado', 'cerrado') DEFAULT 'pendiente'");
        });
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE proyectos MODIFY estado ENUM('pendiente', 'aprobado', 'rechazado', 'en_progreso', 'completado') DEFAULT 'pendiente'");
    }
};

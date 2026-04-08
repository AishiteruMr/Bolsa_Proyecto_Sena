<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: roles
 * Propósito: Catálogo de roles del sistema (Aprendiz, Instructor, Empresa, Administrador).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique();               // Nombre interno del rol
            $table->string('nombre_visible', 100)->nullable();    // Nombre mostrado en la interfaz
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

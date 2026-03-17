<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->increments('rol_id');
            $table->string('rol_nombre', 50);
        });

        // Seed inicial
        DB::table('rol')->insert([
            ['rol_id' => 1, 'rol_nombre' => 'Aprendiz'],
            ['rol_id' => 2, 'rol_nombre' => 'Instructor'],
            ['rol_id' => 3, 'rol_nombre' => 'Empresa'],
            ['rol_id' => 4, 'rol_nombre' => 'Administrador'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('rol');
    }
};

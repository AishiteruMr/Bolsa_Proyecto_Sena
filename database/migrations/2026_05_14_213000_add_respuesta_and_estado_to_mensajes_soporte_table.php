<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mensajes_soporte', function (Blueprint $table) {
            $table->text('respuesta')->nullable()->after('mensaje');
            $table->string('estado', 20)->default('pendiente')->after('respuesta');
        });
    }

    public function down(): void
    {
        Schema::table('mensajes_soporte', function (Blueprint $table) {
            $table->dropColumn(['respuesta', 'estado']);
        });
    }
};

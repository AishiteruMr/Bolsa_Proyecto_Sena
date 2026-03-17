<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('usr_id');
            $table->bigInteger('usr_documento')->unique();
            $table->string('usr_correo', 100)->unique();
            $table->string('usr_contrasena', 255);
            $table->unsignedInteger('rol_id');
            $table->timestamp('usr_fecha_creacion')->useCurrent();

            $table->foreign('rol_id')
                  ->references('rol_id')
                  ->on('rol')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};

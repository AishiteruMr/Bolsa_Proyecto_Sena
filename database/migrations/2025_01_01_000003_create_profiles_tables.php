<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── APRENDIZ ──────────────────────────────────────────────────────────────
        Schema::create('aprendiz', function (Blueprint $table) {
            $table->bigIncrements('apr_id');
            $table->unsignedInteger('usr_id')->unique();
            $table->string('apr_nombre', 50);
            $table->string('apr_apellido', 50);
            $table->string('apr_programa', 100);
            $table->boolean('apr_estado')->default(true);

            $table->foreign('usr_id')
                  ->references('usr_id')
                  ->on('usuario')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        // ── INSTRUCTOR ────────────────────────────────────────────────────────────
        Schema::create('instructor', function (Blueprint $table) {
            $table->unsignedInteger('usr_id')->unique();
            $table->string('ins_nombre', 50);
            $table->string('ins_apellido', 50);
            $table->string('ins_especialidad', 100)->nullable();
            $table->boolean('ins_estado')->default(true);
            $table->string('ins_estado_dis', 20)->default('Disponible');

            $table->foreign('usr_id')
                  ->references('usr_id')
                  ->on('usuario')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        // ── ADMINISTRADOR ─────────────────────────────────────────────────────────
        Schema::create('administrador', function (Blueprint $table) {
            $table->increments('adm_id');
            $table->unsignedInteger('usr_id');
            $table->string('adm_nombre', 100);
            $table->string('adm_apellido', 100);
            $table->string('adm_correo', 150)->unique();
            $table->timestamp('adm_fecha_creacion')->useCurrent();
            $table->boolean('adm_estado')->default(true);

            $table->foreign('usr_id')
                  ->references('usr_id')
                  ->on('usuario')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        // ── EMPRESA ───────────────────────────────────────────────────────────────
        Schema::create('empresa', function (Blueprint $table) {
            $table->increments('emp_id');
            $table->unsignedInteger('usr_id')->unique();
            $table->bigInteger('emp_nit')->unique();
            $table->string('emp_nombre', 150);
            $table->string('emp_representante', 100);
            $table->string('emp_correo', 100)->unique();
            $table->string('emp_contrasena', 255);
            $table->boolean('emp_estado')->default(true);

            $table->foreign('usr_id')
                  ->references('usr_id')
                  ->on('usuario')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrador');
        Schema::dropIfExists('instructor');
        Schema::dropIfExists('aprendiz');
        Schema::dropIfExists('empresa');
    }
};

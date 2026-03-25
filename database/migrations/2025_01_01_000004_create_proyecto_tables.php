<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── PROYECTO ──────────────────────────────────────────────────────────────
        Schema::create('proyecto', function (Blueprint $table) {
            $table->increments('pro_id');
            $table->bigInteger('emp_nit');
            $table->string('pro_titulo_proyecto', 200);
            $table->string('pro_categoria', 100);
            $table->string('pro_descripcion', 500);
            $table->string('pro_requisitos_especificos', 200);
            $table->string('pro_habilidades_requerida', 200);
            $table->date('pro_fecha_publi');
            $table->integer('pro_duracion_estimada');
            $table->string('pro_estado', 50)->default('Activo');
            $table->string('pro_imagen_url', 255)->nullable();
            $table->bigInteger('ins_usr_documento')->nullable();

            $table->foreign('emp_nit')
                  ->references('emp_nit')
                  ->on('empresa')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('ins_usr_documento')
                  ->references('usr_documento')
                  ->on('usuario')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });

        // ── POSTULACION ───────────────────────────────────────────────────────────
        Schema::create('postulacion', function (Blueprint $table) {
            $table->increments('pos_id');
            $table->unsignedBigInteger('apr_id');
            $table->unsignedInteger('pro_id');
            $table->dateTime('pos_fecha')->useCurrent();
            $table->string('pos_estado', 50)->default('Pendiente');

            $table->unique(['apr_id', 'pro_id'], 'uq_apr_pro');

            $table->foreign('apr_id')
                  ->references('apr_id')
                  ->on('aprendiz')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('pro_id')
                  ->references('pro_id')
                  ->on('proyecto')
                  ->onUpdate('cascade');
        });

        // ── ETAPA ─────────────────────────────────────────────────────────────────
        Schema::create('etapa', function (Blueprint $table) {
            $table->increments('eta_id');
            $table->unsignedInteger('eta_pro_id');
            $table->integer('eta_orden');
            $table->string('eta_nombre', 200);
            $table->text('eta_descripcion');

            $table->foreign('eta_pro_id')
                  ->references('pro_id')
                  ->on('proyecto')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        // ── EVIDENCIA ─────────────────────────────────────────────────────────────
        Schema::create('evidencia', function (Blueprint $table) {
            $table->increments('evid_id');
            $table->unsignedBigInteger('evid_apr_id');
            $table->unsignedInteger('evid_eta_id');
            $table->unsignedInteger('evid_pro_id');
            $table->string('evid_archivo', 255);
            $table->dateTime('evid_fecha')->useCurrent();
            $table->string('evid_estado', 50)->default('Pendiente');
            $table->text('evid_comentario')->nullable();

            $table->foreign('evid_apr_id')->references('apr_id')->on('aprendiz')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('evid_eta_id')->references('eta_id')->on('etapa')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('evid_pro_id')->references('pro_id')->on('proyecto')->onDelete('cascade')->onUpdate('cascade');
        });

        // ── ENTREGA ETAPA ─────────────────────────────────────────────────────────
        Schema::create('entrega_etapa', function (Blueprint $table) {
            $table->increments('ene_id');
            $table->unsignedBigInteger('ene_apr_id');
            $table->unsignedInteger('ene_eta_id');
            $table->unsignedInteger('ene_pro_id');
            $table->string('ene_archivo_url', 255)->nullable();
            $table->text('ene_descripcion')->nullable();
            $table->dateTime('ene_fecha')->useCurrent();
            $table->string('ene_estado', 20)->default('Pendiente');

            $table->foreign('ene_apr_id')->references('apr_id')->on('aprendiz')->onDelete('cascade');
            $table->foreign('ene_eta_id')->references('eta_id')->on('etapa')->onDelete('cascade');
            $table->foreign('ene_pro_id')->references('pro_id')->on('proyecto')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrega_etapa');
        Schema::dropIfExists('evidencia');
        Schema::dropIfExists('etapa');
        Schema::dropIfExists('postulacion');
        Schema::dropIfExists('proyecto');
    }
};

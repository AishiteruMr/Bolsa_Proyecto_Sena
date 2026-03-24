<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->index('usr_correo');
            $table->index('usr_documento');
        });

        Schema::table('aprendiz', function (Blueprint $table) {
            $table->index('usr_id');
            $table->index('apr_estado');
        });

        Schema::table('instructor', function (Blueprint $table) {
            $table->index('usr_id');
            $table->index('ins_estado');
        });

        Schema::table('empresa', function (Blueprint $table) {
            $table->index('emp_nit');
            $table->index('emp_estado');
            $table->index('usr_id');
        });

        Schema::table('proyecto', function (Blueprint $table) {
            $table->index('emp_nit');
            $table->index('ins_usr_documento');
            $table->index('pro_estado');
            $table->index('pro_categoria');
        });

        Schema::table('postulacion', function (Blueprint $table) {
            $table->index('apr_id');
            $table->index('pro_id');
            $table->index('pos_estado');
        });

        Schema::table('etapa', function (Blueprint $table) {
            $table->index('eta_pro_id');
        });

        Schema::table('evidencia', function (Blueprint $table) {
            $table->index('evid_apr_id');
            $table->index('evid_pro_id');
            $table->index('evid_eta_id');
            $table->index('evid_estado');
        });
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropIndex(['usr_correo']);
            $table->dropIndex(['usr_documento']);
        });

        Schema::table('aprendiz', function (Blueprint $table) {
            $table->dropIndex(['usr_id']);
            $table->dropIndex(['apr_estado']);
        });

        Schema::table('instructor', function (Blueprint $table) {
            $table->dropIndex(['usr_id']);
            $table->dropIndex(['ins_estado']);
        });

        Schema::table('empresa', function (Blueprint $table) {
            $table->dropIndex(['emp_nit']);
            $table->dropIndex(['emp_estado']);
            $table->dropIndex(['usr_id']);
        });

        Schema::table('proyecto', function (Blueprint $table) {
            $table->dropIndex(['emp_nit']);
            $table->dropIndex(['ins_usr_documento']);
            $table->dropIndex(['pro_estado']);
            $table->dropIndex(['pro_categoria']);
        });

        Schema::table('postulacion', function (Blueprint $table) {
            $table->dropIndex(['apr_id']);
            $table->dropIndex(['pro_id']);
            $table->dropIndex(['pos_estado']);
        });

        Schema::table('etapa', function (Blueprint $table) {
            $table->dropIndex(['eta_pro_id']);
        });

        Schema::table('evidencia', function (Blueprint $table) {
            $table->dropIndex(['evid_apr_id']);
            $table->dropIndex(['evid_pro_id']);
            $table->dropIndex(['evid_eta_id']);
            $table->dropIndex(['evid_estado']);
        });
    }
};

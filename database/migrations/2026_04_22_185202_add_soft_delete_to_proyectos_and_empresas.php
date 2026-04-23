<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            if (!Schema::hasColumn('proyectos', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('empresas', function (Blueprint $table) {
            if (!Schema::hasColumn('empresas', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('empresas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
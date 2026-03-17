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
        Schema::table('empresa', function (Blueprint $table) {
            $table->string('emp_ubicacion', 255)->nullable()->after('emp_representante');
            $table->string('emp_departamento', 100)->nullable()->after('emp_ubicacion');
            $table->string('emp_ciudad', 100)->nullable()->after('emp_departamento');
            $table->string('emp_direccion', 255)->nullable()->after('emp_ciudad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->dropColumn(['emp_ubicacion', 'emp_departamento', 'emp_ciudad', 'emp_direccion']);
        });
    }
};

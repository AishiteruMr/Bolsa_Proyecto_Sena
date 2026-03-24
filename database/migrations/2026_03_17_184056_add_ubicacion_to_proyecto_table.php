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
        Schema::table('proyecto', function (Blueprint $table) {
            $table->string('pro_ubicacion', 255)->nullable()->after('pro_categoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyecto', function (Blueprint $table) {
            $table->dropColumn(['pro_ubicacion', 'pro_fecha_finalizacion']);
        });
    }
};

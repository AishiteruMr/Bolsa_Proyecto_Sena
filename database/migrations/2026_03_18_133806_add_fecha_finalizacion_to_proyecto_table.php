<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('proyecto', function (Blueprint $table) {
        $table->dateTime('pro_fecha_finalizacion')->nullable()->after('pro_fecha_publi');
        $table->integer('pro_duracion_estimada')->nullable();
    });
}

public function down()
{
    Schema::table('proyecto', function (Blueprint $table) {
        $table->dropColumn(['pro_fecha_finalizacion', 'pro_duracion_estimada']);
    });
}
};

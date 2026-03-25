<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('proyecto', function (Blueprint $table) {
        $table->integer('pro_num_postulantes')->default(0);
    });
}

public function down()
{
    Schema::table('proyecto', function (Blueprint $table) {
        $table->dropColumn('pro_num_postulantes');
    });
}
};

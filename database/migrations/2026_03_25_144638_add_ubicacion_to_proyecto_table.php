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
            $table->decimal('pro_latitud', 10, 8)->nullable()->after('pro_estado');
            $table->decimal('pro_longitud', 11, 8)->nullable()->after('pro_latitud');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyecto', function (Blueprint $table) {
            $table->dropColumn(['pro_latitud', 'pro_longitud']);
        });
    }
};

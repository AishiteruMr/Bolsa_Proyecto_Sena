<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->boolean('consentimiento_datos')->default(false)->after('remember_token');
            $table->timestamp('fecha_consentimiento')->nullable()->after('consentimiento_datos');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['consentimiento_datos', 'fecha_consentimiento']);
        });
    }
};

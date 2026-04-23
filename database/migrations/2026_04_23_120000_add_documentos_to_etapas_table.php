<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('etapas', function (Blueprint $table) {
            $table->json('documentos_requeridos')->nullable()->after('descripcion');
            $table->string('url_documento')->nullable()->after('documentos_requeridos');
        });
    }

    public function down(): void
    {
        Schema::table('etapas', function (Blueprint $table) {
            $table->dropColumn(['documentos_requeridos', 'url_documento']);
        });
    }
};
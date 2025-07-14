<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('viagens', function (Blueprint $table) {
            $table->dropForeign(['motorista_id']);
            $table->dropColumn('motorista_id');
        });
    }

    public function down(): void
    {
        Schema::table('viagens', function (Blueprint $table) {
            $table->foreignId('motorista_id')->constrained()->onDelete('cascade');
        });
    }
};

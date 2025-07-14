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
        Schema::create('motorista_viagem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->constrained()->onDelete('cascade');
            $table->foreignId('viagem_id')->constrained('viagens')->onDelete('cascade');
            $table->unique(['motorista_id', 'viagem_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorista_viagem');
    }
};

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
        Schema::create('viagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->constrained()->onDelete('cascade');
            $table->foreignId('veiculo_id')->constrained()->onDelete('cascade');
            $table->integer('km_inicial');
            $table->integer('km_final');
            $table->dateTime('data_hora_inicial');
            $table->dateTime('data_hora_final');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viagems');
    }
};

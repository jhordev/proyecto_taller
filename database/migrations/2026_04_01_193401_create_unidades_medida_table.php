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
        Schema::create('unidades_medida', function (Blueprint $table) {
            $table->unsignedInteger('id_unidad')->autoIncrement();
            $table->string('nombre', 50);
            $table->string('abreviatura', 10);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->primary('id_unidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_medida');
    }
};

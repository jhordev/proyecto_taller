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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->date('fecha_nac');
            $table->string('tipo_doc', 50);
            $table->string('nro_doc', 20)->unique();
            $table->string('direccion', 40);
            $table->string('nro_tel_princ', 40);
            $table->string('nro_tel_sec', 40)->nullable();
            $table->string('email', 40)->nullable();
            $table->string('cargo', 40);
            $table->date('fecha_ingreso');
            $table->decimal('salario_anual', 10, 2)->unsigned(); 
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};

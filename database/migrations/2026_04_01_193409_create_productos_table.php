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
        Schema::create('productos', function (Blueprint $table) {
            $table->unsignedInteger('id_producto')->autoIncrement();
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();
            $table->unsignedInteger('categoria_id');
            $table->unsignedInteger('unidad_id');
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamp('fecha_registro')->useCurrent();

            $table->primary('id_producto');

            $table->foreign('categoria_id', 'fk_producto_categoria')
                ->references('id_categoria')->on('categorias')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('unidad_id', 'fk_producto_unidad')
                ->references('id_unidad')->on('unidades_medida')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Añadir índice en el campo estado para mejorar el rendimiento de filtrado
        Schema::table('productos', function (Blueprint $table) {
            $table->index(['categoria_id', 'estado'], 'idx_producto_categoria_estado');
        });

        // 2. Crear el Trigger para sincronizar estados
        DB::unprepared('
            CREATE TRIGGER tr_sync_categoria_producto_estado
            AFTER UPDATE ON categorias
            FOR EACH ROW
            BEGIN
                IF OLD.estado <> NEW.estado THEN
                    UPDATE productos
                    SET estado = NEW.estado
                    WHERE categoria_id = NEW.id_categoria;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Eliminar el trigger
        DB::unprepared('DROP TRIGGER IF EXISTS tr_sync_categoria_producto_estado');

        // 2. Eliminar el índice
        Schema::table('productos', function (Blueprint $table) {
            $table->dropIndex('idx_producto_categoria_estado');
        });
    }
};

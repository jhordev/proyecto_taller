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
        DB::unprepared('
            CREATE TRIGGER tr_actualizar_stock_productos
            BEFORE INSERT ON movimientos_inventario
            FOR EACH ROW
            BEGIN
                DECLARE v_stock_anterior INT;
                DECLARE v_stock_nuevo INT;

                -- Obtener el stock actual del producto
                SELECT stock INTO v_stock_anterior 
                FROM productos 
                WHERE id_producto = NEW.producto_id;

                -- Asignar stock anterior al nuevo registro
                SET NEW.stock_anterior = v_stock_anterior;

                -- Calcular nuevo stock según tipo de movimiento
                IF NEW.tipo_movimiento = "ENTRADA" THEN
                    SET v_stock_nuevo = v_stock_anterior + NEW.cantidad;
                ELSEIF NEW.tipo_movimiento = "SALIDA" OR NEW.tipo_movimiento = "AJUSTE" THEN
                    SET v_stock_nuevo = v_stock_anterior - NEW.cantidad;
                ELSE
                    SET v_stock_nuevo = v_stock_anterior;
                END IF;

                -- Asignar stock nuevo al registro de movimiento
                SET NEW.stock_nuevo = v_stock_nuevo;

                -- Actualizar la tabla de productos
                UPDATE productos 
                SET stock = v_stock_nuevo 
                WHERE id_producto = NEW.producto_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tr_actualizar_stock_productos');
    }
};

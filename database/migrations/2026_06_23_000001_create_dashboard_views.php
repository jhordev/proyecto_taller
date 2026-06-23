<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Índices compuestos para acelerar las consultas del dashboard
        Schema::table('ventas', function (Blueprint $table) {
            $table->index(['estado', 'created_at'], 'idx_ventas_estado_fecha');
        });

        Schema::table('detalle_ventas', function (Blueprint $table) {
            $table->index('producto_id', 'idx_detalle_producto_id');
        });

        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->index('fecha', 'idx_movimientos_fecha');
        });

        // Vista: ingresos y ventas agrupados por día (se filtra por rango en el controlador)
        DB::statement("
            CREATE OR REPLACE VIEW v_ventas_diarias AS
            SELECT
                DATE(created_at)          AS fecha,
                COUNT(*)                  AS total_ventas,
                COALESCE(SUM(total), 0)   AS total_ingresos
            FROM ventas
            WHERE estado = 'completada'
            GROUP BY DATE(created_at)
        ");

        // Vista: ingresos y ventas agrupados por mes/año
        DB::statement("
            CREATE OR REPLACE VIEW v_ventas_mensuales AS
            SELECT
                YEAR(created_at)          AS anio,
                MONTH(created_at)         AS mes,
                COUNT(*)                  AS total_ventas,
                COALESCE(SUM(total), 0)   AS total_ingresos
            FROM ventas
            WHERE estado = 'completada'
            GROUP BY YEAR(created_at), MONTH(created_at)
        ");

        // Vista: ranking global de productos por unidades vendidas en ventas completadas
        DB::statement("
            CREATE OR REPLACE VIEW v_productos_mas_vendidos AS
            SELECT
                p.id_producto,
                p.nombre                        AS producto,
                p.codigo,
                c.nombre                        AS categoria,
                COALESCE(SUM(dv.cantidad), 0)   AS total_unidades,
                COALESCE(SUM(dv.subtotal), 0)   AS total_ingresos,
                COUNT(DISTINCT dv.venta_id)     AS veces_vendido
            FROM detalle_ventas dv
            INNER JOIN productos  p ON dv.producto_id = p.id_producto
            INNER JOIN categorias c ON p.categoria_id = c.id_categoria
            INNER JOIN ventas     v ON dv.venta_id    = v.id AND v.estado = 'completada'
            GROUP BY p.id_producto, p.nombre, p.codigo, c.nombre
        ");

        // Vista: distribución de ventas completadas por método de pago
        DB::statement("
            CREATE OR REPLACE VIEW v_ventas_por_metodo_pago AS
            SELECT
                metodo_pago,
                COUNT(*)                  AS total_ventas,
                COALESCE(SUM(total), 0)   AS total_ingresos
            FROM ventas
            WHERE estado = 'completada'
            GROUP BY metodo_pago
        ");

        // Vista: productos activos en o por debajo de su stock mínimo
        DB::statement("
            CREATE OR REPLACE VIEW v_stock_critico AS
            SELECT
                p.id_producto,
                p.codigo,
                p.nombre,
                c.nombre              AS categoria,
                p.stock               AS stock_actual,
                p.stock_minimo,
                (p.stock_minimo - p.stock) AS deficit
            FROM productos  p
            INNER JOIN categorias c ON p.categoria_id = c.id_categoria
            WHERE p.stock <= p.stock_minimo
              AND p.estado = 'activo'
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_stock_critico');
        DB::statement('DROP VIEW IF EXISTS v_ventas_por_metodo_pago');
        DB::statement('DROP VIEW IF EXISTS v_productos_mas_vendidos');
        DB::statement('DROP VIEW IF EXISTS v_ventas_mensuales');
        DB::statement('DROP VIEW IF EXISTS v_ventas_diarias');

        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropIndex('idx_movimientos_fecha');
        });

        Schema::table('detalle_ventas', function (Blueprint $table) {
            $table->dropIndex('idx_detalle_producto_id');
        });

        Schema::table('ventas', function (Blueprint $table) {
            $table->dropIndex('idx_ventas_estado_fecha');
        });
    }
};

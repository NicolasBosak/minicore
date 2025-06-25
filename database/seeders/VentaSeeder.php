<?php

namespace Database\Seeders;

use App\Models\Venta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Venta::create(['fecha_venta' => '2025-05-21', 'vendedor_id' => 1, 'monto' => 400.00]);
        Venta::create(['fecha_venta' => '2025-05-29', 'vendedor_id' => 2, 'monto' => 600]);
        Venta::create(['fecha_venta' => '2025-06-03', 'vendedor_id' => 2, 'monto' => 200]);
        Venta::create(['fecha_venta' => '2025-06-09', 'vendedor_id' => 1, 'monto' => 300]);
        Venta::create(['fecha_venta' => '2025-06-11', 'vendedor_id' => 3, 'monto' => 900]);
    }
}

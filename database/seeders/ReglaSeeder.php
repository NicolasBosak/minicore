<?php

namespace Database\Seeders;

use App\Models\Regla;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReglaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Regla::create(['porcentaje' => 0.06, 'monto_minimo' => 600]);
        Regla::create(['porcentaje' => 0.08, 'monto_minimo' => 500]);
        Regla::create(['porcentaje' => 0.10, 'monto_minimo' => 800]);
        Regla::create(['porcentaje' => 1.15, 'monto_minimo' => 1000]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Vendedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendedor::create(['nombre' => 'Perico P', 'regla_id' => 1]);
        Vendedor::create(['nombre' => 'Zoila Baca', 'regla_id' => 2]);
        Vendedor::create(['nombre' => 'Aquiles C', 'regla_id' => 3]);
        Vendedor::create(['nombre' => 'Johny M', 'regla_id' => 4]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedor';

    protected $fillable = [
        'nombre',
        'regla_id'
    ];

    // Relación: Un vendedor pertenece a una regla de comisión
    public function regla()
    {
        return $this->belongsTo(Regla::class);
    }

    // Relación: Un vendedor tiene muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    // Método helper para calcular comisiones en un rango de fechas
    public function calcularComision($fechaInicio, $fechaFin)
    {
        $totalVentas = $this->ventas()
            ->whereBetween('fecha_venta', [$fechaInicio, $fechaFin])
            ->sum('monto');

        $porcentajeComision = $this->regla->porcentaje;
        
        return $totalVentas * $porcentajeComision;
    }

    // Método helper para obtener ventas en un rango
    public function ventasEnRango($fechaInicio, $fechaFin)
    {
        return $this->ventas()
            ->whereBetween('fecha_venta', [$fechaInicio, $fechaFin])
            ->get();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComisionRequest;
use Illuminate\Http\Request;
use App\Models\Vendedor;
use Carbon\Carbon;

class ComisionController extends Controller
{
    /**
     * Mostrar el formulario para seleccionar rango de fechas
     */
    public function index()
    {
        return view('comisiones.index');
    }

    /**
     * Calcular y mostrar las comisiones por vendedor
     */
    public function calcular(ComisionRequest $request)
    {

        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;

        // Obtener todos los vendedores con sus relaciones
        $vendedores = Vendedor::with(['regla', 'ventas'])->get();

        // Calcular comisiones para cada vendedor
        $resultados = [];
        
        foreach ($vendedores as $vendedor) {
            // Obtener ventas en el rango de fechas
            $ventasEnRango = $vendedor->ventas()
                ->whereBetween('fecha_venta', [$fechaInicio, $fechaFin])
                ->get();

            // Calcular el total de ventas
            $totalVentas = $ventasEnRango->sum('monto');

            // Calcular la comisión
            $porcentajeComision = $vendedor->regla->porcentaje;
            $comisionCalculada = $totalVentas * $porcentajeComision;

            // Almacenar resultados
            $resultados[] = [
                'vendedor' => $vendedor,
                'ventas_en_rango' => $ventasEnRango,
                'total_ventas' => $totalVentas,
                'porcentaje_comision' => $porcentajeComision,
                'comision_calculada' => $comisionCalculada,
                'tiene_ventas' => $ventasEnRango->count() > 0
            ];
        }

        return view('comisiones.resultados', [
            'resultados' => $resultados,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin
        ]);
    }

    /**
     * Método alternativo usando el helper del modelo
     */
    public function calcularAlternativo(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;

        $vendedores = Vendedor::with('regla')->get();
        $resultados = [];

        foreach ($vendedores as $vendedor) {
            $ventasEnRango = $vendedor->ventasEnRango($fechaInicio, $fechaFin);
            $totalVentas = $ventasEnRango->sum('monto');
            $comisionCalculada = $vendedor->calcularComision($fechaInicio, $fechaFin);

            $resultados[] = [
                'vendedor' => $vendedor,
                'ventas_en_rango' => $ventasEnRango,
                'total_ventas' => $totalVentas,
                'porcentaje_comision' => $vendedor->regla->porcentaje,
                'comision_calculada' => $comisionCalculada,
                'tiene_ventas' => $ventasEnRango->count() > 0
            ];
        }

        return view('comisiones.resultados', [
            'resultados' => $resultados,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin
        ]);
    }

    /**
     * API endpoint para obtener comisiones (opcional)
     */
    public function apiCalcular(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;

        $vendedores = Vendedor::with('regla')->get();
        $resultados = [];

        foreach ($vendedores as $vendedor) {
            $totalVentas = $vendedor->ventas()
                ->whereBetween('fecha_venta', [$fechaInicio, $fechaFin])
                ->sum('monto');

            $comisionCalculada = $vendedor->calcularComision($fechaInicio, $fechaFin);

            $resultados[] = [
                'vendedor_id' => $vendedor->id,
                'nombre' => $vendedor->nombre,
                'total_ventas' => $totalVentas,
                'porcentaje_comision' => $vendedor->regla->porcentaje * 100, // Como porcentaje
                'comision_calculada' => $comisionCalculada
            ];
        }

        return response()->json([
            'periodo' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin
            ],
            'comisiones' => $resultados,
            'total_comisiones' => collect($resultados)->sum('comision_calculada')
        ]);
    }
}
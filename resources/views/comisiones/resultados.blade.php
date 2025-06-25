@extends('layouts.app')

@section('title', 'Resultados de Comisiones')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header con información del período -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Reporte de Comisiones
                    </h4>
                    <a href="{{ route('comisiones.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-1"></i>
                        Nueva Consulta
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-primary fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0">Período Consultado</h6>
                                <p class="mb-0 text-muted">
                                    {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-dollar-sign text-success fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0">Total Comisiones</h6>
                                <p class="mb-0 text-muted">
                                    ${{ number_format(collect($resultados)->sum('comision_calculada'), 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-bar text-info fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0">Vendedores con Ventas</h6>
                                <p class="mb-0 text-muted">
                                    {{ collect($resultados)->where('tiene_ventas', true)->count() }} de {{ count($resultados) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de resultados -->
        <div class="card shadow table-comisiones">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i>
                    Detalle por Vendedor
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Vendedor</th>
                                <th><i class="fas fa-shopping-cart me-1"></i> Ventas en Período</th>
                                <th><i class="fas fa-dollar-sign me-1"></i> Total Ventas</th>
                                <th><i class="fas fa-percentage me-1"></i> % Comisión</th>
                                <th><i class="fas fa-money-bill-wave me-1"></i> Comisión Calculada</th>
                                <th><i class="fas fa-info-circle me-1"></i> Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resultados as $resultado)
                                <tr class="{{ $resultado['tiene_ventas'] ? 'con-ventas' : 'sin-ventas' }} {{ $resultado['comision_calculada'] > 50 ? 'comision-alta' : '' }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                {{ substr($resultado['vendedor']->nombre, 0, 1) }}
                                            </div>
                                            <div>
                                                <strong>{{ $resultado['vendedor']->nombre }}</strong>
                                                <br>
                                                <small class="text-muted">ID: {{ $resultado['vendedor']->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $resultado['ventas_en_rango']->count() }} ventas
                                        </span>
                                        @if($resultado['ventas_en_rango']->count() > 0)
                                            <button class="btn btn-sm btn-outline-info ms-2" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#ventas-{{ $resultado['vendedor']->id }}">
                                                <i class="fas fa-eye"></i> Ver
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>${{ number_format($resultado['total_ventas'], 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ number_format($resultado['porcentaje_comision'] * 100, 2) }}%
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-success">
                                            ${{ number_format($resultado['comision_calculada'], 2) }}
                                        </strong>
                                    </td>
                                    <td>
                                        @if($resultado['tiene_ventas'])
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Con Ventas
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation me-1"></i>Sin Ventas
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                
                                <!-- Fila colapsable con detalle de ventas -->
                                @if($resultado['ventas_en_rango']->count() > 0)
                                    <tr>
                                        <td colspan="6" class="p-0">
                                            <div class="collapse" id="ventas-{{ $resultado['vendedor']->id }}">
                                                <div class="card card-body m-3">
                                                    <h6><i class="fas fa-list me-2"></i>Detalle de Ventas</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Fecha</th>
                                                                    <th>Monto</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($resultado['ventas_en_rango'] as $venta)
                                                                    <tr>
                                                                        <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                                                                        <td>${{ number_format($venta->monto, 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5>No hay datos disponibles</h5>
                                        <p class="text-muted">No se encontraron vendedores en el sistema.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Resumen estadístico -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-2x text-primary mb-2"></i>
                        <h4>{{ count($resultados) }}</h4>
                        <p class="text-muted mb-0">Total Vendedores</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-2x text-success mb-2"></i>
                        <h4>{{ collect($resultados)->where('tiene_ventas', true)->count() }}</h4>
                        <p class="text-muted mb-0">Con Ventas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-2x text-info mb-2"></i>
                        <h4>{{ collect($resultados)->sum(function($r) { return $r['ventas_en_rango']->count(); }) }}</h4>
                        <p class="text-muted mb-0">Total Ventas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-dollar-sign fa-2x text-warning mb-2"></i>
                        <h4>${{ number_format(collect($resultados)->sum('total_ventas'), 0) }}</h4>
                        <p class="text-muted mb-0">Ventas Totales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Efectos y animaciones adicionales
    document.addEventListener('DOMContentLoaded', function() {
        // Animación para las cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection
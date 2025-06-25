@extends('layouts.app')

@section('title', 'Calculadora de Comisiones')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-calculator me-2"></i>
                    Calculadora de Comisiones de Vendedores
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Selecciona un rango de fechas para calcular las comisiones de todos los vendedores
                    basadas en sus ventas realizadas en ese período.
                </p>

                <form action="{{ route('comisiones.calcular') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_inicio" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Fecha de Inicio
                            </label>
                            <input 
                                type="date" 
                                class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                id="fecha_inicio" 
                                name="fecha_inicio" 
                                value="{{ old('fecha_inicio', '2025-06-01') }}"
                                required
                            >
                            @error('fecha_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_fin" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Fecha de Fin
                            </label>
                            <input 
                                type="date" 
                                class="form-control @error('fecha_fin') is-invalid @enderror" 
                                id="fecha_fin" 
                                name="fecha_fin" 
                                value="{{ old('fecha_fin', '2025-06-30') }}"
                                required
                            >
                            @error('fecha_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-calcular btn-lg">
                            <i class="fas fa-chart-bar me-2"></i>
                            Calcular Comisiones
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5>Vendedores Activos</h5>
                        <p class="text-muted">Sistema configurado con múltiples vendedores y reglas de comisión personalizadas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-percentage fa-3x text-success mb-3"></i>
                        <h5>Cálculo Automático</h5>
                        <p class="text-muted">Las comisiones se calculan automáticamente según las reglas establecidas para cada vendedor.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Validación del lado del cliente
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        fechaInicio.addEventListener('change', function() {
            fechaFin.min = this.value;
        });

        fechaFin.addEventListener('change', function() {
            if (this.value < fechaInicio.value) {
                alert('La fecha de fin no puede ser anterior a la fecha de inicio');
                this.value = fechaInicio.value;
            }
        });
    });
</script>
@endsection
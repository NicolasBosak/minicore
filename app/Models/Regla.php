<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regla extends Model
{
    use HasFactory;

    protected $table = 'reglas';

    protected $fillable = [
        'porcentaje',
        'monto_minimo'
    ];

    protected $casts = [
        'porcentaje' => 'decimal:4',
        'monto_minimo' => 'decimal:2'
    ];

    // Relación: Una regla puede tener muchos vendedores
    public function vendedores()
    {
        return $this->hasMany(Vendedor::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_venta',
        'vendedor_id',
        'monto'
    ];

    protected $casts = [
        'fecha_venta' => 'date',
        'monto' => 'decimal:2'
    ];

    // Relación: Una venta pertenece a un vendedor
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }
}

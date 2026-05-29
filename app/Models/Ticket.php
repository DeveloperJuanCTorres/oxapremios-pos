<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'sorteo_id',
        'dni',
        'nombres',
        'apellidos',
        'telefono',
        'departamento',
        'comprobante',
        'aprobado',
        'cantidad',
        'email',
        /*
        |--------------------------------------------------------------------------
        | NUEVOS
        |--------------------------------------------------------------------------
        */

        'user_id',

        'metodo_pago',

        'monto',

        'total_pagado',

        'observacion',

        'canal_venta',

        'created_by',
    ];

    public function sorteo()
    {
        return $this->belongsTo(Raffle::class, 'sorteo_id');
    }
}

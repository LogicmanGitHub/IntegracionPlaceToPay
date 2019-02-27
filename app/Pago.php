<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'fecha', 'referencia', 'descripcion','moneda','monto','status'
    ];
}
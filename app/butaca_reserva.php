<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class butaca_reserva extends Model
{
    protected $fillable = [
        'fila',
        'columna',
        'id_estado',
        'id_reserva',
    ];
    
    public function user(){
            return $this->belongsTo(\App\User::class,'id');
    }

    public function reserva(){
            return $this->belongsTo(\App\reserva::class,'id');
    }
}

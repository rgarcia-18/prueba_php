<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reserva extends Model
{
    protected $fillable = [
        'id_user',
        'fecha',
        'num_personas',
    ];
    
    public function user(){
        return $this->belongsTo('\App\User','id');
    }
}

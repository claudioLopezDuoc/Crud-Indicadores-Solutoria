<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjaxCrud extends Model
{
    use HasFactory;
    protected $table = "indicadores";
    protected $fillable = [
        'id','nombreIndicador','codigoIndicador','unidadMedidaIndicador',
        'valorIndicador','fechaIndicador','tiempoIndicador','origenIndicador'
    ];
    public $timestamps = false;
}

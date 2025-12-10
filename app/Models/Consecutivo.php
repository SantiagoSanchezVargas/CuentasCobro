<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consecutivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento',
        'prefijo',
        'numero_inicial',
        'numero_final',
        'numero_actual',
        'vigencia_inicio',
        'vigencia_fin',
        'resolucion',
        'activo'
    ];

    protected $casts = [
        'vigencia_inicio' => 'date',
        'vigencia_fin' => 'date',
        'activo' => 'boolean',
    ];

    // Helper para obtener el siguiente número formateado
    public function getSiguienteNumeroAttribute()
    {
        return $this->prefijo . '-' . ($this->numero_actual + 1);
    }
}

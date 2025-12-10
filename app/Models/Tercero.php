<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tercero extends Model
{
    protected $fillable = [
        'tipo_persona',
        'tipo_identificacion',
        'identificacion',
        'dv',
        'nombre_completo',
        'razon_social',
        'nombre_comercial',
        'direccion',
        'ciudad',
        'departamento',
        'telefono',
        'email',
        'responsabilidad_fiscal',
        'es_cliente',
        'es_proveedor',
    ];

    protected $casts = [
        'responsabilidad_fiscal' => 'array',
        'es_cliente' => 'boolean',
        'es_proveedor' => 'boolean',
    ];

    // Helper to get display name
    public function getNombreAttribute()
    {
        return $this->tipo_persona === 'juridica' ? $this->razon_social : $this->nombre_completo;
    }
}

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

    // Helper para obtener el siguiente número formateado con padding según el rango configurado.
    public function getSiguienteNumeroAttribute()
    {
        $current = $this->numero_actual;
        if ($current === null) {
            // Si no hay valor actual, partimos del inicio - 1 (o cero por defecto) para que el +1 arranque correcto.
            $start = $this->numero_inicial ?: 0;
            $current = $start - 1;
        }

        $next = $current + 1;
        $maxLen = max(strlen((string) $this->numero_final), strlen((string) $this->numero_inicial));
        $numeroPadded = $maxLen > 0
            ? str_pad((string) $next, $maxLen, '0', STR_PAD_LEFT)
            : (string) $next;

        return $this->prefijo
            ? $this->prefijo . '-' . $numeroPadded
            : $numeroPadded;
    }
}

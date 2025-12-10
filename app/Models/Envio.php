<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuenta_cobro_id',
        'usuario_envia_id',
        'destinatario_email',
        'destinatario_nombre',
        'tipo_envio',
        'mensaje',
        'fecha_envio',
        'enviado_exitosamente',
        'respuesta_servidor'
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
        'enviado_exitosamente' => 'boolean',
    ];

    // Relación con Cuenta de Cobro
    public function cuentaCobro()
    {
        return $this->belongsTo(CuentaCobro::class);
    }

    // Relación con Usuario que envía
    public function usuarioEnvia()
    {
        return $this->belongsTo(User::class, 'usuario_envia_id');
    }
}

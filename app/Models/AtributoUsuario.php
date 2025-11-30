<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtributoUsuario extends Model
{
    protected $table = 'atributos_usuario';

    protected $fillable = [
        'user_id',
        'nombre_completo',
        'apellidos',
        'telefono',
        'extension',
        'celular_personal',
        'email_alterno',
        'departamento',
        'puesto',
        'codigo_empleado',
        'nivel_jerarquico',
        'firma_electronica',
        'numero_firma_digital',
        'fecha_vencimiento_firma',
        'notificaciones_email',
        'notificaciones_sms',
        'idioma_preferido',
        'zona_horaria',
        'user_id_delegado',
        'fecha_inicio_delegacion',
        'fecha_fin_delegacion',
        'puede_delegar',
        'limite_aprobacion_valor',
        'limite_cuentas_simultaneas',
        'dias_para_aprobar',
        'ultimo_ip_login',
        'ultimo_login_at',
        'intentos_fallidos_login',
    ];

    protected $casts = [
        'notificaciones_email' => 'boolean',
        'notificaciones_sms' => 'boolean',
        'puede_delegar' => 'boolean',
        'fecha_inicio_delegacion' => 'datetime',
        'fecha_fin_delegacion' => 'datetime',
        'ultimo_login_at' => 'datetime',
        'fecha_vencimiento_firma' => 'date',
    ];

    /**
     * Relación: pertenece a User
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: usuario delegado
     */
    public function usuarioDelegado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_delegado');
    }

    /**
     * Obtener nombre completo del usuario
     */
    public function getNombreCompleto(): string
    {
        return trim("{$this->nombre_completo} {$this->apellidos}") ?: 
               $this->usuario?->name ?? 'Usuario Desconocido';
    }

    /**
     * Verificar si tiene delegación activa
     */
    public function tieneDelegacionActiva(): bool
    {
        return $this->puede_delegar && 
               $this->user_id_delegado &&
               $this->fecha_inicio_delegacion &&
               $this->fecha_inicio_delegacion->isPast() &&
               (!$this->fecha_fin_delegacion || $this->fecha_fin_delegacion->isFuture());
    }

    /**
     * Verificar si puede aprobar un valor
     */
    public function puedeAprobarValor(float $valor): bool
    {
        if (!$this->limite_aprobacion_valor) {
            return true; // Sin límite
        }

        return $valor <= $this->limite_aprobacion_valor;
    }

    /**
     * Verificar si puede aprobar más cuentas
     */
    public function puedeAprobarMasCuentas(): bool
    {
        if (!$this->limite_cuentas_simultaneas) {
            return true; // Sin límite
        }

        $enRevision = CuentaCobro::where('etapa_aprobacion', $this->obtenerEtapaAprobacion())
            ->where('estado_aprobacion', 'en_revision')
            ->count();

        return $enRevision < $this->limite_cuentas_simultaneas;
    }

    /**
     * Obtener etapa de aprobación según el rol
     */
    private function obtenerEtapaAprobacion(): ?string
    {
        $roleName = $this->usuario?->role?->name;

        return match($roleName) {
            'supervisor' => 'supervisor',
            'ordenador_gasto' => 'ordenador_gasto',
            'contratacion' => 'contratacion',
            'alcalde' => 'alcalde',
            'tesoreria' => 'tesoreria',
            default => null,
        };
    }

    /**
     * Registrar login
     */
    public function registrarLogin(string $ip): void
    {
        $this->update([
            'ultimo_ip_login' => $ip,
            'ultimo_login_at' => now(),
            'intentos_fallidos_login' => 0,
        ]);
    }

    /**
     * Registrar intento fallido
     */
    public function registrarIntentoFallido(): void
    {
        $this->increment('intentos_fallidos_login');
    }

    /**
     * Obtener estado de la firma digital
     */
    public function getFirmaDigitalValida(): bool
    {
        return $this->numero_firma_digital &&
               $this->fecha_vencimiento_firma &&
               $this->fecha_vencimiento_firma->isFuture();
    }

    /**
     * Obtener información de contacto
     */
    public function getContactos(): array
    {
        return [
            'email' => $this->usuario?->email,
            'email_alterno' => $this->email_alterno,
            'telefono' => $this->telefono,
            'extension' => $this->extension,
            'celular_personal' => $this->celular_personal,
        ];
    }

    /**
     * Obtener información laboral
     */
    public function getInformacionLaboral(): array
    {
        return [
            'departamento' => $this->departamento,
            'puesto' => $this->puesto,
            'codigo_empleado' => $this->codigo_empleado,
            'nivel_jerarquico' => $this->nivel_jerarquico,
        ];
    }
}

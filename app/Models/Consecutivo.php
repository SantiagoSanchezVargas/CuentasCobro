<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'activo',
        'dian_numeration_id'
    ];

    protected $casts = [
        'vigencia_inicio' => 'date',
        'vigencia_fin' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Relación con numeración DIAN
     */
    public function numeracionDian()
    {
        return $this->belongsTo(\Illuminate\Database\Eloquent\Model::class, 'dian_numeration_id', 'id')
            ->from('dian_numerations');
    }

    /**
     * Obtener el consecutivo válido para un tipo de documento
     */
    public static function getConsecutivoValido(string $tipoDocumento = 'Cuenta de Cobro'): ?self
    {
        return self::where('tipo_documento', $tipoDocumento)
            ->where('activo', true)
            ->whereDate('vigencia_inicio', '<=', now())
            ->whereDate('vigencia_fin', '>=', now())
            ->where(function ($query) {
                $query->whereRaw('numero_actual < numero_final');
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Verificar si existe un consecutivo válido
     */
    public static function tieneConsecutivoValido(string $tipoDocumento = 'Cuenta de Cobro'): bool
    {
        return self::getConsecutivoValido($tipoDocumento) !== null;
    }

    /**
     * Obtener información del estado del consecutivo para alertas
     */
    public static function getEstadoConsecutivo(string $tipoDocumento = 'Cuenta de Cobro'): array
    {
        $consecutivo = self::getConsecutivoValido($tipoDocumento);
        
        if (!$consecutivo) {
            // Buscar si hay alguno vencido o agotado
            $vencido = self::where('tipo_documento', $tipoDocumento)
                ->where('activo', true)
                ->whereDate('vigencia_fin', '<', now())
                ->first();
                
            $agotado = self::where('tipo_documento', $tipoDocumento)
                ->where('activo', true)
                ->whereRaw('numero_actual >= numero_final')
                ->first();
            
            if ($agotado) {
                return [
                    'valido' => false,
                    'tipo' => 'agotado',
                    'mensaje' => 'El consecutivo actual ha agotado su rango de numeración. Debe crear uno nuevo.',
                    'consecutivo' => $agotado,
                ];
            }
            
            if ($vencido) {
                return [
                    'valido' => false,
                    'tipo' => 'vencido',
                    'mensaje' => 'El consecutivo actual ha vencido el ' . $vencido->vigencia_fin->format('d/m/Y') . '. Debe crear uno nuevo.',
                    'consecutivo' => $vencido,
                ];
            }
            
            return [
                'valido' => false,
                'tipo' => 'inexistente',
                'mensaje' => 'No existe un consecutivo configurado para Cuentas de Cobro. Debe crear uno antes de continuar.',
                'consecutivo' => null,
            ];
        }
        
        // Calcular uso y días restantes
        $totalRango = $consecutivo->numero_final - $consecutivo->numero_inicial + 1;
        $usados = $consecutivo->numero_actual - $consecutivo->numero_inicial + 1;
        $disponibles = $consecutivo->numero_final - $consecutivo->numero_actual;
        $porcentajeUso = $totalRango > 0 ? round(($usados / $totalRango) * 100, 1) : 0;
        $diasRestantes = (int) now()->startOfDay()->diffInDays($consecutivo->vigencia_fin->startOfDay(), false);
        
        // Calcular formato legible de vigencia
        $vigenciaFormato = self::formatearVigencia($diasRestantes);
        
        $alertas = [];
        
        // Alerta si queda menos del 10% de números
        if ($porcentajeUso >= 90) {
            $alertas[] = [
                'tipo' => 'warning',
                'titulo' => 'Consecutivo por agotarse',
                'mensaje' => "Solo quedan {$disponibles} números disponibles en el consecutivo actual ({$porcentajeUso}% utilizado). Considere crear uno nuevo.",
            ];
        } elseif ($porcentajeUso >= 75) {
            $alertas[] = [
                'tipo' => 'info',
                'titulo' => 'Uso del Consecutivo',
                'mensaje' => "El consecutivo tiene {$disponibles} números disponibles ({$porcentajeUso}% utilizado).",
            ];
        }
        
        // Alerta si vence pronto
        if ($diasRestantes <= 0) {
            $alertas[] = [
                'tipo' => 'danger',
                'titulo' => 'Consecutivo Vencido',
                'mensaje' => "El consecutivo ha vencido. Debe crear uno nuevo para continuar emitiendo cuentas de cobro.",
            ];
        } elseif ($diasRestantes <= 7) {
            $alertas[] = [
                'tipo' => 'warning',
                'titulo' => 'Vencimiento Próximo',
                'mensaje' => "El consecutivo vence en {$diasRestantes} días ({$consecutivo->vigencia_fin->format('d/m/Y')}). Prepare un nuevo consecutivo.",
            ];
        } elseif ($diasRestantes <= 30) {
            $alertas[] = [
                'tipo' => 'info',
                'titulo' => 'Vigencia del Consecutivo',
                'mensaje' => "El consecutivo vence en {$diasRestantes} días ({$consecutivo->vigencia_fin->format('d/m/Y')}).",
            ];
        }
        // Si la vigencia es > 30 días, no mostramos alerta (todo está bien)
        
        return [
            'valido' => true,
            'tipo' => 'activo',
            'mensaje' => null,
            'consecutivo' => $consecutivo,
            'disponibles' => $disponibles,
            'porcentaje_uso' => $porcentajeUso,
            'dias_restantes' => $diasRestantes,
            'vigencia_formato' => $vigenciaFormato,
            'siguiente_numero' => $consecutivo->siguiente_numero,
            'alertas' => $alertas,
        ];
    }

    /**
     * Consumir el siguiente número del consecutivo
     * Retorna un array con el número, prefijo y número formateado
     */
    public function consumirNumero(): ?array
    {
        if ($this->numero_actual >= $this->numero_final) {
            return null; // Agotado
        }
        
        if ($this->vigencia_fin < now()) {
            return null; // Vencido
        }
        
        $current = $this->numero_actual ?? ($this->numero_inicial - 1);
        $siguiente = $current + 1;
        
        // Incrementar el contador
        $this->increment('numero_actual');
        
        // Formatear número con padding
        $digits = strlen((string) $this->numero_final);
        $numeroFormateado = str_pad($siguiente, $digits, '0', STR_PAD_LEFT);
        
        return [
            'numero' => $siguiente,
            'numero_formateado' => $this->prefijo . $numeroFormateado,
            'prefijo' => $this->prefijo,
            'resolucion' => $this->resolucion,
        ];
    }

    /**
     * Verificar si el consecutivo está disponible
     */
    public function estaDisponible(): bool
    {
        return $this->activo 
            && $this->numero_actual < $this->numero_final
            && $this->vigencia_inicio <= now()
            && $this->vigencia_fin >= now();
    }

    /**
     * Formatear días restantes en años, meses y días legibles
     */
    public static function formatearVigencia(int $dias): string
    {
        if ($dias <= 0) {
            return 'Vencido';
        }
        
        $anios = floor($dias / 365);
        $diasRestantes = $dias % 365;
        $meses = floor($diasRestantes / 30);
        $diasFinales = $diasRestantes % 30;
        
        $partes = [];
        
        if ($anios > 0) {
            $partes[] = $anios . ' ' . ($anios == 1 ? 'año' : 'años');
        }
        if ($meses > 0) {
            $partes[] = $meses . ' ' . ($meses == 1 ? 'mes' : 'meses');
        }
        if ($diasFinales > 0 || empty($partes)) {
            $partes[] = $diasFinales . ' ' . ($diasFinales == 1 ? 'día' : 'días');
        }
        
        return implode(', ', $partes);
    }

    /**
     * Helper para obtener el siguiente número formateado con padding
     */
    public function getSiguienteNumeroAttribute(): string
    {
        $current = $this->numero_actual ?? ($this->numero_inicial - 1);
        $next = $current + 1;
        
        $maxLen = max(strlen((string) $this->numero_final), strlen((string) $this->numero_inicial));
        $numeroPadded = $maxLen > 0
            ? str_pad((string) $next, $maxLen, '0', STR_PAD_LEFT)
            : (string) $next;

        return $this->prefijo
            ? $this->prefijo . '-' . $numeroPadded
            : $numeroPadded;
    }

    /**
     * Relación con cuentas de cobro que usan este consecutivo
     */
    public function cuentasCobro()
    {
        return $this->hasMany(CuentaCobro::class);
    }
}

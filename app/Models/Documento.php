<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'cuenta_cobro_id',
        'nombre_original',
        'nombre_almacenado',
        'tipo_documento',
        'mime_type',
        'tamaño_bytes',
        'descripcion',
        'categoria',
        'etiquetas',
        'version',
        'documento_anterior_id',
        'user_id',
        'ruta_disco',
        'ruta_archivo',
        'ruta_temporal',
        'visibilidad',
        'roles_acceso',
        'fecha_subida',
        'fecha_ultima_descarga',
        'cantidad_descargas',
        'escaneado_virus',
        'archivado_at',
    ];

    protected $casts = [
        'fecha_subida' => 'datetime',
        'fecha_ultima_descarga' => 'datetime',
        'archivado_at' => 'datetime',
        'etiquetas' => 'array',
        'roles_acceso' => 'array',
    ];

    /**
     * Relación: Documento pertenece a CuentaCobro
     */
    public function cuentaCobro(): BelongsTo
    {
        return $this->belongsTo(CuentaCobro::class, 'cuenta_cobro_id');
    }

    /**
     * Relación: Documento pertenece a User
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: versiones previas del documento
     */
    public function versionesAnteriores(): HasMany
    {
        return $this->hasMany(Documento::class, 'documento_anterior_id');
    }

    /**
     * Relación: documento anterior
     */
    public function documentoAnterior(): BelongsTo
    {
        return $this->belongsTo(Documento::class, 'documento_anterior_id');
    }

    /**
     * Scope: documentos no archivados
     */
    public function scopeNotArchived($query)
    {
        return $query->whereNull('archivado_at');
    }

    /**
     * Scope: documentos visibles para un usuario
     */
    public function scopeVisiblesParaUsuario($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('visibilidad', 'public')
              ->orWhere('user_id', $user->id)
              ->orWhere(function ($subQ) use ($user) {
                  if ($user->role) {
                      $subQ->where('visibilidad', 'internal')
                           ->whereJsonContains('roles_acceso', $user->role->name);
                  }
              });
        });
    }

    /**
     * Scope: documentos por tipo
     */
    public function scopeByTipo($query, $tipo)
    {
        return $query->where('tipo_documento', $tipo);
    }

    /**
     * Scope: documentos por categoría
     */
    public function scopeByCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Obtener URL de descarga
     */
    public function getUrlDescargaAttribute()
    {
        return Storage::disk($this->ruta_disco)->url($this->ruta_archivo);
    }

    /**
     * Registrar descarga
     */
    public function registrarDescarga(): void
    {
        $this->increment('cantidad_descargas');
        $this->update(['fecha_ultima_descarga' => now()]);
    }

    /**
     * Crear nueva versión
     */
    public function crearNuevaVersion(string $rutaArchivo, ?string $descripcion = null): Documento
    {
        $nuevoDocumento = static::create([
            'cuenta_cobro_id' => $this->cuenta_cobro_id,
            'nombre_original' => $this->nombre_original,
            'nombre_almacenado' => basename($rutaArchivo),
            'tipo_documento' => $this->tipo_documento,
            'mime_type' => $this->mime_type,
            'tamaño_bytes' => Storage::disk($this->ruta_disco)->size($rutaArchivo),
            'descripcion' => $descripcion,
            'categoria' => $this->categoria,
            'version' => $this->version + 1,
            'documento_anterior_id' => $this->id,
            'user_id' => auth()->id() ?? $this->user_id,
            'ruta_disco' => $this->ruta_disco,
            'ruta_archivo' => $rutaArchivo,
            'visibilidad' => $this->visibilidad,
            'roles_acceso' => $this->roles_acceso,
        ]);

        return $nuevoDocumento;
    }

    /**
     * Archivizar documento
     */
    public function archivar(): void
    {
        $this->update(['archivado_at' => now()]);
    }

    /**
     * Desarchivizar documento
     */
    public function desarchivizar(): void
    {
        $this->update(['archivado_at' => null]);
    }

    /**
     * Obtener color para el tipo de documento
     */
    public function getColorTipo(): string
    {
        return match($this->tipo_documento) {
            'factura' => '#007AFF',          // Azul
            'contrato' => '#34C759',         // Verde
            'comprobante' => '#FF9500',      // Naranja
            'otro' => '#5856D6',             // Púrpura
            default => '#86868B',            // Gris
        };
    }

    /**
     * Obtener icono para la categoría
     */
    public function getIconoCategoria(): string
    {
        return match($this->categoria) {
            'soporte' => 'attachment',
            'contrato' => 'description',
            'comprobante_pago' => 'receipt_long',
            'anexo' => 'note_add',
            default => 'file_present',
        };
    }

    /**
     * Formatear tamaño en bytes a formato legible
     */
    public function getTamañoFormato(): string
    {
        $bytes = $this->tamaño_bytes;
        $unidades = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($unidades) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $unidades[$i];
    }

    /**
     * Verificar si se puede descargar
     */
    public function puedeDescargar(User $user): bool
    {
        if ($user->role?->name === 'super_admin') {
            return true;
        }

        if ($user->id === $this->user_id) {
            return true;
        }

        if ($this->visibilidad === 'public') {
            return true;
        }

        if ($this->visibilidad === 'internal' && $user->role) {
            return in_array($user->role->name, $this->roles_acceso ?? []);
        }

        return false;
    }

    /**
     * Eliminar archivo del almacenamiento
     */
    public function eliminarDelAlmacenamiento(): bool
    {
        if (Storage::disk($this->ruta_disco)->exists($this->ruta_archivo)) {
            return Storage::disk($this->ruta_disco)->delete($this->ruta_archivo);
        }

        return true;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación: cada usuario tiene un rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relación: usuario tiene atributos adicionales
    public function atributos()
    {
        return $this->hasOne(AtributoUsuario::class, 'user_id');
    }

    // Relación: documentos subidos por usuario
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'user_id');
    }

    // Relación: cuentas de cobro creadas por usuario (contratista)
    public function cuentasDeCobroCreadasPorMi()
    {
        return $this->hasMany(CuentaCobro::class, 'user_id');
    }

    // Relación: historial de cambios de rol
    public function roleChangeHistory()
    {
        return $this->hasMany(RoleChangeHistory::class, 'user_id')->orderBy('changed_at', 'desc');
    }

    // Métodos de verificación de rol
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function hasAnyRole($roles)
    {
        if (!is_array($roles)) $roles = [$roles];
        return $this->role && in_array($this->role->name, $roles);
    }

    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['admin_programa']);
    }

    public function canApprovePayments(): bool
    {
        return $this->hasAnyRole(['tesoreria', 'admin_programa']);
    }

    public function canManageContracts(): bool
    {
        return $this->hasAnyRole(['administrador', 'admin_programa']);
    }

    public function isContractAdmin(): bool
    {
        return $this->hasRole('administrador');
    }

    /**
     * Verificar si el usuario tiene un permiso específico a través de su rol.
     */
    public function hasPermission($permissionName)
    {
        if (!$this->role) {
            return false;
        }

        // Resolve alias to canonical name via config
        $canonical = config('permission_aliases.' . $permissionName, $permissionName);

        return $this->role->permissions()->where('name', $canonical)->exists();
    }

    /**
     * Obtener atributos del usuario
     */
    public function getAtributos(): AtributoUsuario
    {
        return $this->atributos ?? new AtributoUsuario(['user_id' => $this->id]);
    }

    /**
     * Obtener nombre completo del usuario
     */
    public function getNombreCompleto(): string
    {
        $atributos = $this->getAtributos();
        return trim("{$atributos->nombre_completo} {$atributos->apellidos}") ?: $this->name;
    }

    /**
     * Obtener información de contacto
     */
    public function getInformacionContacto(): array
    {
        return $this->getAtributos()->getContactos();
    }

    /**
     * Verificar permisos granulares
     */
    public function puedeRealizarAccion(string $accion, ?string $etapa = null, ?string $estado = null): bool
    {
        if ($this->hasRole('admin_programa')) {
            return true; // Admin programa puede todo
        }

        // Administrador (role 'administrador') puede realizar ciertos actos de control
        // sin requerir permisos granulares explícitos (p.ej. rechazar)
        if ($this->hasRole('administrador')) {
            if (in_array($accion, ['rechazar'])) {
                return true;
            }
        }

        $permisos = PermisoGranular::byRol($this->role)
            ->byEtapa($etapa)
            ->activos()
            ->get();

        foreach ($permisos as $permiso) {
            if ($estado && $permiso->estado_requerido && $permiso->estado_requerido !== $estado) {
                continue;
            }

            if ($permiso->tienePermiso($accion)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Obtener permisos granulares activos del usuario
     */
    public function getPermisosActivos(): array
    {
        if ($this->hasRole('admin_programa')) {
            return ['*' => true]; // Todos los permisos
        }

        return PermisoGranular::byRol($this->role)
            ->activos()
            ->get()
            ->map(fn($p) => $p->getResumenPermisos())
            ->toArray();
    }

}


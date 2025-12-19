# 🏗️ ARQUITECTURA TÉCNICA - CuentasCobro v3.0

## 📐 Resumen de Arquitectura

```
┌─────────────────────────────────────────────────────────────────┐
│                     CAPA DE PRESENTACIÓN                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────────┐  │
│  │   Blade      │  │   Bootstrap  │  │   Alpine.js / AJAX   │  │
│  │  Templates   │  │   Tailwind   │  │   (Interactividad)   │  │
│  └──────────────┘  └──────────────┘  └──────────────────────┘  │
└──────────────────────────┬───────────────────────────────────────┘
                           │ HTTP/Requests
┌──────────────────────────▼───────────────────────────────────────┐
│                     CAPA DE ENRUTAMIENTO                         │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │  Routes (web.php):                                       │   │
│  │  - /documentos/* → DocumentoController                   │   │
│  │  - /aprobaciones/* → AprobacionController                │   │
│  │  - /admin/permisos/* → PermisoController                 │   │
│  │  - Middleware de autenticación                           │   │
│  └──────────────────────────────────────────────────────────┘   │
└──────────────────────────┬───────────────────────────────────────┘
                           │ Route Matching
┌──────────────────────────▼───────────────────────────────────────┐
│                 CAPA DE CONTROLADORES (API)                      │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────────┐   │
│  │  Documento   │  │ Aprobacion   │  │    Permiso           │   │
│  │ Controller   │  │ Controller   │  │  Controller          │   │
│  │              │  │              │  │                      │   │
│  │ - index      │  │ - modal      │  │ - index             │   │
│  │ - store      │  │ - enviar     │  │ - create            │   │
│  │ - destroy    │  │ - rechazar   │  │ - aplicarPlantilla  │   │
│  │ - descargar  │  │ - interacciones                        │   │
│  └──────────────┘  └──────────────┘  └──────────────────────┘   │
└──────────────────────────┬───────────────────────────────────────┘
                           │ Business Logic
┌──────────────────────────▼───────────────────────────────────────┐
│                  CAPA DE MODELOS (ELOQUENT ORM)                  │
│  ┌──────────────────┐  ┌──────────────┐  ┌──────────────────┐   │
│  │   CuentaCobro    │  │  Documento   │  │  AtributoUsuario │   │
│  │  (Enhanced)      │  │   (New)      │  │    (New)         │   │
│  │                  │  │              │  │                  │   │
│  │ + documentos()   │  │ - versiones  │  │ - puedeAprobar   │   │
│  │ + calcular...()  │  │ - acceso     │  │ - delegacion     │   │
│  │ + getHistorial() │  │ - archivar   │  │ - limites        │   │
│  │ + archivar()     │  │              │  │ - auditoria      │   │
│  └──────────────────┘  └──────────────┘  └──────────────────┘   │
│                                                                   │
│  ┌─────────────────────────┐  ┌──────────────────────────────┐  │
│  │  PermisoGranular (New)  │  │  User & Role (Enhanced)      │  │
│  │                         │  │                              │  │
│  │ - tienePermiso()        │  │ - puedeRealizarAccion()      │  │
│  │ - puedeVerCuenta()      │  │ - getPermisosActivos()       │  │
│  │ - getCamposVisibles()   │  │ - atributos()                │  │
│  │ - esVigente()           │  │ - documentos()               │  │
│  └─────────────────────────┘  └──────────────────────────────┘  │
└──────────────────────────┬───────────────────────────────────────┘
                           │ Database Queries
┌──────────────────────────▼───────────────────────────────────────┐
│                    CAPA DE BASE DE DATOS                         │
│  MySQL 8.0 (InnoDB)                                              │
│  ┌─────────────┐  ┌──────────────┐  ┌──────────────────────┐   │
│  │ documentos  │  │ atributos    │  │  permisos_granulares │   │
│  │             │  │ _usuario     │  │                      │   │
│  │ - versiones │  │              │  │ - permisos booleanos │   │
│  │ - acceso    │  │ - contacto   │  │ - JSON fields        │   │
│  │ - auditoria │  │ - limites    │  │ - validación         │   │
│  └─────────────┘  └──────────────┘  └──────────────────────┘   │
│                                                                   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │  cuentas_cobro (Enhanced: +27 campos)                    │   │
│  │  - Campos financieros: subtotal, descuentos, impuestos   │   │
│  │  - Retenciones detalladas                                │   │
│  │  - Info bancaria ampliada                                │   │
│  │  - Datos fiscales                                        │   │
│  └──────────────────────────────────────────────────────────┘   │
│                                                                   │
│  Otras tablas existentes:                                        │
│  - users, roles, permissions, cuentas_cobro_historial           │
│  - item_cuenta_cobro, interaccion, contrato                     │
│  - notificacion, departamento, municipio                        │
└──────────────────────────────────────────────────────────────────┘
```

---

## 🔄 Flujos de Datos Principales

### **Flujo 1: Subir Documento**

```
Usuario (Blade)
    ↓
[Formulario POST /documentos/guardar]
    ↓
DocumentoController::store()
    ├─ Validar archivo (tipo, tamaño)
    ├─ Almacenar en storage/documentos/{cuenta_id}/
    ├─ Crear registro en BD (Documento::create)
    ├─ Registrar en historial (CuentaCobro::registrarModificacion)
    └─ Retornar JSON success
    ↓
JavaScript actualiza lista de documentos
    ↓
Vista actualiza (muestra nuevo documento)
```

---

### **Flujo 2: Procesar Aprobación**

```
Usuario (Modal de aprobación)
    ↓
[POST /aprobaciones/{id}/enviar-siguiente]
    ↓
AprobacionController::enviarAlSiguiente()
    ├─ Validar permiso de usuario
    ├─ Iniciar DB::transaction()
    ├─ Validar documentos obligatorios
    ├─ Actualizar CuentaCobro
    │  └─ etapa: incrementar
    │  └─ estado: en_revision
    │  └─ fecha_ultima_modificacion
    ├─ Crear CuentaCobroHistorial (auditoria)
    ├─ Crear Interaccion (si hay comentario)
    ├─ Generar Notificacion
    │  └─ Notificar siguiente rol
    └─ Commit transaction
    ↓
PermisoGranular::validar() ← Verificar permisos de nuevo aprobador
    ↓
Notificacion::notificar()
    ├─ Email al rol siguiente
    ├─ Guardar en BD
    └─ SMS (si configurado)
```

---

### **Flujo 3: Consultear Permisos**

```
Usuario realiza acción en UI
    ↓
JavaScript: $.post('/permisos/check', {accion, cuenta_id})
    ↓
PermisoController::verificar() [endpoint AJAX]
    ├─ Obtener user.permisos_granulares
    ├─ Validar role_id del usuario
    ├─ Validar etapa de la cuenta
    ├─ Validar estado de la cuenta
    ├─ Validar valor vs límite_aprobacion
    └─ Retornar JSON {permitido: true/false, razon: "..."}
    ↓
JavaScript habilita/deshabilita botón
```

---

### **Flujo 4: Obtener Historial Completo**

```
Usuario solicita GET /aprobaciones/{id}/historial
    ↓
AprobacionController::obtenerHistorial()
    ├─ Obtener CuentaCobro
    ├─ MERGE 3 fuentes en orden cronológico:
    │  ├─ CuentaCobro::cuentaCobroHistoriales()
    │  │  └─ Cambios de estado, etapa, rechazo, etc.
    │  ├─ CuentaCobro::interacciones()
    │  │  └─ Comentarios, notas, recordatorios, etc.
    │  └─ CuentaCobro::documentos()
    │     └─ Subidas, eliminaciones, cambios de versión
    ├─ Ordenar por fecha_creacion DESC
    ├─ Enriquecer con usuario, tipo, descripción
    └─ Retornar JSON array
    ↓
Blade Vista: timeline.blade.php
    ├─ Itera sobre historial
    ├─ Renderiza ícon por tipo
    ├─ Muestra usuario y fecha
    └─ Pantalla muestra timeline vertical
```

---

## 🗄️ Estructura de Base de Datos

### Tabla: `documentos`

```sql
CREATE TABLE documentos (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    cuenta_cobro_id BIGINT UNSIGNED NOT NULL (FK),
    nombre_original VARCHAR(255),
    nombre_almacenado VARCHAR(255),
    
    tipo_documento ENUM('factura', 'contrato', 'comprobante', 'otro'),
    categoria ENUM('soporte', 'contrato', 'comprobante_pago', 'anexo'),
    mime_type VARCHAR(50),
    tamaño_bytes INT UNSIGNED,
    
    user_id BIGINT UNSIGNED NOT NULL (FK),
    version INT UNSIGNED DEFAULT 1,
    documento_anterior_id BIGINT UNSIGNED (FK),
    
    visibilidad ENUM('private', 'internal', 'public') DEFAULT 'internal',
    roles_acceso JSON,
    
    cantidad_descargas INT UNSIGNED DEFAULT 0,
    fecha_ultima_descarga TIMESTAMP NULL,
    
    escaneado_virus BOOLEAN DEFAULT FALSE,
    hash_archivo VARCHAR(64),
    
    archivado_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEXES:
    - INDEX idx_cuenta_cobro_id
    - INDEX idx_user_id
    - INDEX idx_tipo_documento
    - INDEX idx_archivado_at
    - FOREIGN KEY cuenta_cobro_id → cuentas_cobro(id)
    - FOREIGN KEY user_id → users(id)
    - FOREIGN KEY documento_anterior_id → documentos(id)
);
```

---

### Tabla: `atributos_usuario`

```sql
CREATE TABLE atributos_usuario (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE (FK),
    
    -- Personal
    nombre_completo VARCHAR(255),
    apellidos VARCHAR(255),
    telefono VARCHAR(20),
    extension VARCHAR(10),
    celular_personal VARCHAR(20),
    email_alterno VARCHAR(255),
    
    -- Laboral
    departamento VARCHAR(100),
    puesto VARCHAR(100),
    codigo_empleado VARCHAR(50),
    nivel_jerarquico TINYINT,
    
    -- Firma Digital
    firma_electronica LONGBLOB,
    numero_firma_digital VARCHAR(100),
    fecha_vencimiento_firma DATE,
    
    -- Notificaciones
    notificaciones_email BOOLEAN DEFAULT TRUE,
    notificaciones_sms BOOLEAN DEFAULT FALSE,
    
    -- Delegación
    user_id_delegado BIGINT UNSIGNED (FK),
    fecha_inicio_delegacion DATE,
    fecha_fin_delegacion DATE,
    
    -- Límites
    limite_aprobacion_valor DECIMAL(15, 2),
    limite_cuentas_simultaneas INT DEFAULT 5,
    dias_para_aprobar INT DEFAULT 3,
    
    -- Auditoría
    ultimo_ip_login VARCHAR(45),
    ultimo_login_at TIMESTAMP,
    intentos_fallidos_login INT DEFAULT 0,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEXES:
    - PRIMARY KEY user_id
    - INDEX idx_departamento
    - INDEX idx_user_id_delegado
    - FOREIGN KEY user_id → users(id)
    - FOREIGN KEY user_id_delegado → users(id)
);
```

---

### Tabla: `permisos_granulares`

```sql
CREATE TABLE permisos_granulares (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    role_id BIGINT UNSIGNED NOT NULL (FK),
    
    etapa_flujo VARCHAR(50) NULL,
    estado_requerido VARCHAR(50) NULL,
    
    -- Permisos Booleanos
    puede_crear BOOLEAN DEFAULT FALSE,
    puede_leer BOOLEAN DEFAULT FALSE,
    puede_editar BOOLEAN DEFAULT FALSE,
    puede_eliminar BOOLEAN DEFAULT FALSE,
    
    puede_aprobar BOOLEAN DEFAULT FALSE,
    puede_rechazar BOOLEAN DEFAULT FALSE,
    puede_devolver BOOLEAN DEFAULT FALSE,
    puede_devolver_correccion BOOLEAN DEFAULT FALSE,
    
    puede_comentar BOOLEAN DEFAULT FALSE,
    puede_subir_documentos BOOLEAN DEFAULT FALSE,
    puede_descargar_documentos BOOLEAN DEFAULT FALSE,
    
    puede_registrar_pago BOOLEAN DEFAULT FALSE,
    puede_enviar_cliente BOOLEAN DEFAULT FALSE,
    
    puede_archivar BOOLEAN DEFAULT FALSE,
    puede_ver_todas_cuentas BOOLEAN DEFAULT FALSE,
    
    puede_ver_reportes BOOLEAN DEFAULT FALSE,
    puede_gestionar_usuarios BOOLEAN DEFAULT FALSE,
    puede_gestionar_contratos BOOLEAN DEFAULT FALSE,
    
    -- Restricciones
    campos_visibles JSON DEFAULT '[]',
    campos_editables JSON DEFAULT '[]',
    roles_visibles JSON DEFAULT '[]',
    departamentos_visibles JSON DEFAULT '[]',
    
    valor_minimo_aprobacion DECIMAL(15, 2) DEFAULT 0,
    valor_maximo_aprobacion DECIMAL(15, 2) DEFAULT 999999999,
    requiere_segundo_aprobador BOOLEAN DEFAULT FALSE,
    
    -- Control
    fecha_inicio_vigencia DATE,
    fecha_fin_vigencia DATE NULL,
    activo BOOLEAN DEFAULT TRUE,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEXES:
    - INDEX idx_role_id
    - INDEX idx_etapa_flujo
    - INDEX idx_estado_requerido
    - INDEX idx_activo
    - FOREIGN KEY role_id → roles(id)
);
```

---

### Mejoras a tabla: `cuentas_cobro`

```sql
ALTER TABLE cuentas_cobro ADD COLUMN (
    -- Cálculo Detallado
    subtotal DECIMAL(15, 2) AFTER valor_total,
    descuento_valor DECIMAL(15, 2),
    descuento_porcentaje DECIMAL(5, 2),
    
    -- IVA
    iva_porcentaje DECIMAL(5, 2),
    iva_valor DECIMAL(15, 2),
    
    -- Retenciones
    retencion_fuente_porcentaje DECIMAL(5, 2),
    retencion_fuente_valor DECIMAL(15, 2),
    retencion_ica_porcentaje DECIMAL(5, 2),
    retencion_ica_valor DECIMAL(15, 2),
    retencion_iva_porcentaje DECIMAL(5, 2),
    retencion_iva_valor DECIMAL(15, 2),
    otras_retenciones_valor DECIMAL(15, 2),
    
    -- Anticipo
    tiene_anticipo BOOLEAN DEFAULT FALSE,
    valor_anticipo DECIMAL(15, 2),
    valor_pendiente_pago DECIMAL(15, 2),
    referencia_anticipo VARCHAR(100),
    fecha_pago_anticipado DATE,
    
    -- Información Bancaria
    tipo_cuenta_beneficiario ENUM('ahorros', 'corriente'),
    numero_cuenta_beneficiario VARCHAR(50),
    banco_beneficiario VARCHAR(100),
    cuenta_corriente_usuario VARCHAR(50),
    
    -- Información Fiscal
    nit_beneficiario VARCHAR(50),
    rut_url VARCHAR(500),
    responsable_iva BOOLEAN DEFAULT FALSE,
    gran_contribuyente BOOLEAN DEFAULT FALSE,
    
    -- Control
    numero_orden_compra VARCHAR(50),
    numero_cdp VARCHAR(50),
    numero_rgp VARCHAR(50),
    fecha_vencimiento_factura DATE,
    
    -- Observaciones
    observaciones_internas TEXT,
    justificacion_rechazo TEXT,
    justificacion_devolucion TEXT,
    
    -- Auditoría
    fecha_ultima_modificacion TIMESTAMP,
    modificado_por BIGINT UNSIGNED (FK),
    
    -- Archivado
    archived_at TIMESTAMP NULL,
    
    INDEXES:
    - INDEX idx_subtotal
    - INDEX idx_modificado_por
    - INDEX idx_archived_at
    - FOREIGN KEY modificado_por → users(id)
);
```

---

## 📊 Diagrama ER (Entidad-Relación)

```
┌─────────────────┐
│     users       │
├─────────────────┤
│ id (PK)         │
│ role_id (FK)    │◄────────────┐
│ email           │             │
│ password        │             │
└─────────────────┘             │
        │                       │
        │ 1:1                   │
        ▼                       │
┌──────────────────────┐        │
│ atributos_usuario    │        │
├──────────────────────┤        │
│ id (PK)              │        │
│ user_id (FK) [UNIQUE]│        │
│ nombre_completo      │        │
│ departamento         │        │
│ puesto               │        │
│ limite_aprobacion    │        │
│ firma_electronica    │        │
└──────────────────────┘        │
                                │
                                │
                    ┌───────────┴──────────┐
                    │                      │
                    ▼                      ▼
            ┌──────────────┐      ┌─────────────────┐
            │    roles     │      │ permisos_grant  │
            ├──────────────┤      ├─────────────────┤
            │ id (PK)      │◄─────│ id (PK)         │
            │ nombre       │      │ role_id (FK)    │
            │ descripcion  │      │ etapa_flujo     │
            └──────────────┘      │ estado_requerido│
                                  │ puede_crear     │
                                  │ puede_aprobar   │
                                  │ ... (18 permisos)
                                  │ campos_visibles │
                                  │ campos_editables
                                  │ valor_maximo    │
                                  └─────────────────┘

        ┌──────────────────────────────────────────┐
        │       cuentas_cobro (ENHANCED)           │
        ├──────────────────────────────────────────┤
        │ id (PK)                                  │
        │ user_id (FK) ◄─ Contratista que crea    │
        │ aprobado_por (FK) ◄─ Último aprobador   │
        │ modificado_por (FK) ◄─ Última edición   │
        │ contrato_id (FK)                         │
        │                                          │
        │ FINANCIERO (NEW):                        │
        │ - subtotal, descuentos, IVA             │
        │ - retenciones (FUENTE, ICA, IVA, otras) │
        │ - anticipo (valor, referencia)          │
        │                                          │
        │ BANCARIO (NEW):                          │
        │ - tipo_cuenta, numero_cuenta            │
        │ - banco, cuenta_corriente                │
        │                                          │
        │ FISCAL (NEW):                            │
        │ - nit, rut, responsable_iva             │
        │ - gran_contribuyente                     │
        │                                          │
        │ CONTROL (NEW):                           │
        │ - orden_compra, cdp, rgp                │
        │ - vencimiento_factura                    │
        │                                          │
        │ AUDITORÍA (ENHANCED):                    │
        │ - modificado_por, fecha_última_mod       │
        │ - archived_at (soft delete)              │
        └──────────────────────────────────────────┘
                │        │         │
                │        │         └──► users (modificado_por)
                │        └──► users (aprobado_por)
                └──► users (user_id - contratista)
                
        ┌────────────────────────────────┐
        │      documentos (NEW)           │
        ├────────────────────────────────┤
        │ id (PK)                        │
        │ cuenta_cobro_id (FK) ◄─────────┤
        │ user_id (FK) ◄─ Quien subió    │
        │ documento_anterior_id (FK)     │
        │    (para versionamiento)       │
        │                                │
        │ nombre_original, almacenado    │
        │ tipo, categoria, mime_type     │
        │ tamaño_bytes, hash_archivo     │
        │                                │
        │ visibilidad, roles_acceso      │
        │ cantidad_descargas             │
        │ fecha_ultima_descarga          │
        │ archivado_at                   │
        └────────────────────────────────┘
        
        ┌──────────────────────────────┐
        │  cuentas_cobro_historial     │
        │  (Auditoría existente)       │
        ├──────────────────────────────┤
        │ id (PK)                      │
        │ cuenta_cobro_id (FK)         │
        │ usuario_id (FK)              │
        │ etapa_anterior, etapa_nueva  │
        │ estado_anterior, estado_nuevo│
        │ descripcion, fecha_creacion  │
        └──────────────────────────────┘

        ┌──────────────────────────────┐
        │    interaccion               │
        │  (Comentarios - existente)   │
        ├──────────────────────────────┤
        │ id (PK)                      │
        │ cuenta_cobro_id (FK)         │
        │ user_id (FK)                 │
        │ comentario, tipo             │
        │ fecha_creacion               │
        └──────────────────────────────┘
```

---

## 🔐 Seguridad y Autenticación

### Middleware de Autenticación

```php
// routes/web.php
Route::middleware('auth')->group(function () {
    // Rutas que requieren login
    
    Route::middleware('role:admin,supervisor,ordenador,etc')->group(function () {
        // Rutas específicas por rol
    });
    
    Route::middleware('permission:puede_ver_todas_cuentas')->group(function () {
        // Rutas que requieren permiso específico
    });
});
```

---

### Validaciones de Permiso

```php
// En cada controller
public function enviarAlSiguiente(Request $request, $id)
{
    $cuenta = CuentaCobro::find($id);
    $user = Auth::user();
    
    // Validación 1: ¿Tiene rol correcto?
    if (!$user->can('puede_aprobar')) {
        abort(403, "No tienes permiso para aprobar");
    }
    
    // Validación 2: ¿Está en etapa correcta?
    if ($user->atributos->obtenerEtapaAprobacion() != $cuenta->etapa) {
        abort(403, "No es tu turno de aprobar");
    }
    
    // Validación 3: ¿El monto está dentro de su límite?
    if (!$user->atributos->puedeAprobarValor($cuenta->valor_total)) {
        abort(403, "El monto excede tu límite de aprobación");
    }
    
    // Validación 4: ¿Tiene documentos obligatorios?
    if (!$cuenta->tieneTodosDocumentosObligatorios()) {
        // Advertir pero permitir continuar (configurable)
    }
    
    // ... procesar aprobación
}
```

---

## 🎯 Patrones de Código

### Patrón 1: Scopes (Eloquent)

```php
// Model
class CuentaCobro extends Model {
    public function scopeArchived($query) {
        return $query->whereNotNull('archived_at');
    }
    
    public function scopeNotArchived($query) {
        return $query->whereNull('archived_at');
    }
    
    public function scopeByUser($query, User $user) {
        return $query->where('user_id', $user->id);
    }
}

// Uso
CuentaCobro::archived()->get();
CuentaCobro::notArchived()->byUser($user)->get();
CuentaCobro::where('etapa', 'supervisor')->notArchived()->get();
```

---

### Patrón 2: Transacciones DB

```php
DB::transaction(function () {
    // Actualizar cuenta
    $cuenta->update(['etapa' => 'ordenador_gasto']);
    
    // Crear historial
    $cuenta->cuentaCobroHistorials()->create([
        'etapa_anterior' => 'supervisor',
        'etapa_nueva' => 'ordenador_gasto',
        'usuario_id' => auth()->id(),
    ]);
    
    // Crear notificación
    Notificacion::create([
        'cuenta_cobro_id' => $cuenta->id,
        'rol_destino' => 'ordenador_gasto',
        'tipo' => 'pendiente_aprobacion',
    ]);
});
// Si algo falla, ROLLBACK automático
```

---

### Patrón 3: API Response

```php
public function enviarAlSiguiente(Request $request, $id)
{
    try {
        // ... lógica
        
        return response()->json([
            'success' => true,
            'mensaje' => 'Cuenta enviada correctamente',
            'cuenta' => $cuenta->load('documentos', 'interacciones'),
            'siguienteRol' => $siguienteRol,
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 422);
    }
}
```

---

## 📈 Escalabilidad

### Consideraciones para Producción

1. **Índices de Base de Datos**
   - Todos los FK están indexados
   - Campos de búsqueda común (etapa, estado, archivado_at) tienen índices
   - Considerar índices compuestos para queries complejas

2. **Paginación**
   ```php
   CuentaCobro::paginate(15);  // Devuelve 15 registros por página
   ```

3. **Queries Optimizadas**
   ```php
   CuentaCobro::with('documentos', 'user', 'interacciones')->get();
   // "with" carga relaciones y evita N+1 queries
   ```

4. **Caché**
   ```php
   Cache::remember('permisos_usuario_' . auth()->id(), 3600, function () {
       return PermisoGranular::byRol(auth()->user()->role_id)->get();
   });
   ```

5. **Colas (Queues) para Emails**
   ```php
   Mail::queue(new AprobacionNotificacion($cuenta));
   // En lugar de enviar sincrónico
   ```

---

## 🧪 Testing

### Tests Sugeridos

```php
// tests/Feature/DocumentoTest.php
public function test_usuario_puede_subir_documento()
{
    $user = User::factory()->create();
    $cuenta = CuentaCobro::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/documentos/guardar/' . $cuenta->id, [
            'documento' => UploadedFile::fake()->pdf('test.pdf'),
            'categoria' => 'comprobante_pago',
        ]);
    
    $response->assertStatus(200);
    $this->assertDatabaseHas('documentos', [
        'cuenta_cobro_id' => $cuenta->id,
    ]);
}

// tests/Feature/AprobacionTest.php
public function test_supervisor_puede_aprobar_cuenta()
{
    $supervisor = User::factory()->create();
    $supervisor->assignRole('Supervisor');
    
    $cuenta = CuentaCobro::factory()->create(['etapa' => 'supervisor']);
    
    $response = $this->actingAs($supervisor)
        ->post('/aprobaciones/' . $cuenta->id . '/enviar-siguiente', [
            'comentario' => 'Aprobada',
        ]);
    
    $response->assertStatus(200);
    $this->assertEquals('ordenador_gasto', $cuenta->fresh()->etapa);
}
```

---

## 📚 Referencias Arquitectónicas

- **Laravel Docs**: https://laravel.com/docs
- **Eloquent ORM**: https://laravel.com/docs/eloquent
- **Database Transactions**: https://laravel.com/docs/database#transactions
- **Middleware**: https://laravel.com/docs/middleware
- **Authorization (Policies)**: https://laravel.com/docs/authorization

---

**Última Actualización**: Noviembre 29, 2025  
**Versión**: 3.0  
**Arquitecto**: AI Assistant


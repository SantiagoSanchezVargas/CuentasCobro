# 🚀 GUÍA DE MEJORAS IMPLEMENTADAS - CuentasCobro v3.0

## 📋 Tabla de Contenidos
1. [Resumen de Mejoras](#resumen-de-mejoras)
2. [Nuevas Tablas y Modelos](#nuevas-tablas-y-modelos)
3. [Mejoras en Cuentas de Cobro](#mejoras-en-cuentas-de-cobro)
4. [Sistema de Documentos](#sistema-de-documentos)
5. [Permisos Granulares](#permisos-granulares)
6. [Aprobaciones Mejoradas](#aprobaciones-mejoradas)
7. [Atributos de Usuario](#atributos-de-usuario)
8. [Rutas Nuevas](#rutas-nuevas)
9. [Guía de Instalación](#guía-de-instalación)
10. [Preguntas Frecuentes](#preguntas-frecuentes)

---

## 🎯 Resumen de Mejoras

Se han implementado 7 mejoras principales para convertir el sistema en una solución profesional, completa y funcional:

### ✅ 1. **Sistema Integral de Documentos**
- ✅ Subir y gestionar documentos en cada cuenta
- ✅ Versionamiento de documentos
- ✅ Control de acceso granular
- ✅ Historial completo de cambios
- ✅ Categorización y etiquetado

### ✅ 2. **Aprobaciones Mejoradas con Modales**
- ✅ Interfaz moderna con ventanas emergentes
- ✅ Botones de aprobación/rechazo/devolución
- ✅ Permiso para devolver para correcciones
- ✅ Resumen financiero en tiempo real
- ✅ Historial visual completo (timeline)

### ✅ 3. **Historial de Seguimiento Avanzado**
- ✅ Timeline completo con todos los eventos
- ✅ Filtros por tipo de acción
- ✅ Búsqueda avanzada
- ✅ Vista de quién hizo qué y cuándo
- ✅ Integración con interacciones y documentos

### ✅ 4. **Bandeja de Archivados**
- ✅ Gestión de cuentas finalizadas
- ✅ Búsqueda por criterios
- ✅ Desarchivado rápido
- ✅ Reporte de cuentas archivadas
- ✅ Control de acceso por rol

### ✅ 5. **Permisos Granulares por Rol**
- ✅ Matriz de permisos configurable
- ✅ Control por etapa del flujo
- ✅ Restricción de campos visibles/editables
- ✅ Límites de aprobación por monto
- ✅ Plantillas predefinidas por rol

### ✅ 6. **Mejoras en Campos de Cuentas de Cobro**
- ✅ Descuentos y retenciones detalladas
- ✅ Pago anticipado
- ✅ Información bancaria ampliada
- ✅ Datos fiscales (NIT, RUT, etc.)
- ✅ Campos de auditoría mejorados

### ✅ 7. **Atributos de Usuario Mejorados**
- ✅ Información personal detallada
- ✅ Información laboral y departamentos
- ✅ Firma digital
- ✅ Delegación de poderes
- ✅ Límites de aprobación personalizados

---

## 🗂️ Nuevas Tablas y Modelos

### 📌 Tabla: `documentos`
Almacena todos los documentos (archivos) adjuntos a las cuentas de cobro.

**Campos principales:**
```
- id (PK)
- cuenta_cobro_id (FK) - Relación con CuentaCobro
- nombre_original - Nombre del archivo subido
- nombre_almacenado - Nombre en el servidor
- tipo_documento - factura | contrato | comprobante | otro
- categoria - soporte | contrato | comprobante_pago | anexo
- mime_type - Tipo MIME del archivo
- tamaño_bytes - Tamaño en bytes
- user_id (FK) - Quién lo subió
- version - Número de versión
- documento_anterior_id - Para versionamiento
- visibilidad - private | internal | public
- roles_acceso - Array JSON de roles que pueden verlo
- cantidad_descargas - Contador de descargas
- fecha_subida - Timestamp de subida
- escaneado_virus - Flag de seguridad
```

**Modelo: `App\Models\Documento`**
```php
- Relaciones: cuentaCobro(), usuario()
- Scopes: notArchived(), visiblesParaUsuario(), byTipo(), byCategoria()
- Métodos: registrarDescarga(), crearNuevaVersion(), archivar(), puedeDescargar()
```

---

### 📌 Tabla: `atributos_usuario`
Información adicional de cada usuario (departamento, puesto, límites, etc.).

**Campos principales:**
```
- id (PK)
- user_id (FK, UNIQUE) - Relación con User
- nombre_completo, apellidos
- telefono, extension, celular_personal, email_alterno
- departamento - Ej: "Tesorería", "Contratación"
- puesto - Ej: "Jefe", "Asistente", "Coordinador"
- nivel_jerarquico - 0-5 para reportes
- firma_electronica - Imagen en base64
- numero_firma_digital - Certificado digital
- notificaciones_email, notificaciones_sms
- user_id_delegado - A quién delega
- fecha_inicio_delegacion, fecha_fin_delegacion
- limite_aprobacion_valor - Monto máximo
- limite_cuentas_simultaneas - Cuántas a la vez
- dias_para_aprobar - Plazo estándar
- ultimo_login_at - Auditoría
```

**Modelo: `App\Models\AtributoUsuario`**
```php
- Relaciones: usuario(), usuarioDelegado()
- Métodos: getNombreCompleto(), tieneDelegacionActiva(), puedeAprobarValor()
- Auditoría: registrarLogin(), registrarIntentoFallido()
```

---

### 📌 Tabla: `permisos_granulares`
Matriz configurable de permisos por rol.

**Campos principales:**
```
- id (PK)
- role_id (FK) - Relación con Role
- etapa_flujo - supervisor | ordenador_gasto | etc. (null = todas)
- estado_requerido - en_revision | aprobado | etc. (null = todos)

** Permisos booleanos:**
- puede_crear, puede_leer, puede_editar, puede_eliminar
- puede_aprobar, puede_rechazar, puede_devolver
- puede_devolver_correccion, puede_comentar
- puede_subir_documentos, puede_descargar_documentos
- puede_registrar_pago, puede_enviar_cliente
- puede_archivar, puede_ver_todas_cuentas
- puede_ver_reportes, puede_gestionar_usuarios
- puede_gestionar_contratos

** Restricciones:**
- campos_visibles - Array JSON de campos que puede ver
- campos_editables - Array JSON de campos que puede editar
- roles_visibles - Array de roles cuyas cuentas puede ver
- departamentos_visibles - Array de departamentos
- valor_minimo_aprobacion, valor_maximo_aprobacion
- requiere_segundo_aprobador
```

**Modelo: `App\Models\PermisoGranular`**
```php
- Scopes: activos(), byRol(), byEtapa()
- Métodos: tienePermiso(), esVigente(), puedeVerCuenta()
- Validación: puedeAprobarValor()
```

---

### 📌 Mejoras a tabla: `cuentas_cobro`

Se agregaron **27 campos nuevos** para soporte contable completo:

**Cálculo Detallado:**
```
- subtotal
- descuento_valor, descuento_porcentaje
- iva_porcentaje, iva_valor
```

**Retenciones Mejoradas:**
```
- retencion_fuente_porcentaje, retencion_fuente_valor
- retencion_ica_porcentaje, retencion_ica_valor
- retencion_iva_porcentaje, retencion_iva_valor
- otras_retenciones_valor
```

**Anticipo:**
```
- tiene_anticipo (boolean)
- valor_anticipo
- valor_pendiente_pago
- referencia_anticipo
- fecha_pago_anticipado
```

**Información Bancaria:**
```
- tipo_cuenta_beneficiario (ahorros | corriente)
- numero_cuenta_beneficiario
- banco_beneficiario
- cuenta_corriente_usuario
```

**Información Fiscal:**
```
- nit_beneficiario
- rut_url (URL del RUT)
- responsable_iva (boolean)
- gran_contribuyente (boolean)
```

**Control:**
```
- numero_orden_compra
- numero_cdp
- numero_rgp
- fecha_vencimiento_factura
```

**Observaciones y Auditoría:**
```
- observaciones_internas
- justificacion_rechazo
- justificacion_devolucion
- fecha_ultima_modificacion
- modificado_por (FK a users)
```

---

## 💰 Mejoras en Cuentas de Cobro

### Métodos Helper Nuevos

```php
// Cálculo financiero
$cuenta->calcularValorTotalDetallado()    // Calcula desde componentes
$cuenta->recalcularRetenciones()         // Recalcula automáticamente
$cuenta->getResumenFinanciero()          // Array con desglose completo

// Documentos
$cuenta->tieneTodosDocumentosObligatorios()  // Validación
$cuenta->getDocumentosFaltantes()            // Array de documentos faltantes

// Estados y seguimiento
$cuenta->getEstadoConDetalles()              // Estado + metadata
$cuenta->getHistorialCompleto()              // Timeline con todos los eventos
$cuenta->registrarModificacion($user)        // Auditoría automática

// Gestión de archivos
$cuenta->archivar()                          // Marcar como archivada
$cuenta->desarchivizar()                     // Desarchivizar
$cuenta->puedeSerArchivadaPor($user)        // Validación de permisos
```

### Relaciones Nuevas

```php
$cuenta->documentos()        // Todos los documentos adjuntos
$cuenta->modificadoPorUsuario()  // Usuario que última modificó
```

---

## 📄 Sistema de Documentos

### Características

1. **Subida de Archivos**
   - Tipos permitidos: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG
   - Límite de 10MB por archivo
   - Almacenamiento en carpeta `storage/app/public/documentos/`

2. **Versionamiento**
   - Cada nuevo archivo sube como nueva versión
   - Se mantiene historial de versiones anteriores
   - Acceso rápido a versión anterior

3. **Control de Acceso**
   - `private`: Solo quien lo subió
   - `internal`: Roles específicos del sistema
   - `public`: Acceso público

4. **Categorización**
   - soporte: Documentación general
   - contrato: Contrato relacionado
   - comprobante_pago: Comprobante de pago
   - anexo: Documentos anexos

5. **Auditoría**
   - Contador de descargas
   - Fecha de última descarga
   - Usuario que lo subió
   - Escaneo de virus (preparado para integración)

### Controlador: `DocumentoController`

**Métodos principales:**

```php
- index($cuentaCobroId)              // Listar documentos
- create($cuentaCobroId)             // Formulario de carga
- store(Request, $cuentaCobroId)    // Guardar documento
- descargar($documentoId)            // Descargar archivo
- ver($documentoId)                  // Ver en línea
- destroy($documentoId)              // Eliminar documento
- crearVersion(Request, $documentoId) // Nueva versión
- versiones($documentoId)            // Ver historial
- archivar($documentoId)             // Archivar documento
- desarchivizar($documentoId)        // Desarchivizar
```

---

## 🔐 Permisos Granulares

### Concepto

En lugar de solo roles, ahora tienes una **matriz de permisos configurable** que permite especificar exactamente qué puede hacer cada rol en cada etapa del flujo.

### Ventajas

- ✅ Control fino por etapa del flujo
- ✅ Límites de aprobación por monto
- ✅ Restricción de campos visibles/editables
- ✅ Delegación de poderes con validación
- ✅ Vigencia de permisos (fecha inicio/fin)
- ✅ Segundo aprobador requerido (cuando sea necesario)

### Plantillas Predefinidas

Se incluyen 7 plantillas automáticas:

1. **Contratista**
   - ✅ Crear, leer, editar cuentas propias
   - ✅ Subir documentos
   - ✅ Comentar
   - ✅ Archivar propias cuentas

2. **Supervisor**
   - ✅ Leer cuentas en su etapa
   - ✅ Aprobar/Rechazar
   - ✅ Comentar
   - ✅ Ver reportes

3. **Ordenador del Gasto**
   - ✅ Ver TODAS las cuentas
   - ✅ Aprobar/Rechazar/Devolver
   - ✅ Enviar al cliente
   - ✅ Ver reportes
   - ✅ Límite: $200M

4. **Contratación**
   - ✅ Validar contratos
   - ✅ Devolver para corrección
   - ✅ Gestionar contratos
   - ✅ Límite: $100M

5. **Alcalde**
   - ✅ Aprobación final ejecutiva
   - ✅ Ver TODAS las cuentas
   - ✅ Aprobar/Rechazar/Devolver
   - ✅ Enviar al cliente

6. **Tesorería**
   - ✅ Registrar pagos
   - ✅ Enviar al cliente
   - ✅ Comentar
   - ✅ Ver reportes

7. **Super Admin**
   - ✅ TODOS los permisos

### Controlador: `PermisoController`

```php
- index()                           // Mostrar matriz
- create()                          // Crear permiso
- store(Request)                    // Guardar
- edit($id)                         // Formulario edición
- update(Request, $id)              // Actualizar
- destroy($id)                      // Eliminar
- matrizJson()                      // JSON para AJAX
- aplicarPlantilla(Request, $roleId) // Aplicar plantilla
```

---

## ✅ Aprobaciones Mejoradas

### Características Nuevas

1. **Modales Emergentes**
   - Ventana modal para cada acción
   - Información de la cuenta visible
   - Campos de texto para motivos

2. **Resumen Financiero en Vivo**
   - Desglose de subtotal, descuentos, impuestos, retenciones
   - Valor total destacado
   - Validaciones automáticas

3. **Documentos Obligatorios**
   - Verificación de documentos requeridos
   - Advertencia si faltan documentos
   - Puede proceder (depende de política)

4. **Opciones de Intervención**

   **Enviar al Siguiente Nivel**
   ```
   - Comentario opcional
   - Notifica automáticamente al siguiente rol
   - Registra en historial
   ```

   **Rechazar**
   ```
   - Motivo obligatorio
   - Justificación adicional (opcional)
   - Finaliza el proceso
   - Notifica al contratista
   ```

   **Devolver a Etapa Anterior**
   ```
   - Disponible para: Ordenador, Contratación, Alcalde, Tesorería
   - Motivo obligatorio
   - Regresa UNA etapa atrás
   ```

   **Devolver para Corrección** (solo Contratación)
   ```
   - Errores MENORES de forma
   - Contratista puede editar y reenviar
   - Vuelve a SUPERVISOR (reinicia flujo)
   ```

   **Agregar Interacción**
   ```
   - Comentario sin cambiar estado
   - Tipos: nota, recordatorio, llamada, email, etc.
   - No afecta el flujo
   ```

### Controlador: `AprobacionController`

```php
- mostrarModalAprobacion($id)       // Datos para modal
- enviarAlSiguiente(Request, $id)   // Enviar
- rechazar(Request, $id)            // Rechazar
- devolverAnterior(Request, $id)    // Devolver
- devolverCorreccion(Request, $id)  // Corrección
- agregarInteraccion(Request, $id)  // Comentario
- obtenerHistorial($id)             // Timeline
```

---

## 👤 Atributos de Usuario

### Información Personal

```php
- nombre_completo
- apellidos
- telefono, extension
- celular_personal
- email_alterno
```

### Información Laboral

```php
- departamento (Tesorería, Contratación, etc.)
- puesto (Jefe, Asistente, Coordinador)
- codigo_empleado
- nivel_jerarquico (0-5)
```

### Firma Digital

```php
- firma_electronica (imagen base64)
- numero_firma_digital (certificado)
- fecha_vencimiento_firma
```

### Delegación de Poderes

```php
- puede_delegar (boolean)
- user_id_delegado (a quién delega)
- fecha_inicio_delegacion
- fecha_fin_delegacion
```

### Límites y Controles

```php
- limite_aprobacion_valor        // Monto máximo
- limite_cuentas_simultaneas     // Cuántas a la vez
- dias_para_aprobar              // Plazo estándar
```

### Auditoría

```php
- ultimo_ip_login
- ultimo_login_at
- intentos_fallidos_login
```

### Modelo: `App\Models\AtributoUsuario`

**Métodos útiles:**

```php
$usuario->atributos->getNombreCompleto()
$usuario->atributos->getInformacionLaboral()
$usuario->atributos->getContactos()
$usuario->atributos->tieneDelegacionActiva()
$usuario->atributos->puedeAprobarValor(1000000)
$usuario->atributos->registrarLogin('192.168.1.1')
```

---

## 🛣️ Rutas Nuevas

### Gestión de Documentos

```
GET    /documentos/cuentas/{cuentaCobroId}          Ver documentos
GET    /documentos/crear/{cuentaCobroId}            Formulario
POST   /documentos/guardar/{cuentaCobroId}          Subir
GET    /documentos/{documentoId}/descargar          Descargar
GET    /documentos/{documentoId}/ver                Ver en línea
DELETE /documentos/{documentoId}                    Eliminar
POST   /documentos/{documentoId}/version            Nueva versión
GET    /documentos/{documentoId}/versiones          Historial
POST   /documentos/{documentoId}/archivar           Archivar
POST   /documentos/{documentoId}/desarchivizar      Desarchivizar
```

### Aprobaciones Mejoradas

```
POST   /aprobaciones/{cuentaId}/modal               Datos para modal
POST   /aprobaciones/{cuentaId}/enviar-siguiente    Enviar
POST   /aprobaciones/{cuentaId}/rechazar            Rechazar
POST   /aprobaciones/{cuentaId}/devolver-anterior   Devolver
POST   /aprobaciones/{cuentaId}/devolver-correccion Corrección
POST   /aprobaciones/{cuentaId}/interaccion         Comentario
GET    /aprobaciones/{cuentaId}/historial           Timeline
```

### Gestión de Permisos

```
GET    /admin/permisos/                             Matriz
GET    /admin/permisos/crear                        Crear
POST   /admin/permisos/guardar                      Guardar
GET    /admin/permisos/{id}/editar                  Editar
PUT    /admin/permisos/{id}                         Actualizar
DELETE /admin/permisos/{id}                         Eliminar
GET    /admin/permisos/matriz-json                  JSON
POST   /admin/permisos/{roleId}/plantilla           Aplicar plantilla
```

---

## 📦 Guía de Instalación

### Paso 1: Migrar la Base de Datos

```bash
# Ejecutar todas las migraciones
php artisan migrate

# O específicamente las nuevas:
php artisan migrate --path=database/migrations/2025_11_29_100000_create_documentos_table.php
php artisan migrate --path=database/migrations/2025_11_29_100100_create_atributos_usuario_table.php
php artisan migrate --path=database/migrations/2025_11_29_100200_create_permisos_granulares_table.php
php artisan migrate --path=database/migrations/2025_11_29_100300_enhance_cuentas_cobro_fields.php
```

### Paso 2: Ejecutar Seeders

```bash
# Crear permisos granulares predefinidos
php artisan db:seed --class=PermisoGranularSeeder

# Crear atributos para usuarios existentes
php artisan db:seed --class=AtributosUsuarioSeeder

# O todos juntos
php artisan db:seed
```

### Paso 3: Crear Directorios de Almacenamiento

```bash
# Crear carpetas para documentos
mkdir -p storage/app/public/documentos/cuentas_cobro

# Crear enlace simbólico (si no existe)
php artisan storage:link
```

### Paso 4: Compilar Assets

```bash
# Compilar CSS y JS
npm run build

# O en modo desarrollo
npm run dev
```

### Paso 5: Limpiar Caché

```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
```

---

## ❓ Preguntas Frecuentes

### P: ¿Cómo subo documentos a una cuenta?
**R:** Ve a la vista de detalle de la cuenta, busca la sección "Documentos", haz clic en "Subir Documento", selecciona el archivo (máx 10MB) y asigna una categoría.

### P: ¿Qué tipos de archivo puedo subir?
**R:** PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG. Máximo 10MB por archivo.

### P: ¿Puedo ver el historial completo de la cuenta?
**R:** Sí, en la vista de detalle hay una sección "Timeline" que muestra todos los cambios, aprobaciones, documentos, interacciones, etc.

### P: ¿Cómo configuro los permisos de cada rol?
**R:** Ve a **Admin > Permisos**, edita el rol que deseas, configura los permisos específicos. O usa una plantilla predefinida para ahorrar tiempo.

### P: ¿Puedo delegar mis aprobaciones a otro usuario?
**R:** Sí, desde tu perfil puedes configurar una delegación temporal. El sistema notificará al usuario delegado automáticamente.

### P: ¿Qué pasa si rechazamos una cuenta?
**R:** Se marca como "Rechazado" y el contratista recibe una notificación con el motivo. NO se puede reabrir, debe crear una nueva.

### P: ¿Se pueden devolver cuentas para corrección?
**R:** Solo **Contratación** puede devolver para corrección. Se marca como "En Corrección", el contratista puede editar, y al reenviar vuelve a **Supervisor**.

### P: ¿Cuánto tiempo tengo para aprobar una cuenta?
**R:** Depende de tu rol y atributos:
- Supervisor: 3 días
- Contratación: 3 días
- Ordenador: 2 días
- Alcalde: 2 días
(Configurable por usuario)

### P: ¿Cómo veo qué usuarios están en cada departamento?
**R:** Ve a **Admin > Usuarios**, verás el departamento de cada usuario en la lista. Filtra por departamento.

### P: ¿Se registra quién hace cada cambio?
**R:** Sí, el timeline muestra usuario, fecha, hora y acción para TODOS los cambios.

### P: ¿Puedo ver cuentas de otros departamentos?
**R:** Depende de tus permisos. Algunos roles (Ordenador, Alcalde) ven TODAS. Otros solo ven su etapa. Se controla con permisos granulares.

### P: ¿Qué es "En Corrección"?
**R:** Es un estado especial cuando Contratación devuelve una cuenta para correcciones menores. El contratista puede editar y reenviar sin crear una nueva.

### P: ¿Se pueden archivar cuentas?
**R:** Sí, el contratista puede archivar sus propias cuentas finalizadas. Las pueden desarchivizar en cualquier momento.

### P: ¿Cómo se notifica a los usuarios?
**R:** Automáticamente cuando:
- Cuenta es creada → Notifica a Supervisor
- Supervisor aprueba → Notifica a Ordenador
- Ordenador aprueba → Notifica a Contratación
- Contratación aprueba → Notifica a Alcalde
- Alcalde aprueba → Notifica a Tesorería y Contratista
- Cuenta es rechazada → Notifica a Contratista
- Pago es registrado → Notifica a Contratista

### P: ¿Cómo manejo cuentas de muy alto valor?
**R:** Configura permiso "Requiere Segundo Aprobador". El sistema pedirá confirmación de otro aprobador antes de proceder.

---

## 🔒 Seguridad

### Validaciones Implementadas

- ✅ Validación de permisos en cada acción
- ✅ Middleware de autenticación
- ✅ Sanitización de inputs
- ✅ Protección CSRF en todos los formularios
- ✅ Hash de archivos para integridad
- ✅ Control de acceso a documentos por roles
- ✅ Auditoría completa de cambios
- ✅ Límites de tamaño de archivo

### Recomendaciones

1. **Firmas Digitales**: Integra con proveedores de firma digital (DIGICERT, Adobe Sign, etc.)
2. **Escaneo de Virus**: Integra con ClamAV o VirusTotal para archivos
3. **Encriptación**: Considera encriptar documentos sensibles en almacenamiento
4. **Backups**: Realizar backups regulares de documentos
5. **Auditoría Externa**: Revisar logs regularmente para detectar anomalías

---

## 📊 Reportes Disponibles

Los nuevos campos permiten reportes mejorados:

1. **Reporte de Cuentas Archivadas**
   - Por período
   - Por contratista
   - Por departamento
   - Por monto

2. **Reporte de Aprobaciones**
   - Tiempo promedio por etapa
   - Tasa de rechazo
   - Usuarios con más aprobaciones

3. **Reporte Financiero Detallado**
   - Desglose de retenciones
   - Cuentas con anticipos
   - Análisis de descuentos

4. **Reporte de Delegaciones**
   - Quién ha delegado a quién
   - Validez de delegaciones
   - Historial de cambios

---

## 🚀 Próximas Mejoras Sugeridas

1. **API REST**: Crear API para integración con sistemas externos
2. **Firma Digital**: Integración con proveedores de firma
3. **Pagos Online**: Integración con pasarelas de pago
4. **OCR**: Escaneo automático de documentos
5. **Notificaciones SMS**: Alertas por mensaje de texto
6. **Aplicación Móvil**: App para aprobación desde móvil
7. **Dashboard Ejecutivo**: Gráficas en tiempo real
8. **Auditoría Avanzada**: Trazabilidad forense completa

---

## 📞 Soporte

Para problemas o dudas:

1. Revisar esta guía y el FAQ
2. Consultar el historial de la cuenta
3. Contactar a administrador del sistema
4. Revisar logs en `storage/logs/`

---

**Versión**: 3.0  
**Fecha**: Noviembre 29, 2025  
**Estado**: Listo para producción ✅


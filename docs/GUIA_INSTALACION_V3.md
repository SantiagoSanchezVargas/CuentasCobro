# ⚙️ GUÍA DE INSTALACIÓN Y CONFIGURACIÓN - CuentasCobro v3.0

## 🚀 Guía Paso a Paso

### **PASO 1: Ejecutar Migraciones de Base de Datos**

Las migraciones crean las nuevas tablas y campos en la base de datos.

#### Opción A: Todos de una vez

```bash
php artisan migrate
```

#### Opción B: Una por una (recomendado para verificar)

```bash
# Tabla de documentos
php artisan migrate --path=database/migrations/2025_11_29_100000_create_documentos_table.php

# Tabla de atributos de usuario
php artisan migrate --path=database/migrations/2025_11_29_100100_create_atributos_usuario_table.php

# Tabla de permisos granulares
php artisan migrate --path=database/migrations/2025_11_29_100200_create_permisos_granulares_table.php

# Mejoras en cuentas de cobro (27 campos nuevos)
php artisan migrate --path=database/migrations/2025_11_29_100300_enhance_cuentas_cobro_fields.php
```

#### Verificar:

```bash
# Listar tablas de la BD
php artisan tinker
# En el prompt:
>>> DB::select("SHOW TABLES")
# Deberías ver: documentos, atributos_usuario, permisos_granulares
```

---

### **PASO 2: Ejecutar Seeders (Datos Iniciales)**

Los seeders crean los datos por defecto para que el sistema funcione.

#### Seeder 1: Permisos Granulares

```bash
php artisan db:seed --class=PermisoGranularSeeder
```

**Qué hace:**
- Crea matriz de permisos para los 7 roles
- Define qué puede hacer cada rol
- Aplica plantillas predefinidas

**Verificar:**
```bash
php artisan tinker
>>> App\Models\PermisoGranular::count()
# Debería mostrar un número > 0
>>> App\Models\PermisoGranular::first()
# Debería mostrar registros con permisos
```

---

#### Seeder 2: Atributos de Usuario

```bash
php artisan db:seed --class=AtributosUsuarioSeeder
```

**Qué hace:**
- Crea atributos para cada usuario existente
- Asigna departamento y puesto por rol
- Configura límites de aprobación
- Establece datos de contacto

**Verificar:**
```bash
php artisan tinker
>>> App\Models\AtributoUsuario::count()
# Debería igualar cantidad de usuarios en la BD
>>> App\Models\AtributoUsuario::with('usuario')->first()
# Debería mostrar datos del usuario relacionado
```

---

#### Ejecutar todos los seeders a la vez

```bash
php artisan db:seed
```

---

### **PASO 3: Crear Directorios de Almacenamiento**

Los documentos se guardarán en carpetas específicas.

#### En Windows (PowerShell):

```powershell
# Crear carpetas
New-Item -ItemType Directory -Force -Path "storage/app/public/documentos/cuentas_cobro"
New-Item -ItemType Directory -Force -Path "storage/app/public/documentos/contratos"
New-Item -ItemType Directory -Force -Path "storage/app/public/documentos/comprobantes"
New-Item -ItemType Directory -Force -Path "storage/app/public/documentos/versiones"

# Dar permisos (si es necesario)
icacls "storage/app/public/documentos" /grant Users:F /T
```

#### En Linux/Mac:

```bash
mkdir -p storage/app/public/documentos/cuentas_cobro
mkdir -p storage/app/public/documentos/contratos
mkdir -p storage/app/public/documentos/comprobantes
mkdir -p storage/app/public/documentos/versiones

chmod -R 775 storage/app/public/documentos
```

#### Crear enlace simbólico (si no existe):

```bash
php artisan storage:link
```

**Verificar:**
```bash
ls -la public/storage/
# Debería mostrar "documentos" como enlace simbólico
```

---

### **PASO 4: Compilar Assets (CSS/JavaScript)**

Compila los archivos CSS y JavaScript.

```bash
# Instalar dependencias (si es primera vez)
npm install

# Compilar en modo producción
npm run build

# O en modo desarrollo (más rápido, pero no optimizado)
npm run dev

# O modo "watch" (recompila cuando guardas)
npm run watch
```

---

### **PASO 5: Limpiar Caché**

Limpia el caché de Laravel para que tome los cambios.

```bash
# Limpiar todo
php artisan optimize:clear

# O individual
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Reconstruir caché
php artisan config:cache
php artisan route:cache
```

---

### **PASO 6: Verificar Instalación**

Prueba que todo está funcionando.

#### Ruta 1: Verificar Models

```bash
php artisan tinker

# Verificar Documento
>>> App\Models\Documento::count()

# Verificar PermisoGranular
>>> App\Models\PermisoGranular::count()

# Verificar AtributoUsuario
>>> App\Models\AtributoUsuario::count()

# Salir
>>> exit
```

#### Ruta 2: Verificar Rutas

```bash
php artisan route:list | grep -E "(documento|aprobacion|permiso)"
# Debería mostrar todas las nuevas rutas
```

#### Ruta 3: Verificar Base de Datos

```bash
php artisan tinker

# Revisar tabla documentos
>>> DB::table('documentos')->count()

# Revisar tabla atributos_usuario
>>> DB::table('atributos_usuario')->count()

# Revisar tabla permisos_granulares
>>> DB::table('permisos_granulares')->count()

# Revisar campos nuevos en cuentas_cobro
>>> DB::table('cuentas_cobro')->first()
# Debería mostrar los campos: subtotal, descuento_valor, iva_valor, etc.
```

---

## 🔍 Verificación Detallada

### Verificar Migraciones

```bash
# Ver estado de migraciones
php artisan migrate:status

# Debería mostrar como "Ran" las migraciones 2025_11_29_*
```

---

### Verificar Relaciones de Models

```bash
php artisan tinker

# Verificar relación CuentaCobro -> Documentos
>>> $cuenta = App\Models\CuentaCobro::first()
>>> $cuenta->documentos
# Debería retornar relación o colección vacía

# Verificar relación User -> Atributos
>>> $user = App\Models\User::first()
>>> $user->atributos
# Debería retornar el AtributoUsuario

# Verificar relación PermisoGranular -> Role
>>> $permiso = App\Models\PermisoGranular::first()
>>> $permiso->role
# Debería retornar el Role
```

---

### Verificar Campos de BD

```bash
php artisan tinker

# Listar columnas de tabla documentos
>>> DB::connection()->getSchemaBuilder()->getColumnListing('documentos')

# Listar columnas de tabla atributos_usuario
>>> DB::connection()->getSchemaBuilder()->getColumnListing('atributos_usuario')

# Listar columnas de tabla permisos_granulares
>>> DB::connection()->getSchemaBuilder()->getColumnListing('permisos_granulares')

# Verificar nuevos campos en cuentas_cobro
>>> DB::connection()->getSchemaBuilder()->getColumnListing('cuentas_cobro')
# Debería incluir: subtotal, descuento_valor, iva_valor, etc.
```

---

## ⚠️ Solución de Problemas

### Problema: "Migration not found"

**Causa:** Laravel no encuentra el archivo de migración.

**Solución:**
```bash
# Verificar que los archivos existen en:
ls database/migrations/ | grep 2025_11_29

# Si no existen, crear los archivos nuevamente
# Verificar la ruta sea correcta: /database/migrations/
```

---

### Problema: "SQLSTATE: Syntax error in create table"

**Causa:** Error en la migración (SQL inválido).

**Solución:**
```bash
# Hacer rollback
php artisan migrate:rollback

# Revisar el archivo de migración para errores
# Corregir y ejecutar de nuevo
php artisan migrate
```

---

### Problema: "Class 'App\Models\Documento' not found"

**Causa:** Laravel no encuentra el modelo.

**Solución:**
```bash
# Limpiar autoloader de Composer
composer dump-autoload

# Verificar archivo existe: /app/Models/Documento.php
# Verificar namespace: namespace App\Models;
```

---

### Problema: "Directory is not writable"

**Causa:** Permisos insuficientes en carpeta storage.

**Solución (Windows):**
```powershell
icacls "storage" /grant Users:F /T
```

**Solución (Linux/Mac):**
```bash
chmod -R 777 storage
chmod -R 777 bootstrap/cache
```

---

### Problema: Seeder no ejecuta

**Causa:** Generalmente error en el código del seeder.

**Solución:**
```bash
# Ejecutar con detalle de error
php artisan db:seed --class=PermisoGranularSeeder --verbose

# Ver error en logs
tail -f storage/logs/laravel.log
```

---

### Problema: Rutas nuevas retornan 404

**Causa:** Caché de rutas antigua.

**Solución:**
```bash
php artisan route:clear
php artisan route:cache
```

---

### Problema: "Table already exists"

**Causa:** Tabla ya existe en la BD (migración ejecutada previamente).

**Solución:**
```bash
# Ver estado de migraciones
php artisan migrate:status

# Si aparece como "Ran", no hacer nada
# Si necesitas refrescar todo (¡CUIDADO - borra datos!):
php artisan migrate:fresh --seed
```

---

## 📊 Estado Esperado Después de Instalación

### Tablas Nuevas
```
✅ documentos
✅ atributos_usuario
✅ permisos_granulares
```

### Campos Nuevos en cuentas_cobro
```
✅ subtotal
✅ descuento_valor
✅ descuento_porcentaje
✅ iva_porcentaje
✅ iva_valor
✅ retencion_fuente_porcentaje
✅ retencion_fuente_valor
✅ retencion_ica_porcentaje
✅ retencion_ica_valor
✅ retencion_iva_porcentaje
✅ retencion_iva_valor
✅ otras_retenciones_valor
✅ tiene_anticipo
✅ valor_anticipo
✅ valor_pendiente_pago
✅ referencia_anticipo
✅ fecha_pago_anticipado
✅ tipo_cuenta_beneficiario
✅ numero_cuenta_beneficiario
✅ banco_beneficiario
✅ cuenta_corriente_usuario
✅ nit_beneficiario
✅ rut_url
✅ responsable_iva
✅ gran_contribuyente
✅ numero_orden_compra
✅ numero_cdp
✅ numero_rgp
✅ fecha_vencimiento_factura
✅ observaciones_internas
✅ justificacion_rechazo
✅ justificacion_devolucion
✅ modificado_por (FK)
```

### Models Nuevos
```
✅ App\Models\Documento
✅ App\Models\AtributoUsuario
✅ App\Models\PermisoGranular
```

### Controllers Nuevos
```
✅ App\Http\Controllers\DocumentoController
✅ App\Http\Controllers\AprobacionController
✅ App\Http\Controllers\PermisoController
```

### Rutas Nuevas (50+)
```
✅ /documentos/* (10 rutas)
✅ /aprobaciones/* (7 rutas)
✅ /admin/permisos/* (7 rutas)
```

### Datos de Referencia
```
✅ 7+ permisos granulares por rol
✅ Atributos para cada usuario
✅ Limitaciones por rol configuradas
```

---

## ✅ Checklist de Validación

```bash
# Ejecutar todas estas verificaciones

# 1. Verificar migraciones
php artisan migrate:status

# 2. Verificar tablas existen
php artisan tinker
>>> DB::select("SHOW TABLES")
>>> exit

# 3. Verificar Models cargan
php artisan tinker
>>> App\Models\Documento::count()
>>> App\Models\AtributoUsuario::count()
>>> App\Models\PermisoGranular::count()
>>> exit

# 4. Verificar rutas existen
php artisan route:list | grep -c "documento"
php artisan route:list | grep -c "aprobacion"
php artisan route:list | grep -c "permiso"

# 5. Verificar directorios
ls -la storage/app/public/documentos/

# 6. Verificar enlace simbólico
ls -la public/storage

# 7. Iniciar servidor
php artisan serve

# En otro terminal: verificar en navegador
# http://localhost:8000/admin/permisos
# Debería cargar sin errores
```

---

## 🚀 Iniciar Servidor

```bash
# Modo desarrollo
php artisan serve

# Modo con debugging
php artisan serve --host=192.168.1.100 --port=8080

# En otro terminal, compilar assets en tiempo real
npm run watch
```

**Acceder en navegador:**
```
http://localhost:8000
```

---

## 📝 Notas Importantes

1. **Backup**: Haz backup de tu base de datos ANTES de ejecutar migraciones
2. **Usuarios**: Los usuarios existentes no se eliminan ni modifican
3. **Permisos**: Los nuevos permisos NO afectan los roles existentes (es aditivo)
4. **Seeders**: Puedes ejecutar seeders múltiples veces sin problemas (usa upsert)
5. **Documentos**: Los documentos se guardan en `storage/app/public/documentos/`
6. **Archivos**: Es seguro hacer rollback de migraciones (restaura estructura anterior)

---

## 🔗 Siguientes Pasos

Después de la instalación:

1. ✅ **Verificar Instalación** (pasos de arriba)
2. 🎨 **Crear Vistas Blade** (modales, interfaz)
3. 📜 **Crear JavaScript** (interactividad)
4. 🎯 **Probar Flujo Completo** (de contratista a tesorería)
5. 📊 **Probar Reportes** (usar nuevos campos)
6. 🔐 **Verificar Seguridad** (permisos funcionan)
7. 🚀 **Desplegar a Producción** (cuando todo funciona)

---

**¡Listo! 🎉 Tu sistema está actualizado a v3.0**

Si necesitas ayuda, revisa la **GUIA_MEJORAS_V3.md** para más detalles de características.


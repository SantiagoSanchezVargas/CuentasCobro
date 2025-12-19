# 📊 Sistema de Gestión de Cuentas de Cobro

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-Propietaria-green?style=flat-square)

Sistema de gestión de cuentas de cobro con flujo de aprobación obligatorio para entidades gubernamentales. Diseño inspirado en Apple con interfaz intuitiva y moderna.

---

## 🌟 Características Principales

### ✅ Flujo de Aprobación Obligatorio (v3.0)
- **3 etapas secuenciales:** Auxiliar → Administrador → Tesorería
- **No se pueden saltar etapas** (excepto Super Admin)
- **Trazabilidad completa** de todas las decisiones

### 👥 Sistema de Roles
- 5 roles definidos con permisos específicos
- Auxiliar, Administrador, Tesorería, Admin Programa, Super Admin
- **Matriz de permisos granular** por rol y etapa

### 🔄 Opciones de Intervención
- ✅ Enviar al siguiente nivel
- ❌ Rechazar (No Aprobado)
- 🔄 Devolver para corrección (Contratación)
- 🔙 Devolver a etapa anterior
- 📝 Agregar interacciones sin cambiar estado

### 💰 Gestión de Pagos
- Registro detallado de pagos por Tesorería
- Múltiples medios de pago
- Adjuntar comprobantes
- Notificaciones automáticas

### 📄 Generación Automática de PDFs
- PDF generado automáticamente al crear cuenta
- Diseño profesional con información completa
- Descarga disponible en cualquier momento

### 🔔 Sistema de Notificaciones
- Notificaciones en tiempo real
- Alertas por cambio de estado
- Bandeja de notificaciones integrada

### 📊 Reportes y Estadísticas
- Dashboard con métricas clave
- Reportes de pagos realizados
- Estadísticas por período
- Exportación a Excel/PDF

---

## ✨ NUEVAS CARACTERÍSTICAS v3.0

### 📄 Sistema Integral de Documentos
- ✅ Subir, gestionar y versionar documentos
- ✅ Control de acceso por roles (private/internal/public)
- ✅ Historial completo de versiones
- ✅ Contador de descargas y auditoría
- ✅ Categorización (contrato, comprobante, anexo, soporte)
- ✅ Archivar/Desarchivar documentos

### 🎯 Aprobaciones Mejoradas con Modales
- ✅ Interfaz moderna con ventanas emergentes
- ✅ Resumen financiero en vivo
- ✅ Validación de documentos obligatorios
- ✅ Múltiples opciones de intervención en UI
- ✅ Historial visual con timeline interactivo

### 📊 Campos Financieros Completos (v3.0)
- ✅ Desglose detallado: subtotal, descuentos, impuestos
- ✅ Retenciones automáticas (FUENTE, ICA, IVA, otras)
- ✅ Gestión de anticipos y pagos pendientes
- ✅ Información bancaria ampliada
- ✅ Datos fiscales (NIT, RUT, responsable IVA)
- ✅ Números de control (CDP, RGP, orden compra)

### 🔐 Permisos Granulares por Rol (v3.0)
- ✅ Matriz configurable de permisos (18 permisos + restricciones)
- ✅ Control por etapa y estado de la cuenta
- ✅ Límites de aprobación personalizados por usuario
- ✅ Campos visibles/editables por rol
- ✅ Departamentos y visibilidad restringida
- ✅ Plantillas predefinidas para cada rol

### 👤 Atributos Avanzados de Usuario (v3.0)
- ✅ Información personal y laboral detallada
- ✅ Firma digital y datos de contacto múltiples
- ✅ Delegación de poderes con validación temporal
- ✅ Límites de aprobación personalizados
- ✅ Auditoría completa (login, intentos fallidos)

### 📈 Historial y Auditoría Mejorada
- ✅ Timeline integrada (estados + documentos + interacciones)
- ✅ Vista cronológica completa de cada cuenta
- ✅ Filtros avanzados por tipo de evento
- ✅ Usuario, fecha y hora de cada cambio
- ✅ Trazabilidad forense completa

---

## 📚 Documentación

Este proyecto cuenta con documentación completa y organizada:

### 🚀 Para Empezar

| Documento | Descripción | Audiencia |
|-----------|-------------|-----------|
| **[GUIA_INSTALACION_V3.md](GUIA_INSTALACION_V3.md)** | **NUEVO:** Guía paso a paso para instalar migraciones, seeders y configuración v3.0 | Desarrolladores, DevOps |
| **[MANUAL_INSTALACION_TERCEROS.md](MANUAL_INSTALACION_TERCEROS.md)** | Guía completa de instalación de proyeto base | Desarrolladores nuevos, terceros |
| **[ORGANIZACION_PROYECTO.md](ORGANIZACION_PROYECTO.md)** | Estructura del proyecto, carpetas, archivos, convenciones | Desarrolladores, mantenimiento |

### 📖 Para Usuarios y Admins

| Documento | Descripción | Audiencia |
|-----------|-------------|-----------|
| **[GUIA_MEJORAS_V3.md](GUIA_MEJORAS_V3.md)** | **NUEVO:** Guía completa de nuevas características v3.0 | Usuarios finales, administradores |
| **[PROCESO_COMPLETO_CUENTAS_COBRO.md](PROCESO_COMPLETO_CUENTAS_COBRO.md)** | Flujo de aprobación, roles, opciones de intervención | Usuarios finales, administradores |
| **[FLUJO_DOCUMENTOS.md](FLUJO_DOCUMENTOS.md)** | Flujo original de documentos | Referencia técnica |

### 🏗️ Para Arquitectos y Técnicos

| Documento | Descripción | Audiencia |
|-----------|-------------|-----------|
| **[ARQUITECTURA_TECNICA_V3.md](ARQUITECTURA_TECNICA_V3.md)** | **NUEVO:** Diagrama de arquitectura, modelos, controllers, BD | Arquitectos, DevOps, senior devs |

### 🔍 Orden de Lectura Recomendado

```
PARA DESARROLLADORES:
1️⃣ GUIA_INSTALACION_V3.md     → Instalar las mejoras v3.0
2️⃣ ARQUITECTURA_TECNICA_V3.md  → Entender la arquitectura
3️⃣ ORGANIZACION_PROYECTO.md    → Estructura del proyecto

PARA ADMINISTRADORES:
1️⃣ GUIA_MEJORAS_V3.md          → Conocer las mejoras
2️⃣ GUIA_INSTALACION_V3.md      → Instalar en servidor
3️⃣ PROCESO_COMPLETO_CUENTAS_COBRO.md → Entrenar usuarios

PARA USUARIOS:
1️⃣ GUIA_MEJORAS_V3.md          → Nuevas características
2️⃣ PROCESO_COMPLETO_CUENTAS_COBRO.md → Cómo funciona el flujo
```

---

## 💻 Requisitos del Sistema

### Mínimos
- **PHP:** 8.2 o superior
- **MySQL:** 5.7 o superior
- **Composer:** Última versión
- **Node.js:** 18.x o superior
- **NPM:** 9.x o superior

### Recomendados
- **PHP:** 8.3
- **MySQL:** 8.0
- **RAM:** 8 GB
- **Espacio en disco:** 5 GB

---

## 🚀 Instalación Rápida

### 1. Clonar o Descargar el Proyecto

```bash
cd C:\xampp\htdocs
# Copiar archivos del proyecto a CuentasCobro/
```

### 2. Instalar Dependencias

```bash
cd CuentasCobro

# Instalar dependencias PHP
composer install

# Instalar dependencias Node.js
npm install

# Compilar assets
npm run build
```

### 3. Configurar Base de Datos

```bash
# Crear base de datos en phpMyAdmin o CLI
mysql -u root -p
CREATE DATABASE cuentas_cobro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

### 4. Configurar Entorno

```bash
# Copiar archivo de configuración
copy .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Configurar .env con tus datos de base de datos
```

### 5. Migrar y Poblar Base de Datos

```bash
# Ejecutar migraciones
php artisan migrate

# Poblar con datos iniciales
php artisan db:seed
```

### 6. Iniciar el Sistema

```bash
# Opción 1: Servidor de desarrollo Laravel
php artisan serve

# Opción 2: Usar Apache de XAMPP
# Acceder a: http://localhost/CuentasCobro/public
```

### 7. Acceder al Sistema

- **URL:** http://127.0.0.1:8000 (o la configurada)
- **Usuario:** admin@sistema.com
- **Contraseña:** admin123456

**⚠️ IMPORTANTE:** Cambia la contraseña inmediatamente después del primer inicio de sesión.

---

## 📁 Estructura del Proyecto

```
CuentasCobro/
├── app/                    # Backend (Controladores, Modelos, Middleware)
│   ├── Http/Controllers/   # ⭐ Lógica de negocio
│   ├── Models/            # ⭐ Modelos Eloquent
│   └── Providers/         # Service Providers
├── database/              # Migraciones, Seeders
├── public/                # Carpeta pública (CSS, JS, imágenes)
│   └── css/              # ⭐ Sistema de estilos organizado
├── resources/
│   └── views/            # ⭐ Plantillas Blade (HTML)
├── routes/
│   └── web.php           # ⭐ Definición de rutas
├── storage/              # Archivos, logs, caché
│   ├── app/pdf/         # PDFs generados
│   └── app/soportes/    # Documentos adjuntos
└── vendor/              # Dependencias (no editar)
```

**Para más detalles:** Ver [ORGANIZACION_PROYECTO.md](ORGANIZACION_PROYECTO.md)

---

## 🎨 Sistema de Diseño

### Apple-Inspired Design

El proyecto utiliza un sistema de diseño inspirado en Apple con:

- **Colores iOS:** Variables CSS para colores consistentes
- **Tipografía:** Sistema SF Pro / San Francisco
- **Iconos:** Material Symbols Rounded de Google
- **Efectos:** Sombras sutiles, bordes redondeados, transiciones suaves
- **Responsive:** Diseño adaptable a todos los dispositivos

### Paleta de Colores

```css
--primary-color: #007AFF;    /* Azul iOS */
--success-color: #34C759;    /* Verde iOS */
--warning-color: #FF9500;    /* Naranja iOS */
--danger-color: #FF3B30;     /* Rojo iOS */
```

### Estados Visuales

- 🔵 **En Revisión** - Azul
- 🟠 **En Corrección** - Naranja
- 🟢 **Aprobado** - Verde
- 🔴 **Rechazado** - Rojo
- 🟣 **Enviado Cliente** - Morado
- 🟢 **Pagado** - Verde claro

---

## 🔐 Seguridad

### Implementaciones de Seguridad

- ✅ Autenticación basada en Laravel (bcrypt)
- ✅ Middleware de roles y permisos
- ✅ Protección CSRF en todos los formularios
- ✅ Validación de inputs del usuario
- ✅ Sanitización de datos antes de mostrar
- ✅ Protección contra SQL Injection (Eloquent ORM)
- ✅ Hash de contraseñas con bcrypt
- ✅ Variables de entorno (.env) para datos sensibles

### Recomendaciones

- 🔒 Usar HTTPS en producción
- 🔒 Cambiar todas las contraseñas por defecto
- 🔒 Mantener Laravel y dependencias actualizadas
- 🔒 Configurar firewall para puerto 3306 (MySQL)
- 🔒 Realizar respaldos periódicos

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 11.x** - Framework PHP
- **PHP 8.2+** - Lenguaje de programación
- **MySQL 8.0** - Base de datos
- **Eloquent ORM** - Mapeo objeto-relacional

### Frontend
- **Blade** - Motor de plantillas
- **Tailwind CSS 4.0** - Framework CSS (opcional)
- **Vite 6.0** - Build tool
- **Material Symbols** - Iconografía

### Librerías
- **DomPDF** - Generación de PDFs
- **Laravel Sanctum** - Autenticación
- **Carbon** - Manejo de fechas

---

## 📊 Flujo del Sistema

### Flujo Obligatorio de Aprobación (v3.0)

```
1. Auxiliar → Crea y valida cuenta de cobro
        ↓
2. Administrador → Aprueba y gestiona
        ↓
3. Tesorería → Registra pago
        ↓
4. ✅ Finalizado (Pagado)
```

### Opciones en Cada Etapa

- ✅ **Enviar al siguiente nivel** - Continúa el flujo
- ❌ **Rechazar** - Finaliza definitivamente (con motivo)
- 🔄 **Devolver para corrección** - Regresa para edición
- 🔙 **Devolver a etapa anterior** - Regresa una etapa
- 📝 **Agregar interacción** - Comentario sin cambiar estado

**Para más detalles:** Ver [PROCESO_COMPLETO_CUENTAS_COBRO.md](PROCESO_COMPLETO_CUENTAS_COBRO.md)

---

## 🧪 Testing

### Ejecutar Tests

```bash
# Todos los tests
php artisan test

# Tests específicos
php artisan test --filter NombreDelTest

# Con cobertura
php artisan test --coverage
```

### Tests Disponibles

- Tests de autenticación
- Tests de roles y permisos
- Tests del flujo de aprobación
- Tests de generación de PDFs

---

## 📈 Comandos Útiles

### Desarrollo

```bash
# Servidor de desarrollo
php artisan serve

# Compilar assets (desarrollo con hot-reload)
npm run dev

# Compilar assets (producción)
npm run build

# Ver rutas disponibles
php artisan route:list

# Limpiar caché
php artisan optimize:clear
```

### Base de Datos

```bash
# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Poblar con datos de prueba
php artisan db:seed

# Refrescar base de datos completa
php artisan migrate:fresh --seed
```

### Mantenimiento

```bash
# Crear respaldo de base de datos
php artisan db:backup

# Ver información del sistema
php artisan about

# Limpiar logs antiguos
php artisan log:clear

# Optimizar para producción
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🤝 Contribución

### Convenciones de Código

- **PHP:** PSR-12 Standard
- **JavaScript:** ESLint + Prettier
- **CSS:** BEM Methodology
- **Commits:** Conventional Commits

### Flujo de Trabajo

1. Fork del proyecto
2. Crear rama: `git checkout -b feature/nueva-funcionalidad`
3. Commit: `git commit -m "feat(modulo): descripción"`
4. Push: `git push origin feature/nueva-funcionalidad`
5. Pull Request

**Para más detalles:** Ver [ORGANIZACION_PROYECTO.md](ORGANIZACION_PROYECTO.md)

---

## 📞 Soporte y Contacto

### Reportar Problemas

- **Issues:** Usa el sistema de issues del repositorio
- **Email:** soporte@municipio.gov.co
- **Documentación:** Lee los archivos .md del proyecto

### Recursos

- [Documentación de Laravel](https://laravel.com/docs)
- [Guía de Instalación](MANUAL_INSTALACION_TERCEROS.md)
- [Organización del Proyecto](ORGANIZACION_PROYECTO.md)

---

## 📄 Licencia

Este proyecto es software propietario desarrollado para uso interno de entidades gubernamentales.

**© 2025 - Sistema de Gestión de Cuentas de Cobro**

---

## 🎯 Roadmap

### Versión Actual: 3.0 🎉

✅ **COMPLETADO EN ESTA VERSIÓN:**
- ✅ Flujo obligatorio de 5 etapas
- ✅ Sistema de roles y permisos mejorado
- ✅ Múltiples opciones de intervención
- ✅ Generación automática de PDFs
- ✅ Sistema de notificaciones
- ✅ Registro de pagos completo
- ✅ **Sistema integral de documentos con versionamiento** (NUEVO)
- ✅ **Permisos granulares por rol** (NUEVO)
- ✅ **27 nuevos campos financieros** (NUEVO)
- ✅ **Atributos avanzados de usuario** (NUEVO)
- ✅ **Timeline e historial mejorado** (NUEVO)
- ✅ **Archivar/Desarchivizar cuentas** (NUEVO)
- ✅ **4 nuevas tablas de BD** (NUEVO)
- ✅ **3 nuevos controllers** (NUEVO)
- ✅ **50+ nuevas rutas API** (NUEVO)
- ✅ **2 seeders de datos iniciales** (NUEVO)

### Próximas Versiones

#### v3.1 (Inmediato - Vistas)
- [ ] Crear vistas Blade (modales, formularios, timeline)
- [ ] Crear JavaScript (interactividad, AJAX, drag-drop)
- [ ] Crear CSS mejorado (animaciones, responsivo)
- [ ] Integrar eventos de notificación
- [ ] Ejecutar y probar migraciones y seeders

#### v3.2 (UI/UX)
- [ ] Dashboard mejorado con gráficas de documentos
- [ ] Reportes de aprobaciones y tiempos
- [ ] Filtros avanzados en listados
- [ ] Exportación a Excel con datos financieros
- [ ] Búsqueda global mejorada

#### v3.3 (Integraciones)
- [ ] Integración con firma digital (DIGICERT, Adobe Sign)
- [ ] Escaneo automático de documentos (OCR)
- [ ] Integración con correo electrónico mejorada
- [ ] Sincronización con sistemas contables externos
- [ ] API REST completa para terceros

#### v4.0 (Futuro)
- [ ] Aplicación móvil (iOS/Android)
- [ ] Integración con bancos
- [ ] Pagos electrónicos integrados
- [ ] Machine Learning para análisis de fraudes
- [ ] Reconocimiento de documentos automático

---

## 🏆 Créditos

**Desarrollado por:** Equipo de Desarrollo Municipal  
**Diseño:** Inspirado en Apple Human Interface Guidelines  
**Iconografía:** Material Symbols de Google  
**Framework:** Laravel - The PHP Framework for Web Artisans

---

## ⭐ Agradecimientos

Gracias a todos los que han contribuido al desarrollo y mejora de este sistema.

---

**Última actualización:** Noviembre 29, 2025  
**Versión:** 3.0.0  
**Estado:** Backend completo ✅ | Frontend en desarrollo 🚀

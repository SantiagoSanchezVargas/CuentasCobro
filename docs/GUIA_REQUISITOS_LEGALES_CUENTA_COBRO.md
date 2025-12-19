# Guía de Requisitos Legales - Cuentas de Cobro en Colombia

## 📋 Índice
1. [Introducción](#introducción)
2. [Requisitos Legales Mínimos](#requisitos-legales-mínimos)
3. [Campos de la Base de Datos](#campos-de-la-base-de-datos)
4. [Validaciones Implementadas](#validaciones-implementadas)
5. [Procesos Judiciales](#procesos-judiciales)
6. [Ejemplos de Uso](#ejemplos-de-uso)

---

## Introducción

Una **cuenta de cobro** es un documento que enuncia o reclama el pago de un valor determinado cuando el vendedor o prestador del servicio **NO está obligado a expedir factura**.

### Características Importantes:
- ❌ **NO presta mérito ejecutivo** (no proviene del deudor)
- ❌ **NO es un título valor** (no está en el código de comercio)
- ⚠️ **NO sirve como soporte fiscal** por sí sola
- ✅ **SÍ es útil** para proceso monitorio (deudas de mínima cuantía)
- ✅ **SÍ es válida** si está firmada por ambas partes

---

## Requisitos Legales Mínimos

Según la legislación colombiana, una cuenta de cobro debe contener:

### 1. 👤 Identificación del Acreedor (quien cobra)
```php
- nombre_acreedor
- tipo_documento_acreedor (CC, CE, NIT, Pasaporte, TI)
- numero_documento_acreedor
- ciudad_expedicion_acreedor
- direccion_acreedor (opcional pero recomendado)
- telefono_acreedor (opcional pero recomendado)
- email_acreedor (opcional pero recomendado)
```

### 2. 👥 Identificación del Deudor (quien debe pagar)
```php
- nombre_deudor
- tipo_documento_deudor
- numero_documento_deudor
- ciudad_expedicion_deudor
- direccion_deudor
- telefono_deudor
- email_deudor
```

### 3. 💰 Valor a Cobrar
```php
- valor_total (campo obligatorio)
- Debe ser mayor a 0
```

### 4. 📝 Concepto del Cobro
```php
- concepto_cobro (descripción clara del servicio/producto)
- descripcion_servicio (detalle ampliado)
```

### 5. 📅 Fecha del Servicio
```php
- fecha_prestacion_servicio (fecha única)
  O
- fecha_inicio_servicio + fecha_fin_servicio (rango de fechas)
- lugar_prestacion_servicio
```

### 6. 📆 Fecha de la Cuenta de Cobro
```php
- fecha_emision (obligatorio)
- fecha_hora_emision (para mayor precisión)
- ciudad_expedicion_cuenta
```

### 7. ✍️ Firma del Acreedor
```php
- firmado_acreedor (boolean)
- fecha_firma_acreedor
- firma_acreedor_url (ruta al archivo de firma)
- firma_acreedor_ip (IP desde donde se firmó)
```

### 8. 🤝 Firma del Deudor (OPCIONAL pero MUY RECOMENDADO)
```php
- firmado_deudor (boolean)
- fecha_firma_deudor
- firma_deudor_url
- firma_deudor_ip
- deuda_reconocida_deudor (boolean) ⭐ IMPORTANTE
```

**¿Por qué es importante la firma del deudor?**
- Con firma del deudor = Reconocimiento de deuda
- Facilita el cobro judicial
- Puede dar mérito ejecutivo en algunos casos

---

## Campos de la Base de Datos

### Información Contractual
```php
'numero_contrato_referencia'    // Número del contrato que origina el cobro
'fecha_contrato'                // Fecha del contrato
'tipo_contrato'                 // ENUM: Prestación de servicios, Compraventa, etc.
'objeto_contrato'               // Descripción del objeto del contrato
```

### Documento Soporte Fiscal
```php
'numero_documento_soporte'      // Documento que reemplaza a la cuenta de cobro fiscalmente
'fecha_documento_soporte'       // Fecha del documento soporte
'documento_soporte_url'         // URL del documento soporte generado
'requiere_validacion_previa'    // Si requiere validación DIAN
'fecha_validacion_dian'         // Timestamp de validación
```

**Importante:** La cuenta de cobro NO es soporte fiscal. El receptor debe generar un **Documento Soporte Electrónico** con validación previa.

### Información Legal y Cobro Judicial
```php
'estado_cobro_judicial'         // ENUM: Sin proceso, Proceso monitorio, etc.
'numero_proceso_judicial'       // Radicado del proceso
'fecha_inicio_proceso'          // Cuándo se inició el proceso
'juzgado'                       // Juzgado que conoce el caso
'radicado_judicial'             // Número de radicado

'tiene_merito_ejecutivo'        // Boolean (raro en cuentas de cobro)
'deuda_reconocida_deudor'       // Boolean ⭐
'evidencias_obligacion'         // JSON/Text con evidencias
'testigos'                      // JSON/Text con datos de testigos
```

### Plazos y Vencimientos
```php
'dias_plazo_pago'               // Cantidad de días para pagar
'fecha_vencimiento_real'        // Fecha límite de pago
'dias_gracia'                   // Días adicionales después del vencimiento
'fecha_vencimiento_con_gracia'  // Fecha final considerando gracia
```

### Condiciones Adicionales
```php
'clausulas_especiales'          // Cláusulas específicas del acuerdo
'condiciones_pago'              // Condiciones de pago pactadas
'forma_pago_acordada'           // Efectivo, transferencia, cheque, etc.
'penalidades_retraso'           // Penalidades por mora
'interes_mora_porcentaje'       // % de interés por mora
'cobra_intereses_mora'          // Boolean
```

### Numeración y Serie
```php
'prefijo_cuenta'                // Ej: "CC"
'serie_cuenta'                  // Ej: "2025"
'consecutivo_cuenta'            // Ej: 1234
// Generaría: CC-2025-001234
```

### Observaciones
```php
'observaciones_legales'         // Notas legales importantes
'notas_cobro'                   // Notas adicionales sobre el cobro
'observaciones_internas'        // Observaciones de uso interno
```

---

## Validaciones Implementadas

### 1. Validación de Requisitos Legales Mínimos
```php
$resultado = $cuentaCobro->cumpleRequisitosLegales();

// Retorna:
[
    'cumple' => true/false,
    'errores' => ['error 1', 'error 2', ...],
    'porcentaje_cumplimiento' => 85.71  // Ejemplo: 6 de 7 requisitos
]
```

### 2. Validación de Mérito Ejecutivo
```php
$tieneMerito = $cuentaCobro->tieneMeritoEjecutivo();
// true si: tiene_merito_ejecutivo && firmado_deudor && deuda_reconocida_deudor
```

### 3. Validación para Proceso Monitorio
```php
$resultado = $cuentaCobro->esAptaProcesoMonitorio();

// Retorna:
[
    'apta' => true/false,
    'requisitos' => [
        'es_deuda_dineraria' => true,
        'es_minima_cuantia' => true,    // <= 40 SMLV
        'tiene_origen_contractual' => true,
        'tiene_evidencias' => true
    ],
    'valor_cuenta' => 15000000,
    'limite_minima_cuantia' => 52000000,
    'recomendacion' => '...'
]
```

**Proceso Monitorio:**
- ✅ Aplica para deudas de mínima cuantía (hasta 40 SMLV)
- ✅ Origen contractual
- ✅ Es un proceso declarativo especial
- ⚠️ La cuenta de cobro sola NO es suficiente, debe probarse el origen de la deuda

---

## Procesos Judiciales

### Estados de Cobro Judicial
```php
'Sin proceso'          // No se ha iniciado proceso
'Proceso monitorio'    // Mínima cuantía, declarativo
'Proceso ejecutivo'    // Cuando hay mérito ejecutivo
'Conciliación'         // En proceso de conciliación
'Acuerdo de pago'      // Se llegó a un acuerdo
'Cobrado'             // Deuda cobrada exitosamente
```

### ¿Cómo Cobrar una Cuenta de Cobro?

#### Opción 1: Proceso Monitorio (más común)
- **Requisito:** Deuda de mínima cuantía (≤ 40 SMLV)
- **Necesita:** Prueba del origen contractual
- **Tiempo:** Proceso especial de única instancia
- **Ventaja:** Más rápido que proceso ordinario

```php
// Verificar si aplica
$resultado = $cuentaCobro->esAptaProcesoMonitorio();
if ($resultado['apta']) {
    // Proceder con proceso monitorio
}
```

#### Opción 2: Proceso Ejecutivo (poco común)
- **Requisito:** Debe tener mérito ejecutivo
- **Problema:** Cuenta de cobro rara vez tiene mérito ejecutivo
- **Solución:** Conseguir firma del deudor con reconocimiento

```php
// Verificar mérito ejecutivo
if ($cuentaCobro->tieneMeritoEjecutivo()) {
    // Puede intentar proceso ejecutivo
}
```

#### Opción 3: Proceso Ordinario
- **Cuando:** Supera 40 SMLV y no tiene mérito ejecutivo
- **Tiempo:** Más largo
- **Costo:** Más costoso

---

## Ejemplos de Uso

### Ejemplo 1: Crear Cuenta de Cobro Completa
```php
use App\Models\CuentaCobro;

$cuenta = CuentaCobro::create([
    // Identificación acreedor
    'nombre_acreedor' => 'Juan Pérez García',
    'tipo_documento_acreedor' => 'CC',
    'numero_documento_acreedor' => '1234567890',
    'ciudad_expedicion_acreedor' => 'Bogotá',
    'direccion_acreedor' => 'Calle 123 #45-67',
    'telefono_acreedor' => '3001234567',
    'email_acreedor' => 'juan.perez@email.com',
    
    // Identificación deudor
    'nombre_deudor' => 'Empresa ABC S.A.S.',
    'tipo_documento_deudor' => 'NIT',
    'numero_documento_deudor' => '900123456-7',
    'direccion_deudor' => 'Carrera 7 #8-9',
    'telefono_deudor' => '6012345678',
    'email_deudor' => 'facturacion@empresaabc.com',
    
    // Concepto
    'concepto_cobro' => 'Servicios profesionales de consultoría técnica',
    'descripcion_servicio' => 'Análisis y diseño de soluciones informáticas según contrato 001-2025',
    'fecha_prestacion_servicio' => '2025-01-15',
    'lugar_prestacion_servicio' => 'Bogotá D.C.',
    
    // Contractual
    'numero_contrato_referencia' => '001-2025',
    'fecha_contrato' => '2025-01-01',
    'tipo_contrato' => 'Prestación de servicios',
    'objeto_contrato' => 'Consultoría técnica para implementación de sistema',
    
    // Valor
    'valor_total' => 5000000,
    
    // Expedición
    'fecha_emision' => now(),
    'fecha_hora_emision' => now(),
    'ciudad_expedicion_cuenta' => 'Bogotá',
    
    // Numeración
    'prefijo_cuenta' => 'CC',
    'serie_cuenta' => '2025',
    'consecutivo_cuenta' => 1,
    
    // Plazos
    'dias_plazo_pago' => 30,
    'fecha_vencimiento_real' => now()->addDays(30),
]);

// Validar requisitos legales
$validacion = $cuenta->cumpleRequisitosLegales();
if (!$validacion['cumple']) {
    foreach ($validacion['errores'] as $error) {
        echo "❌ $error\n";
    }
}
```

### Ejemplo 2: Firmar Cuenta de Cobro
```php
// Firma del acreedor
$cuenta->firmarPorAcreedor(
    firmaUrl: '/storage/firmas/acreedor_123.png',
    ip: '192.168.1.100'
);

// Firma del deudor (CON reconocimiento de deuda)
$cuenta->firmarPorDeudor(
    firmaUrl: '/storage/firmas/deudor_456.png',
    ip: '192.168.1.101',
    reconoceDeuda: true  // ⭐ MUY IMPORTANTE
);

// Verificar mérito ejecutivo
if ($cuenta->tieneMeritoEjecutivo()) {
    echo "✅ Esta cuenta tiene mérito ejecutivo\n";
    echo "✅ Se puede intentar proceso ejecutivo\n";
}
```

### Ejemplo 3: Calcular Intereses de Mora
```php
$cuenta->update([
    'cobra_intereses_mora' => true,
    'interes_mora_porcentaje' => 1.5, // 1.5% mensual
    'fecha_vencimiento_real' => now()->subDays(30), // Vencida hace 30 días
]);

$mora = $cuenta->calcularInteresesMora();

echo "Días en mora: {$mora['dias_mora']}\n";
echo "Intereses: \${$mora['interes_valor']}\n";
echo "Total con interés: \${$mora['total_con_interes']}\n";

// Resultado:
// Días en mora: 30
// Intereses: $61643.84
// Total con interés: $5061643.84
```

### Ejemplo 4: Generar Texto Legal
```php
$textoLegal = $cuenta->generarTextoLegal();

echo $textoLegal;

/*
CUENTA DE COBRO CC-2025-000001

Bogotá, 29 de noviembre de 2025

El(la) señor(a) Juan Pérez García, identificado(a) con CC número 1234567890
expedida en Bogotá, debe a Empresa ABC S.A.S., identificado con NIT número
900123456-7, la suma de $5,000,000.00 por concepto de: Servicios profesionales
de consultoría técnica, servicio prestado el 15/01/2025.

Contrato No. 001-2025 de fecha 01/01/2025

Descripción del servicio:
Análisis y diseño de soluciones informáticas según contrato 001-2025


______________________________
Firma del Acreedor
Juan Pérez García
CC 1234567890
Tel: 3001234567
*/
```

### Ejemplo 5: Consultar Cuentas para Proceso Judicial
```php
// Cuentas vencidas sin proceso judicial
$cuentasVencidas = CuentaCobro::vencidas()
    ->where('estado_cobro_judicial', 'Sin proceso')
    ->get();

foreach ($cuentasVencidas as $cuenta) {
    $dias = abs($cuenta->getDiasParaVencimiento());
    echo "Cuenta {$cuenta->numero} vencida hace {$dias} días\n";
    
    // Verificar si aplica proceso monitorio
    $resultado = $cuenta->esAptaProcesoMonitorio();
    if ($resultado['apta']) {
        echo "  ✅ Apta para proceso monitorio\n";
    } else {
        echo "  ⚠️ Considerar proceso ordinario\n";
    }
}

// Cuentas con reconocimiento de deuda
$conReconocimiento = CuentaCobro::conReconocimientoDeuda()
    ->where('estado_cobro_judicial', 'Sin proceso')
    ->get();

echo "\n{$conReconocimiento->count()} cuentas con reconocimiento de deuda\n";
echo "Estas cuentas tienen mayor probabilidad de cobro exitoso\n";
```

### Ejemplo 6: Scopes Útiles
```php
// Cuentas con proceso judicial activo
$enProceso = CuentaCobro::conProcesoJudicial()->get();

// Cuentas firmadas por ambas partes
$firmadas = CuentaCobro::firmadasCompletas()->get();

// Cuentas vencidas
$vencidas = CuentaCobro::vencidas()->get();

// Combinaciones
$urgentes = CuentaCobro::vencidas()
    ->where('valor_total', '>', 10000000)
    ->whereNull('numero_proceso_judicial')
    ->get();
```

---

## ⚖️ Consideraciones Legales Finales

1. **Documento Soporte Fiscal:**
   - La cuenta de cobro NO es soporte fiscal válido
   - El receptor debe emitir Documento Soporte Electrónico
   - Sistema debe generar este documento automáticamente

2. **Firma del Deudor:**
   - SIEMPRE intentar conseguir firma del deudor
   - Con firma = reconocimiento de deuda
   - Facilita enormemente el cobro judicial

3. **Proceso Monitorio:**
   - Ideal para valores hasta 40 SMLV
   - Requiere prueba del origen contractual
   - Más rápido y económico

4. **Evidencias:**
   - Guardar contratos, correos, WhatsApp
   - Documentar entregas de servicio/producto
   - Mantener historial de comunicaciones

5. **Intereses de Mora:**
   - Pueden cobrarse si se pactaron
   - Deben estar en contrato o en cuenta de cobro
   - Calcular según legislación vigente

---

## 📚 Referencias

- [Gerencie.com - Cuenta de Cobro](https://www.gerencie.com/cuenta-de-cobro.html)
- Código General del Proceso - Art. 422 (Mérito Ejecutivo)
- Código General del Proceso - Art. 419 (Proceso Monitorio)
- Estatuto Tributario - Art. 771-2 (Soporte de Costos y Deducciones)

---

**Actualizado:** 29 de noviembre de 2025  
**Versión:** 1.0  
**Sistema:** CuentasCobro v3.0

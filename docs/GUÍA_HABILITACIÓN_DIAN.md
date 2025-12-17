# GUÍA DE HABILITACIÓN DIAN — Facturación Electrónica (Cuentas de Cobro)

Esta guía resume los pasos administrativos y técnicos necesarios para habilitar tu software de cuentas de cobro como facturador electrónico ante la DIAN (Colombia). Incluye la lista de requisitos administrativos, consideraciones técnicas para integración (SET de pruebas), y una propuesta práctica para implementar soporte DIAN en este proyecto.

## Requisitos previos (administrativos)
- Estar inscrito en el RUT con responsabilidad de facturador electrónico (si aplica).
- Certificado digital (firma) emitido por entidad autorizada.
- Acceso al portal DIAN (Factura Electrónica) y a la sección de Habilitación.
- Conocer si operarás como software propio o proveedor tecnológico.
- Tener la resolución/numeración aprobada (prefijo y rango) o estar listo para solicitarla.

## Pasos generales en la DIAN
1. Registro en DIAN → acceder a Factura Electrónica > Habilitación. Asociar NIT/Cédula y confirmar correo.
2. Seleccionar esquema: 
   - Software propio
   - Proveedor tecnológico (si aplica)
   - Software gratuito DIAN
3. Realización del SET de pruebas (enviar facturas, notas crédito/débito, etc.). Debe superarse para quedar en estado "Habilitado".
4. Solicitud de numeración (prefijos y rangos): Registro y habilitación > Numeración de Facturación → solicitar y asociar rangos/prefijos.
5. Paso a producción: usar el ambiente productivo con la numeración aprobada y el certificado de firma.

## Consideraciones técnicas para este proyecto
- Comunicación con DIAN: implementar un adaptador/servicio (`DianService`) que soporte:
  - Driver de pruebas (SET) y driver de producción.
  - Envío/recepción de XML/UBL según especificaciones DIAN (factura, notas crédito/débito).
  - Firma y sellado de documentos (certificado .p12/.pfx; proteger clave en vault/DB cifrada).
  - Manejo de respuestas y acuses (estado, CUFE, mensajes de error).
- Numeración autorizada: el sistema debe registrar y respetar prefijos y rangos autorizados por la DIAN.
- Auditoría: log de envíos y reintentos por documento, con payload de respuesta y errores.
- Permisos: solo roles autorizados deben habilitar/envíar a DIAN; log de trazabilidad.
- Resiliencia: reintentos con backoff y colas; alertar fallos.

## Modelo de datos sugerido (mínimo)
- `dian_configurations` (mode, api_url, token, email_contact, certificate_path [cifrado], certificate_pass [cifrado], active)
- `dian_numerations` (prefix, start_number, end_number, authorized_at, resolution_number, active, notes)
- `dian_send_logs` (document_id, type, status, response_payload, attempts, last_error, last_sent_at)
- Campos adicionales en `cuentas_cobro`: `cufe`, `estado_dian`, `fecha_envio_dian`, `mensaje_dian`.

## Arquitectura propuesta
- Servicio central: `App\Services\DianService` (strategy/driver: `SetDriver`, `ProductionDriver`).
- Jobs: `SendToDianJob`, `RetryFailedDianSendJob` para colas/resiliencia.
- Policies/Gates: roles con permiso explícito DIAN (`admin_programa` o similar) para habilitar, probar y enviar.
- Eventos/Notificaciones: al aprobar envío, notificar resultado (éxito/fallo) y adjuntar logs.
- UI mínima: panel para cargar certificado, configurar modo (SET/Producción), ver numeraciones y logs.

## Testing recomendado
- Unit tests para `DianService` con drivers mockeados (SET/prod).
- Tests de integración para colas y reintentos.
- Fixture de respuesta DIAN (éxito/falla) para validar parsing y estados.

## Variables de entorno (propuesta)
- `DIAN_MODE` (set|production)
- `DIAN_API_URL`
- `DIAN_API_TOKEN` (opcional; preferir almacenamiento en DB cifrado)
- `DIAN_CERT_PATH` (ruta a .p12/.pfx; cifrar si se guarda en disco)
- `DIAN_CERT_PASS` (usar vault o columna cifrada)
- `DIAN_CONTACT_EMAIL`

## Checklist de implementación
- [x] Añadir documento `GUÍA_HABILITACIÓN_DIAN.md` al repo (hecho)
- [x] Crear migraciones para `dian_configurations`, `dian_numerations`, `dian_send_logs`
- [ ] Implementar `DianService` y drivers SET/Prod
- [ ] Añadir jobs y reintentos con colas (`SendToDianJob`, `RetryFailedDianSendJob`)
- [ ] UI para configuración DIAN (certificado, modo) y visualización de logs
- [ ] Integrar numeración autorizada en creación de cuentas de cobro
- [ ] Agregar pruebas unitarias e integración de envíos DIAN

## Recursos útiles
- DIAN: https://www.dian.gov.co — buscar la sección Factura Electrónica y guías SET
- Videos y tutoriales (YouTube) sobre Habilitación Facturación Electrónica DIAN y SET
- Considerar usar librerías de firma y formatos XML/UBL si la DIAN lo requiere

## Próximos pasos sugeridos
- Crear las migraciones y el esqueleto del `DianService` + drivers (PR inicial con colas y logging).
- Integrar numeración DIAN al flujo actual de creación de cuentas de cobro (prefijos/rangos autorizados).
- Exponer panel de configuración (modo, certificado, contacto) y bitácora de envíos.

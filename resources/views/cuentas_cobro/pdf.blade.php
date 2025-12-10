<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta de Cobro {{ $cuenta->numero ?? $cuenta->id }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            color: #2c3e50; 
            font-size: 11px; 
            margin: 0;
            padding: 40px 50px;
            line-height: 1.4;
        }
        
        /* Header */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
        }
        .header-left { display: table-cell; width: 60%; vertical-align: bottom; }
        .header-right { display: table-cell; width: 40%; text-align: right; vertical-align: bottom; }
        
        .document-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            color: #2c3e50;
            margin: 0;
        }
        .document-number {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        
        .date-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 8px 15px;
            display: inline-block;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
        }

        /* Grid Layout for Buyer/Seller */
        .parties-container {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-spacing: 20px 0;
            margin-left: -20px; /* Compensate for border-spacing */
        }
        .party-box {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 20px;
            border-radius: 6px;
        }
        
        .party-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #7f8c8d;
            border-bottom: 1px solid #dfe6e9;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .party-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .party-detail {
            font-size: 11px;
            color: #555;
            margin-bottom: 2px;
        }

        /* Concept Section */
        .concept-section {
            margin-bottom: 30px;
        }
        .concept-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .concept-content {
            border-left: 3px solid #3498db;
            padding: 10px 15px;
            background-color: #fcfcfc;
            font-style: italic;
            color: #555;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #2c3e50;
            color: white;
            padding: 10px 15px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ecf0f1;
            color: #34495e;
        }
        .items-table tr:last-child td {
            border-bottom: 2px solid #2c3e50;
        }
        .col-desc { width: 70%; }
        .col-value { width: 30%; text-align: right; }

        /* Totals Section */
        .totals-container {
            display: table;
            width: 100%;
        }
        .totals-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 30px;
        }
        .totals-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 6px 0;
            text-align: right;
        }
        .totals-label {
            color: #7f8c8d;
            font-size: 11px;
            padding-right: 15px !important;
        }
        .totals-value {
            font-weight: bold;
            color: #2c3e50;
            width: 120px;
        }
        .grand-total-row td {
            padding-top: 15px;
            border-top: 1px solid #bdc3c7;
            font-size: 14px;
            color: #2c3e50;
        }
        .grand-total-value {
            color: #27ae60; /* Green for money */
        }

        /* Payment Info */
        .payment-info {
            margin-top: 0;
            font-size: 11px;
            color: #555;
        }
        .payment-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        /* Signatures */
        .signatures {
            margin-top: 60px;
            display: table;
            width: 100%;
        }
        .signature-block {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        .signature-line {
            border-top: 1px solid #95a5a6;
            width: 80%;
            padding-top: 8px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 12px;
            color: #2c3e50;
        }
        .signature-role {
            font-size: 10px;
            color: #7f8c8d;
            text-transform: uppercase;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #95a5a6;
            border-top: 1px solid #ecf0f1;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1 class="document-title">Cuenta de Cobro</h1>
            <div class="document-number">No. {{ $cuenta->numero ?? str_pad($cuenta->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div class="header-right">
            <div class="date-box">
                Fecha de Emisión: {{ \Carbon\Carbon::parse($cuenta->fecha_emision)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
            </div>
        </div>
    </div>

    <!-- Parties (Buyer & Seller) -->
    <div class="parties-container">
        <!-- Vendedor (Provider) -->
        <div class="party-box">
            <div class="party-title">Proveedor del Servicio (Vendedor)</div>
            <div class="party-name">{{ $cuenta->nombre_beneficiario }}</div>
            <div class="party-detail">
                <strong>NIT/CC:</strong> {{ $cuenta->tipo_identificacion }} {{ $cuenta->identificacion }}
            </div>
            @if($cuenta->email_acreedor)
            <div class="party-detail">
                <strong>Email:</strong> {{ $cuenta->email_acreedor }}
            </div>
            @endif
            @if($cuenta->telefono_acreedor)
            <div class="party-detail">
                <strong>Tel:</strong> {{ $cuenta->telefono_acreedor }}
            </div>
            @endif
        </div>

        <!-- Comprador (Client) -->
        <div class="party-box">
            <div class="party-title">Cliente (Comprador)</div>
            <div class="party-name">{{ $cuenta->nombre_deudor ?? 'N/A' }}</div>
            <div class="party-detail">
                <strong>NIT/CC:</strong> {{ $cuenta->tipo_documento_deudor }} {{ $cuenta->numero_documento_deudor ?? 'N/A' }}
            </div>
            @if($cuenta->direccion_deudor)
            <div class="party-detail">
                <strong>Dirección:</strong> {{ $cuenta->direccion_deudor }}
            </div>
            @endif
            @if($cuenta->telefono_deudor)
            <div class="party-detail">
                <strong>Tel:</strong> {{ $cuenta->telefono_deudor }}
            </div>
            @endif
        </div>
    </div>

    <!-- Concept -->
    @if($cuenta->concepto_cobro)
    <div class="concept-section">
        <div class="concept-title">CONCEPTO DEL COBRO</div>
        <div class="concept-content">
            {{ $cuenta->concepto_cobro }}
        </div>
    </div>
    @endif

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th class="col-desc">Descripción del Servicio / Producto</th>
                <th class="col-value">Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuenta->items as $item)
            <tr>
                <td>
                    <strong>{{ $item->item }}</strong>
                    @if($item->detalle)
                        <br><span style="font-size: 10px; color: #7f8c8d;">{{ $item->detalle }}</span>
                    @endif
                </td>
                <td class="col-value">$ {{ number_format($item->cantidad * $item->precio_unitario, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals & Payment Info -->
    <div class="totals-container">
        <div class="totals-left">
            <div class="payment-info">
                <div class="party-title" style="border:none; margin-bottom:5px;">INFORMACIÓN DE PAGO</div>
                @if($cuenta->tipo_cuenta_beneficiario && $cuenta->numero_cuenta_beneficiario)
                    <div>
                        <strong>Banco:</strong> {{ $cuenta->banco_beneficiario }}<br>
                        <strong>Tipo de Cuenta:</strong> {{ $cuenta->tipo_cuenta_beneficiario }}<br>
                        <strong>Número:</strong> {{ $cuenta->numero_cuenta_beneficiario }}
                    </div>
                @else
                    <div style="font-style: italic;">No se especificaron datos bancarios.</div>
                @endif
                
                @if($cuenta->forma_pago_acordada)
                    <div style="margin-top: 10px;">
                        <strong>Forma de Pago:</strong> {{ $cuenta->forma_pago_acordada }}
                    </div>
                @endif
            </div>
        </div>
        
        <div class="totals-right">
            <table class="totals-table">
                <tr>
                    <td class="totals-label">Subtotal</td>
                    <td class="totals-value">$ {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($iva > 0)
                <tr>
                    <td class="totals-label">IVA</td>
                    <td class="totals-value">$ {{ number_format($iva, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($retFuente > 0)
                <tr>
                    <td class="totals-label">Retención en la Fuente (-)</td>
                    <td class="totals-value" style="color: #c0392b;">$ {{ number_format($retFuente, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($retIca > 0)
                <tr>
                    <td class="totals-label">ReteICA (-)</td>
                    <td class="totals-value" style="color: #c0392b;">$ {{ number_format($retIca, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="grand-total-row">
                    <td class="totals-label" style="font-weight:bold; color:#2c3e50;">TOTAL A PAGAR</td>
                    <td class="totals-value grand-total-value">$ {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="signature-block">
            <div style="height: 50px; margin-bottom: 5px;">
                @if($cuenta->firma_acreedor_url)
                    <img src="{{ public_path($cuenta->firma_acreedor_url) }}" style="max-height: 50px;">
                @endif
            </div>
            <div class="signature-line"></div>
            <div class="signature-name">{{ $cuenta->nombre_beneficiario }}</div>
            <div class="signature-role">Vendedor / Beneficiario</div>
            <div style="font-size: 10px; color: #7f8c8d; margin-top: 2px;">
                CC: {{ $cuenta->identificacion }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Este documento constituye un soporte de cobro válido para efectos comerciales y contables.<br>
        Generado automáticamente por el sistema de gestión de cuentas de cobro.
    </div>

</body>
</html>

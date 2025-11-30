<!DOCTYPE html>
<html>
<head>
    <title>Notificación de Cuenta de Cobro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .content {
            padding: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            text-align: center;
            color: #777;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Notificación de Cuenta de Cobro</h2>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>{{ $mensaje }}</p>
            
            <h3>Detalles:</h3>
            <ul>
                <li><strong>Número:</strong> {{ $cuenta->numero }}</li>
                <li><strong>Mes:</strong> {{ $cuenta->mes }}</li>
                <li><strong>Año:</strong> {{ $cuenta->anio }}</li>
                <li><strong>Valor Total:</strong> ${{ number_format($cuenta->monto_total, 0, ',', '.') }}</li>
            </ul>

            <p>Se adjunta el documento PDF de la cuenta de cobro.</p>
        </div>
        <div class="footer">
            <p>Este es un mensaje automático, por favor no responder a este correo.</p>
        </div>
    </div>
</body>
</html>
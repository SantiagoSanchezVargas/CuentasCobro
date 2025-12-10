<style>
    /* Siigo-inspired Design */
    :root {
        --siigo-blue: #00b5e2;
        --siigo-dark: #2c3e50;
        --siigo-gray: #f4f6f8;
        --siigo-border: #dfe4ea;
    }

    .siigo-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .siigo-header-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--siigo-border);
    }

    .siigo-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #636e72;
        margin-bottom: 6px;
    }

    .siigo-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #b2bec3;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .siigo-input:focus {
        border-color: var(--siigo-blue);
        outline: none;
    }

    .siigo-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .siigo-table th {
        background: #f1f2f6;
        padding: 10px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #2d3436;
        border-bottom: 2px solid var(--siigo-border);
    }

    .siigo-table td {
        padding: 10px;
        border-bottom: 1px solid var(--siigo-border);
        vertical-align: top;
    }

    .siigo-btn-add {
        color: var(--siigo-blue);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .siigo-footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        margin-top: 30px;
    }

    .siigo-total-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
    }

    .siigo-total-row.final {
        font-weight: 700;
        font-size: 18px;
        border-top: 1px solid var(--siigo-border);
        margin-top: 10px;
        padding-top: 15px;
    }
</style>

<div class="siigo-container">
    <!-- Header Fields -->
    <div class="siigo-header-grid">
        <div>
            <label class="siigo-label">Tipo</label>
            <select name="tipo_documento" class="siigo-input bg-gray-100" readonly>
                <option value="Cuenta de Cobro">Cuenta de Cobro</option>
            </select>
        </div>
        <div>
            <label class="siigo-label">Número</label>
            <div class="flex items-center gap-2">
                <input type="text" name="numero" value="{{ $siguienteNumero ?? '' }}" class="siigo-input font-bold text-blue-600" readonly>
                <span class="text-xs text-gray-500">(Automático)</span>
            </div>
        </div>
        <div>
            <label class="siigo-label">Fecha de Elaboración</label>
            <input type="date" name="fecha_emision" value="{{ date('Y-m-d') }}" class="siigo-input">
        </div>
        <div>
            <label class="siigo-label">Moneda</label>
            <select name="moneda" class="siigo-input">
                <option value="COP">COP - Peso colombiano</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <label class="siigo-label">Proveedor / Beneficiario</label>
            <input type="text" name="nombre_beneficiario" class="siigo-input" placeholder="Buscar o escribir nombre..." required>
        </div>
        <div>
            <label class="siigo-label">Identificación (CC/NIT)</label>
            <input type="text" name="identificacion" class="siigo-input" placeholder="Número de documento" required>
        </div>
    </div>

    <!-- Items Table -->
    <table class="siigo-table" id="itemsTable">
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 25%">Producto / Servicio</th>
                <th style="width: 25%">Descripción</th>
                <th style="width: 10%">Cant</th>
                <th style="width: 15%">Valor Unitario</th>
                <th style="width: 15%">Valor Total</th>
                <th style="width: 5%"></th>
            </tr>
        </thead>
        <tbody id="itemsBody">
            <!-- Rows will be added here by JS -->
        </tbody>
    </table>

    <div class="mb-8">
        <span class="siigo-btn-add" onclick="addItemRow()">
            <span class="material-symbols-rounded">add_circle</span>
            Agregar ítem
        </span>
    </div>

    <!-- Footer -->
    <div class="siigo-footer-grid">
        <div>
            <label class="siigo-label">Observaciones</label>
            <textarea name="concepto_cobro" class="siigo-input" rows="4" placeholder="Comentarios adicionales..."></textarea>
            
            <div class="mt-4">
                <label class="siigo-label">Adjuntar Archivo (Opcional)</label>
                <input type="file" name="soporte" class="siigo-input">
            </div>
        </div>

        <div>
            <div class="siigo-total-row">
                <span>Subtotal</span>
                <span id="displaySubtotal">$0.00</span>
            </div>
            <div class="siigo-total-row">
                <span>Descuentos</span>
                <span id="displayDescuentos">$0.00</span>
            </div>
            <div class="siigo-total-row">
                <span>Impuestos (IVA)</span>
                <span id="displayImpuestos">$0.00</span>
            </div>
            <div class="siigo-total-row">
                <span>Retenciones</span>
                <span id="displayRetenciones">$0.00</span>
            </div>
            <div class="siigo-total-row final">
                <span>Total Neto</span>
                <span id="displayTotal" class="text-blue-600">$0.00</span>
            </div>
        </div>
    </div>

    <!-- Hidden Inputs for Calculation -->
    <input type="hidden" name="subtotal" id="inputSubtotal" value="0">
    <input type="hidden" name="iva_valor" id="inputIva" value="0">
    <input type="hidden" name="valor_total" id="inputTotal" value="0">
    
    <!-- Hidden Required Fields for Controller Compatibility -->
    <input type="hidden" name="departamento" value="Bogotá D.C.">
    <input type="hidden" name="municipio" value="Bogotá">
    <input type="hidden" name="tipo_identificacion" value="CC">
    <input type="hidden" name="tipo_cliente" value="Persona Natural">
    <input type="hidden" name="telefono" value="0000000000">
    <input type="hidden" name="email" value="usuario@example.com">
    <input type="hidden" name="direccion" value="Dirección pendiente">

    <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
        <button type="button" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</button>
        <button type="submit" class="px-6 py-2 rounded-lg bg-green-500 text-white font-bold hover:bg-green-600 shadow-lg">Guardar y Enviar</button>
    </div>
</div>

<script>
    let rowCount = 0;

    function addItemRow() {
        rowCount++;
        const tbody = document.getElementById('itemsBody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${rowCount}</td>
            <td>
                <input type="text" name="items[${rowCount}][item]" class="siigo-input" placeholder="Nombre del servicio" required>
            </td>
            <td>
                <input type="text" name="items[${rowCount}][descripcion]" class="siigo-input" placeholder="Detalles...">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][cantidad]" class="siigo-input qty" value="1" min="1" onchange="calculateTotals()">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][precio_unitario]" class="siigo-input price" value="0" min="0" onchange="calculateTotals()">
            </td>
            <td>
                <input type="text" class="siigo-input bg-gray-50 total-line" readonly value="$0">
            </td>
            <td>
                <button type="button" onclick="this.closest('tr').remove(); calculateTotals()" class="text-red-500 hover:text-red-700">
                    <span class="material-symbols-rounded">delete</span>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    }

    function calculateTotals() {
        let subtotal = 0;
        
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const total = qty * price;
            
            row.querySelector('.total-line').value = formatCurrency(total);
            subtotal += total;
        });

        // Simple tax calculation (can be expanded)
        const iva = 0; // Add logic if needed
        const total = subtotal + iva;

        document.getElementById('displaySubtotal').textContent = formatCurrency(subtotal);
        document.getElementById('displayTotal').textContent = formatCurrency(total);
        
        document.getElementById('inputSubtotal').value = subtotal;
        document.getElementById('inputTotal').value = total;
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
    }

    // Add initial row
    document.addEventListener('DOMContentLoaded', () => {
        addItemRow();
    });
</script>

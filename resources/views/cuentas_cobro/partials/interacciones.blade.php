{{-- resources/views/cuentas_cobro/partials/interacciones.blade.php --}}
<div class="wix-card">
    <h3 class="wix-card-title">
        <span class="material-symbols-rounded">chat</span>
        Historial de Interacciones
    </h3>

    @php $interacciones = $cuenta->interacciones ?? collect(); @endphp
    
    @if($interacciones->count() === 0)
        <div style="background:#f9fafb; border:1px dashed var(--wix-border); padding:16px; border-radius:8px; color:#8795a1; font-size:14px; text-align:center;">
            No hay interacciones registradas aún.
        </div>
    @else
        <div class="timeline">
            @foreach($interacciones as $inter)
                <div class="timeline-item">
                    <div class="timeline-dot" style="background: {{ $inter->getColor() ?? 'var(--wix-blue)' }}; border-color: {{ $inter->getColor() ?? 'var(--wix-blue)' }};"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-action" style="color: {{ $inter->getColor() ?? 'var(--wix-text)' }};">
                                {{ $inter->getEtiqueta() ?? ucfirst($inter->tipo) }}
                            </span>
                            <span class="timeline-date">{{ $inter->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div style="font-weight: 600; color: var(--wix-text); margin-bottom: 6px; font-size: 14px;">
                            {{ $inter->asunto }}
                        </div>
                        @if($inter->detalle)
                            <div style="font-size: 13px; color: #6b7c93; margin-bottom: 8px;">{{ $inter->detalle }}</div>
                        @endif
                        @if($inter->usuario)
                            <div style="font-size: 12px; color: #8795a1; display: flex; align-items: center; gap: 4px;">
                                <span class="material-symbols-rounded" style="font-size: 14px;">person</span>
                                {{ $inter->usuario->name }}
                            </div>
                        @endif

                        @if(Auth::id() === $inter->user_id || Auth::user()?->role?->name === 'super_admin')
                            <form action="{{ route('cuentas_cobro.interacciones.destroy', [$cuenta->id, $inter->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar interacción?')" style="margin-top: 8px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: var(--wix-danger); cursor: pointer; font-size: 12px; display: flex; align-items: center; gap: 4px; padding: 0;">
                                    <span class="material-symbols-rounded" style="font-size: 14px;">delete</span>
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Agregar nueva interacción -->
    @php 
        $canAddInteraccion = in_array(Auth::user()?->role?->name, ['auxiliar', 'administrador', 'tesoreria', 'admin_programa', 'super_admin']);
    @endphp

    @if($canAddInteraccion)
    <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--wix-border);">
        <h4 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 700; color: var(--wix-text);">Agregar Interacción</h4>
        <form action="{{ route('cuentas_cobro.interacciones.store', $cuenta->id) }}" method="POST">
            @csrf
            <div style="display: grid; gap: 16px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px; color: #8795a1;">Tipo</label>
                    <select name="tipo" required style="width: 100%; padding: 10px; border: 1px solid var(--wix-border); border-radius: 8px; font-size: 14px; background: #f9fafb;">
                        <option value="nota_manual">📝 Nota Manual</option>
                        <option value="llamada">☎️ Llamada</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px; color: #8795a1;">Asunto</label>
                    <input type="text" name="asunto" required maxlength="200" placeholder="Ej: Solicitud de información" style="width: 100%; padding: 10px; border: 1px solid var(--wix-border); border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px; color: #8795a1;">Detalle</label>
                    <textarea name="detalle" required maxlength="1000" rows="3" placeholder="Describa la interacción..." style="width: 100%; padding: 10px; border: 1px solid var(--wix-border); border-radius: 8px; font-size: 14px; font-family: inherit;"></textarea>
                </div>
                <button type="submit" class="wix-btn wix-btn-primary" style="width: auto; justify-content: center;">
                    <span class="material-symbols-rounded">add</span>
                    Registrar Interacción
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

{{-- resources/views/components/flash-modal.blade.php --}}
@php
    $toHtml = static function ($value) {
        if ($value instanceof \Illuminate\Support\HtmlString) {
            return $value->toHtml();
        }
        return (string) $value;
    };

    $messages = collect();

    $successRaw = session('success');
    if ($successRaw) {
        $successHtml = $toHtml($successRaw);
        $successText = \Illuminate\Support\Str::lower(strip_tags($successHtml));
        $successLabel = 'Operación exitosa';
        $successTitle = 'Acción completada';

        if (\Illuminate\Support\Str::contains($successText, ['cread'])) {
            $successLabel = 'Creación completada';
            $successTitle = 'Elemento creado';
        } elseif (\Illuminate\Support\Str::contains($successText, ['actualiz'])) {
            $successLabel = 'Actualización exitosa';
            $successTitle = 'Cambios guardados';
        } elseif (\Illuminate\Support\Str::contains($successText, ['elimin'])) {
            $successLabel = 'Elemento eliminado';
            $successTitle = 'Acción completada';
        }

        $messages->push([
            'tone' => 'success',
            'icon' => 'check_circle',
            'label' => session('success_label') ?? $successLabel,
            'title' => session('success_title') ?? $successTitle,
            'message' => $successHtml,
            'primaryLabel' => session('success_primary') ?? 'Entendido',
        ]);
    }

    $infoRaw = session('info') ?? session('status');
    if ($infoRaw) {
        $infoHtml = $toHtml($infoRaw);
        $messages->push([
            'tone' => 'info',
            'icon' => 'info',
            'label' => 'Actualización',
            'title' => session('info_title') ?? 'Información importante',
            'message' => $infoHtml,
            'primaryLabel' => session('info_primary') ?? 'Entendido',
        ]);
    }

    $warningRaw = session('warning');
    if ($warningRaw) {
        $warningHtml = $toHtml($warningRaw);
        $messages->push([
            'tone' => 'warning',
            'icon' => 'warning',
            'label' => 'Revisar datos',
            'title' => session('warning_title') ?? 'Atención requerida',
            'message' => $warningHtml,
            'primaryLabel' => session('warning_primary') ?? 'Comprendido',
        ]);
    }

    $permissionRaw = session('permission_error')
        ?? session('permission_denied')
        ?? session('permission_block')
        ?? session('permission');

    $errorRaw = session('error');
    $errorHtml = $errorRaw ? $toHtml($errorRaw) : null;

    if (!$permissionRaw && $errorHtml) {
        $errorText = \Illuminate\Support\Str::lower(strip_tags($errorHtml));
        if (\Illuminate\Support\Str::contains($errorText, ['permiso', 'autoriz', 'deneg', 'forbid'])) {
            $permissionRaw = $errorHtml;
            $errorHtml = null;
        }
    }

    if ($permissionRaw) {
        $permissionHtml = $permissionRaw instanceof \Illuminate\Support\HtmlString ? $permissionRaw->toHtml() : (string) $permissionRaw;
        $messages->push([
            'tone' => 'permission',
            'icon' => 'block',
            'label' => 'Acceso restringido',
            'title' => session('permission_title') ?? 'No tienes permisos',
            'message' => $permissionHtml,
            'primaryLabel' => session('permission_primary') ?? 'Entendido',
        ]);
    }

    if ($errorHtml) {
        $messages->push([
            'tone' => 'danger',
            'icon' => 'error',
            'label' => 'Acción detenida',
            'title' => session('error_title') ?? 'Ocurrió un problema',
            'message' => $errorHtml,
            'primaryLabel' => session('error_primary') ?? 'Entendido',
        ]);
    }

    $messages = $messages->values();
@endphp

@if($messages->isNotEmpty())
    @php $first = $messages->first(); @endphp
    <div class="flash-modal-backdrop" id="flashModalBackdrop" role="alertdialog" aria-live="assertive" aria-modal="true" data-messages='@json($messages)'>
        <div class="flash-modal-card flash-{{ $first['tone'] ?? 'info' }}">
            <button type="button" class="flash-modal-close" aria-label="Cerrar alerta" data-action="close">
                <span class="material-symbols-rounded">close</span>
            </button>
            <div class="flash-modal-header">
                <div class="flash-modal-icon" data-flash-icon>
                    <span class="material-symbols-rounded">{{ $first['icon'] ?? 'info' }}</span>
                </div>
                <div class="flash-modal-copy">
                    <p class="flash-modal-label" data-flash-label>{{ $first['label'] ?? 'Actualización' }}</p>
                    <h3 class="flash-modal-title" data-flash-title>{{ $first['title'] ?? 'Aviso' }}</h3>
                    <div class="flash-modal-message" data-flash-message>{!! $first['message'] !!}</div>
                    <div class="flash-modal-step" data-flash-step></div>
                </div>
            </div>
            <div class="flash-modal-actions">
                <button type="button" class="btn-ghost" data-action="close">Cerrar</button>
                <button type="button" class="btn-primary" data-action="primary">{{ $first['primaryLabel'] ?? 'Entendido' }}</button>
            </div>
        </div>
    </div>
    <script>
        (() => {
            const backdrop = document.getElementById('flashModalBackdrop');
            if (!backdrop) {
                return;
            }
            let queue = [];
            try {
                queue = JSON.parse(backdrop.dataset.messages || '[]');
            } catch (error) {
                queue = [];
            }
            if (!queue.length) {
                backdrop.remove();
                return;
            }

            const card = backdrop.querySelector('.flash-modal-card');
            const tones = ['success', 'info', 'warning', 'danger', 'permission'];
            const titleEl = card.querySelector('[data-flash-title]');
            const messageEl = card.querySelector('[data-flash-message]');
            const labelEl = card.querySelector('[data-flash-label]');
            const iconWrapper = card.querySelector('[data-flash-icon] .material-symbols-rounded');
            const stepEl = card.querySelector('[data-flash-step]');
            const closeButtons = card.querySelectorAll('[data-action="close"]');
            const primaryBtn = card.querySelector('[data-action="primary"]');
            let index = 0;

            const render = (position) => {
                const current = queue[position] || {};
                tones.forEach(tone => card.classList.remove(`flash-${tone}`));
                card.classList.add(`flash-${current.tone || 'info'}`);
                labelEl.textContent = current.label || 'Actualización';
                titleEl.textContent = current.title || 'Aviso';
                messageEl.innerHTML = current.message || '';
                if (iconWrapper) {
                    iconWrapper.textContent = current.icon || 'info';
                }
                const hasMultiple = queue.length > 1;
                if (hasMultiple) {
                    stepEl.textContent = `${position + 1} de ${queue.length}`;
                    stepEl.classList.add('is-visible');
                } else {
                    stepEl.classList.remove('is-visible');
                    stepEl.textContent = '';
                }
                if (primaryBtn) {
                    if (hasMultiple && position < queue.length - 1) {
                        primaryBtn.textContent = current.nextLabel || 'Siguiente';
                    } else {
                        primaryBtn.textContent = current.primaryLabel || 'Entendido';
                    }
                }
            };

            const closeModal = () => {
                backdrop.classList.remove('is-visible');
                setTimeout(() => backdrop.remove(), 220);
            };

            const handlePrimary = () => {
                if (index < queue.length - 1) {
                    index += 1;
                    render(index);
                    return;
                }
                closeModal();
            };

            closeButtons.forEach(btn => btn.addEventListener('click', closeModal));
            if (primaryBtn) {
                primaryBtn.addEventListener('click', handlePrimary);
            }

            backdrop.addEventListener('click', (event) => {
                if (event.target === backdrop) {
                    closeModal();
                }
            });

            window.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeModal();
                }
                if (event.key === 'Enter' && document.activeElement === primaryBtn) {
                    handlePrimary();
                }
            }, { once: false });

            render(index);
            requestAnimationFrame(() => {
                backdrop.classList.add('is-visible');
                primaryBtn?.focus();
            });
        })();
    </script>
@endif

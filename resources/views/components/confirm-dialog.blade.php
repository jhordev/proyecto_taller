@props([
    'id' => 'confirm-dialog',
    'title' => '¿Confirmar eliminación?',
    'message' => 'Esta acción no se puede deshacer.',
    'confirmText' => 'Eliminar',
    'cancelText' => 'Cancelar',
])

<!-- Overlay -->
<div
    id="{{ $id }}"
    style="display:none; position:fixed; inset:0; z-index:999; background:rgba(15,23,42,0.6); align-items:center; justify-content:center;"
    aria-modal="true"
    role="dialog"
>
    <!-- Dialog Box -->
    <div style="background:#fff; border:1px solid #e2e8f0; width:100%; max-width:400px; box-shadow:0 20px 40px rgba(0,0,0,0.2); margin:1rem;">
        <!-- Header -->
        <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; border-bottom:1px solid #e2e8f0;">
            <div style="width:32px; height:32px; background:#fee2e2; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px; height:18px; color:#ef4444; fill:none;" viewBox="0 0 24 24" stroke="#ef4444">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">{{ $title }}</h3>
        </div>

        <!-- Body -->
        <div style="padding:16px 20px;">
            <p style="font-size:14px; color:#64748b; margin:0; line-height:1.6;">{{ $message }}</p>
        </div>

        <!-- Actions -->
        <div style="display:flex; justify-content:flex-end; gap:10px; padding:12px 20px; border-top:1px solid #e2e8f0; background:#f8fafc;">
            <button
                type="button"
                onclick="closeConfirmDialog('{{ $id }}')"
                style="padding:8px 16px; border:1px solid #cbd5e1; background:#fff; color:#475569; font-size:13px; font-weight:600; cursor:pointer;"
                onmouseover="this.style.background='#f1f5f9'"
                onmouseout="this.style.background='#fff'"
            >
                {{ $cancelText }}
            </button>
            <button
                type="button"
                id="{{ $id }}-confirm-btn"
                style="padding:8px 16px; border:none; background:#dc2626; color:#fff; font-size:13px; font-weight:700; cursor:pointer;"
                onmouseover="this.style.background='#b91c1c'"
                onmouseout="this.style.background='#dc2626'"
            >
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    let _confirmForm = null;

    function openConfirmDialog(dialogId, form) {
        _confirmForm = form;
        const dialog = document.getElementById(dialogId);
        dialog.style.display = 'flex';

        document.getElementById(dialogId + '-confirm-btn').onclick = function () {
            if (_confirmForm) _confirmForm.submit();
        };
    }

    function closeConfirmDialog(dialogId) {
        const dialog = document.getElementById(dialogId);
        dialog.style.display = 'none';
        _confirmForm = null;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[role="dialog"]').forEach(function (dialog) {
            dialog.addEventListener('click', function (e) {
                if (e.target === dialog) closeConfirmDialog(dialog.id);
            });
        });
    });
</script>
@endpush
@endonce

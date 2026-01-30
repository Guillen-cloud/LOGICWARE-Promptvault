<style>
    /* ===== Modal ===== */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .62);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 18px;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal {
        width: min(520px, 100%);
        border-radius: 18px;
        background: linear-gradient(145deg, rgba(10, 15, 28, .96), rgba(8, 12, 22, .96));
        border: 1px solid rgba(255, 255, 255, .10);
        box-shadow: 0 30px 90px rgba(0, 0, 0, .55);
        overflow: hidden;
    }

    .modal-head {
        padding: 16px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, .08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        background: linear-gradient(90deg, rgba(99, 102, 241, .16), rgba(168, 85, 247, .12));
    }

    .modal-head h3 {
        margin: 0;
        color: rgba(255, 255, 255, .95);
        font-weight: 1000;
        letter-spacing: -.2px;
        font-size: 16px;
    }

    .modal-close {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, .12);
        background: rgba(255, 255, 255, .06);
        color: rgba(255, 255, 255, .90);
        cursor: pointer;
        font-weight: 1000;
    }

    .modal-body {
        padding: 16px;
    }

    .modal-body p {
        margin: 0 0 10px 0;
        color: rgba(255, 255, 255, .70);
        font-weight: 700;
        line-height: 1.6;
        font-size: 13px;
    }

    .danger-box {
        margin-top: 10px;
        border-radius: 14px;
        padding: 12px;
        border: 1px solid rgba(248, 113, 113, .22);
        background: rgba(248, 113, 113, .10);
        color: rgba(255, 255, 255, .88);
        font-weight: 800;
        font-size: 13px;
    }

    .modal-foot {
        padding: 14px 16px;
        border-top: 1px solid rgba(255, 255, 255, .08);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .m-btn {
        padding: 10px 14px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, .12);
        background: rgba(255, 255, 255, .06);
        color: rgba(255, 255, 255, .92);
        font-weight: 1000;
        cursor: pointer;
    }

    .m-btn:hover {
        background: rgba(255, 255, 255, .08);
    }

    .m-btn--danger {
        border-color: rgba(248, 113, 113, .28);
        background: rgba(248, 113, 113, .16);
        color: rgba(255, 255, 255, .95);
    }

    .m-btn--danger:hover {
        background: rgba(248, 113, 113, .22);
    }
</style>

<div id="userDeleteModal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal">
        <div class="modal-head">
            <h3>Eliminar usuario</h3>
            <button type="button" class="modal-close" onclick="closeUserDeleteModal()">✕</button>
        </div>

        <div class="modal-body">
            <p>
                Estás a punto de eliminar a:
                <strong id="deleteUserName" style="color: rgba(255,255,255,.95); font-weight: 1000;"></strong>
            </p>

            <div class="danger-box">
                Esta acción es irreversible. Se eliminará el usuario del sistema.
            </div>
        </div>

        <div class="modal-foot">
            <button type="button" class="m-btn" onclick="closeUserDeleteModal()">Cancelar</button>

            <form id="userDeleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="m-btn m-btn--danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openUserDeleteModal(btn) {
        const id = btn.getAttribute('data-delete-id');
        const name = btn.getAttribute('data-delete-name') || 'este usuario';

        const modal = document.getElementById('userDeleteModal');
        const nameEl = document.getElementById('deleteUserName');
        const form = document.getElementById('userDeleteForm');

        nameEl.textContent = name;

        // ⚠️ Ajusta si tu prefijo de ruta cambia
        form.action = `/admin/users/${id}`;

        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');

        // Cerrar con ESC
        document.addEventListener('keydown', escCloseOnce);
    }

    function closeUserDeleteModal() {
        const modal = document.getElementById('userDeleteModal');
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        document.removeEventListener('keydown', escCloseOnce);
    }

    function escCloseOnce(e) {
        if (e.key === 'Escape') closeUserDeleteModal();
    }

    // Cerrar si clic fuera
    document.addEventListener('click', function (e) {
        const modal = document.getElementById('userDeleteModal');
        if (!modal.classList.contains('show')) return;
        if (e.target === modal) closeUserDeleteModal();
    });
</script>
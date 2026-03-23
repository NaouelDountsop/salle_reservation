{{-- ============================================================
    rooms/index.blade.php — Pinterest Grid + Modal de réservation
    ============================================================ --}}

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

{{-- ══ TOAST de confirmation ══ --}}
@if(session('success'))
<div id="toast" class="toast toast--success" role="alert" aria-live="polite">
    <span class="toast__icon">✅</span>
    <div class="toast__body">
        <strong class="toast__title">Réservation confirmée !</strong>
        <p class="toast__msg">{{ session('success') }}</p>
    </div>
    <button class="toast__close" aria-label="Fermer">&times;</button>
</div>
@endif

@if(session('error'))
<div id="toast" class="toast toast--error" role="alert" aria-live="polite">
    <span class="toast__icon">❌</span>
    <div class="toast__body">
        <strong class="toast__title">Erreur</strong>
        <p class="toast__msg">{{ session('error') }}</p>
    </div>
    <button class="toast__close" aria-label="Fermer">&times;</button>
</div>
@endif

{{-- ══ Hero Header ══ --}}
<header class="site-hero">

    {{-- 🔔 Cloche de notification --}}
    <div class="notif-bell" id="notifBell" aria-label="Notifications">
        <svg class="notif-bell__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        @php $notifCount = session('notifications') ? count(session('notifications')) : 0; @endphp
        @if($notifCount > 0)
            <span class="notif-bell__badge">{{ $notifCount }}</span>
        @endif

        {{-- Panneau déroulant --}}
        <div class="notif-panel" id="notifPanel" role="menu">
            <div class="notif-panel__header">
                <span class="notif-panel__title">Notifications</span>
                <button class="notif-panel__clear" id="notifClear">Tout effacer</button>
            </div>
            <ul class="notif-panel__list" id="notifList">
                @forelse(session('notifications', []) as $notif)
                    <li class="notif-item notif-item--{{ $notif['type'] ?? 'info' }}">
                        <span class="notif-item__dot"></span>
                        <div>
                            <p class="notif-item__msg">{{ $notif['message'] }}</p>
                            <p class="notif-item__time">{{ $notif['time'] ?? '' }}</p>
                        </div>
                    </li>
                @empty
                    <li class="notif-empty">Aucune notification</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="site-hero__inner">
        <p class="site-hero__eyebrow">Bienvenue sur</p>
        <h1 class="site-hero__title">
            <span class="site-hero__title-line">L'espace</span>
            <em class="site-hero__title-accent">de vos idées</em>
        </h1>
        <p class="site-hero__sub">Trouvez et réservez la salle parfaite pour vos réunions, workshops et événements.</p>
    </div>
    <div class="site-hero__deco" aria-hidden="true">
        <span class="deco-dot deco-dot--1"></span>
        <span class="deco-dot deco-dot--2"></span>
        <span class="deco-dot deco-dot--3"></span>
    </div>
</header>


    {{-- ── Actions header à côté de la cloche ── --}}
    <div class="header-actions">
        <div class="btn-header-container" title="Mes réservations">
            <div class="btn-header btn-reservations"> <span class="btn-label">📅Mes réservations</span></div>
            <span class="btn-label"></span>
        </div>

        <div class="btn-header-container" title="Admin">
            <div class="btn-header btn-admin">⚙️Admin</div>
            <span class="btn-label"></span>
        </div>
    </div>
</header>

{{-- ══ Pinterest Grid des salles ══ --}}
<div class="pinterest-grid">
    @foreach($rooms as $room)
        <div class="pin-card">
            <div class="pin-image-container">
                @if($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" loading="lazy" decoding="async" class="pin-image">
                @else
                    <div class="pin-placeholder">🏠</div>
                @endif

                <div class="pin-overlay">
                    <button
                        type="button"
                        class="pin-btn open-modal"
                        data-id="{{ $room->id }}"
                        data-name="{{ $room->name }}"
                        data-description="{{ $room->description ?? 'Pas de description disponible.' }}"
                    >
                        Réserver
                    </button>
                </div>
            </div>

            <div class="pin-content">
                <h3 class="pin-title">{{ $room->name }}</h3>
                <p class="pin-location">📍 {{ $room->location }}</p>
                <span class="pin-badge">🪑 {{ $room->capacity }} places</span>
            </div>
        </div>
    @endforeach
</div>

{{-- ══════════════════════════════════════════════════════════
     MODAL — Réservation de salle
     ══════════════════════════════════════════════════════════ --}}
@if($errors->any())
<script>
    window.__modalError = {
        roomId:   "{{ old('room_id') }}",
        roomName: "{{ old('room_name', '') }}",
        start:    "{{ old('start_time') }}",
        end:      "{{ old('end_time') }}",
        errors:   @json($errors->all())
    };
</script>
@endif

<div id="reservationModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modalRoomName">
    <div class="modal-content modal-large">
        <button class="close-modal" aria-label="Fermer">&times;</button>

        <div class="modal-header">
            <p class="modal-room-label">Réservation</p>
            <h2 id="modalRoomName">Nom de la salle</h2>
            <p id="modalRoomDescription" class="modal-description">Description de la salle</p>
            <p class="modal-subtitle">Choisissez vos créneaux horaires ci-dessous.</p>
        </div>

        <div class="modal-body">
            <form method="POST" action="{{ route('reservations.store') }}">
                @csrf
                <input type="hidden" name="room_id" id="modalRoomId">
                <input type="hidden" name="room_name" id="modalRoomName_hidden">

                <div class="modal-error" id="modalError" role="alert" aria-live="assertive"></div>

                <div class="date-row">
                    <div class="form-group">
                        <label for="start_time">Début</label>
                        <input type="datetime-local" id="start_time" name="start_time" required>
                    </div>

                    <div class="form-group">
                        <label for="end_time">Fin</label>
                        <input type="datetime-local" id="end_time" name="end_time" required>
                    </div>
                </div>

                @auth
                    <button type="submit" class="btn-confirm">Confirmer la réservation</button>
                @else
                    <div class="auth-required-box">
    <p class="auth-required-text">🔒 Connectez-vous pour finaliser votre réservation</p>

    <div class="auth-buttons">
        <a href="{{ route('login') }}" class="btn-auth btn-login">
            Se connecter
        </a>

        <a href="{{ route('register') }}" class="btn-auth btn-register">
            S'inscrire
        </a>
    </div>
</div>
                @endauth
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     JS — Modale + Notifications + Toast
     ══════════════════════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    const modal           = document.getElementById('reservationModal');
    const closeBtn        = modal.querySelector('.close-modal');
    const modalIdInput    = document.getElementById('modalRoomId');
    const modalNameHidden = document.getElementById('modalRoomName_hidden');
    const modalTitle      = document.getElementById('modalRoomName');
    const modalDescription = document.getElementById('modalRoomDescription');
    const startInput      = document.getElementById('start_time');
    const endInput        = document.getElementById('end_time');
    const errorBox        = document.getElementById('modalError');

    const pad       = n => String(n).padStart(2, '0');
    const toLocalISO = d =>
        `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:00`;

    function showError(msg) {
        errorBox.innerHTML = `<span class="modal-error__icon">⚠️</span> ${msg}`;
        errorBox.classList.add('modal-error--visible');
        [startInput, endInput].forEach(el => {
            el.classList.add('input--error');
            el.addEventListener('input', () => el.classList.remove('input--error'), { once: true });
        });
    }

    function clearError() {
        errorBox.classList.remove('modal-error--visible');
        errorBox.innerHTML = '';
    }

    function openModal(roomId, roomName, start = null, end = null, description = '') {
        modalIdInput.value    = roomId;
        modalNameHidden.value = roomName;
        modalTitle.innerText  = roomName || 'Réservation';
        modalDescription.innerText = description || 'Pas de description disponible.';
        clearError();

        if (start && end) {
            startInput.value = start;
            endInput.value   = end;
        } else {
            const now = new Date();
            now.setMinutes(0,0,0);
            now.setHours(now.getHours()+1);
            startInput.value = toLocalISO(now);
            now.setHours(now.getHours()+1);
            endInput.value = toLocalISO(now);
        }

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (window.__modalError) {
        const { roomId, roomName, start, end, errors } = window.__modalError;
        openModal(roomId, roomName, start, end);
        if (errors && errors.length) showError(errors[0]);
    }

    document.querySelector('.pinterest-grid').addEventListener('click', function (e) {
        const btn = e.target.closest('.open-modal');
        if (!btn) return;
        openModal(btn.dataset.id, btn.dataset.name, null, null, btn.dataset.description);
    });

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

    modal.querySelector('form').addEventListener('submit', function (e) {
        clearError();
        if (!startInput.value || !endInput.value) {
            e.preventDefault();
            showError('Veuillez remplir les deux champs de date.');
            return;
        }
        if (endInput.value <= startInput.value) {
            e.preventDefault();
            showError('L\'heure de fin doit être après l\'heure de début.');
            endInput.classList.add('input--error');
            endInput.focus();
        }
    });

    const bell      = document.getElementById('notifBell');
    const panel     = document.getElementById('notifPanel');
    const clearBtn  = document.getElementById('notifClear');

    if (bell && panel) {
        bell.addEventListener('click', function (e) {
            e.stopPropagation();
            panel.classList.toggle('notif-panel--open');
        });
        document.addEventListener('click', function(e){if(!bell.contains(e.target)) panel.classList.remove('notif-panel--open');});
        if(clearBtn){clearBtn.addEventListener('click', e=>{e.stopPropagation();document.getElementById('notifList').innerHTML='<li class="notif-empty">Aucune notification</li>';const badge=bell.querySelector('.notif-bell__badge');if(badge) badge.remove();});}
    }

    const toast = document.getElementById('toast');
    if (toast) {
        requestAnimationFrame(()=>toast.classList.add('toast--visible'));
        const autoClose = setTimeout(()=>dismissToast(toast),4000);
        toast.querySelector('.toast__close').addEventListener('click',()=>{clearTimeout(autoClose);dismissToast(toast);});
    }

    function dismissToast(el){el.classList.remove('toast--visible');el.classList.add('toast--hiding');el.addEventListener('transitionend',()=>el.remove(),{once:true});}

})();
</script>

{{-- ══ Styles supplémentaires pour modal-large et description ══ --}}
<style>
.modal-large { max-width: 600px; width: 90%; padding: 1.5rem; border-radius: 12px; }
.modal-description { font-size: 1rem; color: #555; margin: 0.5rem 0 1rem 0; line-height: 1.5; text-align: center; }
</style>
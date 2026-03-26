{{-- ============================================================
    rooms/index.blade.php — Gold Edition
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


{{-- ══ TOPBAR ══ --}}
<nav class="site-topbar">

    <a href="{{ route('rooms.index') }}" class="topbar-logo">
        <div class="topbar-logo__mark">
            <svg viewBox="0 0 16 16"><path d="M3 8h10M8 3v10"/></svg>
        </div>
        <span class="topbar-logo__name">EspaceIdées</span>
    </a>

    <div class="topbar-nav">
        <a href="{{ route('rooms.index') }}"
           class="topbar-nav__link {{ request()->routeIs('rooms.index') ? 'active' : '' }}">
           Salles
        </a>
        @auth
        <a href="{{ route('reservations.index') }}"
           class="topbar-nav__link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
           Mes réservations
        </a>
        @endauth
        <a href="#" class="topbar-nav__link">Calendrier</a>
    </div>

    <div class="topbar-actions">

        {{-- Cloche --}}
        <div class="notif-bell" id="notifBell" aria-label="Notifications">
            <svg class="notif-bell__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            @php $notifCount = session('notifications') ? count(session('notifications')) : 0; @endphp
            @if($notifCount > 0)
                <span class="notif-bell__badge">{{ $notifCount }}</span>
            @endif
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

        {{-- Bouton Admin topbar --}}
        @auth
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn-admin">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <circle cx="12" cy="8" r="3"/>
                    <path d="M12 11c-5 0-8 2.5-8 4v1h16v-1c0-1.5-3-4-8-4z"/>
                    <path d="M19 3l2 2-7 7-3-1 1-3z"/>
                </svg>
                Admin
            </a>
            @endif
        @endauth

        {{-- Utilisateur connecté --}}
        @auth
        <div class="user-pill" id="userPill">
            <div class="user-pill__avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
            </div>
            <span class="user-pill__name">{{ auth()->user()->name }}</span>
            <svg class="user-pill__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
            <div class="user-dropdown" id="userDropdown">
                <div class="user-dropdown__header">
                    <p class="user-dropdown__name">{{ auth()->user()->name }}</p>
                    <p class="user-dropdown__email">{{ auth()->user()->email }}</p>
                </div>
                <ul class="user-dropdown__list">
                    <li><a href="{{ route('reservations.index') }}" class="user-dropdown__link">📅 Mes réservations</a></li>
                    <li><a href="#" class="user-dropdown__link">⚙️ Mon profil</a></li>
                    @if(auth()->user()->role === 'admin')
                    <li class="user-dropdown__sep"></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="user-dropdown__link user-dropdown__admin">🛡️ Administration</a></li>
                    @endif
                    <li class="user-dropdown__sep"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="user-dropdown__link user-dropdown__logout">
                                🚪 Se déconnecter
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @else
        <a href="{{ route('login') }}" class="btn-auth btn-login" style="height:36px;display:inline-flex;align-items:center;">
            Se connecter
        </a>
        @endauth

    </div>
</nav>


{{-- ══ HERO ══ --}}
<header class="site-hero">
    <div class="site-hero__inner">
        <p class="site-hero__eyebrow">Bienvenue sur</p>
        <h1 class="site-hero__title">
            <span class="site-hero__title-line">L'espace</span>
            <em class="site-hero__title-accent">de vos idées</em>
        </h1>
        <p class="site-hero__sub">
            Trouvez et réservez la salle parfaite pour vos réunions, workshops et événements.
        </p>
    </div>
    <div class="site-hero__stats">
        <div class="hero-stat">
            <div class="hero-stat__val">{{ $rooms->count() }}</div>
            <div class="hero-stat__lbl">Salles</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat__val">{{ $rooms->where('available', true)->count() ?? $rooms->count() }}</div>
            <div class="hero-stat__lbl">Disponibles</div>
        </div>
        @auth
        <div class="hero-stat">
            <div class="hero-stat__val">{{ auth()->user()->reservations()->count() ?? 0 }}</div>
            <div class="hero-stat__lbl">Mes RDV</div>
        </div>
        @endauth
    </div>
</header>


{{-- ══ BANNIÈRE ADMIN ══ --}}
@auth
    @if(auth()->user()->role === 'admin')
    <div class="admin-banner">
        <div class="admin-banner__inner">
            <div class="admin-banner__left">
                <div class="admin-banner__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <div>
                    <p class="admin-banner__title">Mode administrateur</p>
                    <p class="admin-banner__sub">Vous avez accès au tableau de bord de gestion</p>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="admin-banner__btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Tableau de bord Admin
                <svg class="admin-banner__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    @endif
@endauth


{{-- ══ FILTRES ══ --}}
<div class="filters-bar">
    <div class="filters-bar__left">
        <button class="filter-chip active" data-filter="all">Toutes</button>
        <button class="filter-chip" data-filter="small">Petites ≤6</button>
        <button class="filter-chip" data-filter="medium">Moyennes 6–15</button>
        <button class="filter-chip" data-filter="large">Grandes 15+</button>
        <button class="filter-chip" data-filter="available">Disponibles</button>
    </div>
    <div class="filters-bar__right">
        <span class="sort-label">Trier par</span>
        <select class="sort-select" id="sortSelect">
            <option value="name">Nom</option>
            <option value="capacity">Capacité</option>
            <option value="location">Étage</option>
        </select>
    </div>
</div>


{{-- ══ SECTION HEADER ══ --}}
<div class="section-header">
    <span class="section-header__title">Salles disponibles</span>
    <span class="section-header__count">{{ $rooms->count() }} salle{{ $rooms->count() > 1 ? 's' : '' }}</span>
</div>


{{-- ══ GRILLE PINTEREST ══ --}}
<div class="pinterest-grid">
    @foreach($rooms as $room)
        <div class="pin-card"
             data-capacity="{{ $room->capacity }}"
             data-name="{{ $room->name }}"
             data-location="{{ $room->location }}">

            <div class="pin-image-container">
                @if($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" loading="lazy" class="pin-image">
                @else
                    <div class="pin-placeholder">🏠</div>
                @endif

                @if($room->capacity >= 15)
                    <span class="pin-ribbon">⭐ Grande salle</span>
                @endif

                <div class="pin-overlay">
                    <button
                        type="button"
                        class="pin-btn open-modal"
                        data-id="{{ $room->id }}"
                        data-name="{{ $room->name }}"
                        data-description="{{ $room->description ?? 'Pas de description disponible.' }}"
                        data-capacity="{{ $room->capacity }}"
                        data-location="{{ $room->location }}"
                    >
                        Réserver
                    </button>
                </div>
            </div>

            <div class="pin-content">
                <h3 class="pin-title">{{ $room->name }}</h3>
                <p class="pin-location">📍 {{ $room->location }}</p>
                <div class="pin-footer">
                    <span class="pin-badge">🪑 {{ $room->capacity }} places</span>
                    <span class="pin-status--free">● Libre</span>
                </div>
            </div>
        </div>
    @endforeach
</div>


{{-- ══ MODAL ══ --}}
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
            <div class="modal-meta">
                <span class="modal-meta-chip" id="modalCapacityChip">🪑 — places</span>
                <span class="modal-meta-chip" id="modalLocationChip">📍 —</span>
            </div>
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
                    <button type="submit" class="btn-confirm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/></svg>
                        Confirmer la réservation
                    </button>
                @else
                    <div class="auth-required-box">
                        <p class="auth-required-text">🔒 Connectez-vous pour finaliser votre réservation</p>
                        <div class="auth-buttons">
                            <a href="{{ route('login') }}" class="btn-auth btn-login">Se connecter</a>
                            <a href="{{ route('register') }}" class="btn-auth btn-register">S'inscrire</a>
                        </div>
                    </div>
                @endauth
            </form>
        </div>
    </div>
</div>


{{-- ══ STYLES ══ --}}
<style>

/* ── Bannière admin ── */
.admin-banner {
    background: var(--ink);
    border-bottom: 1px solid rgba(201,146,42,0.25);
    padding: 0 48px;
    position: relative;
    overflow: hidden;
}
.admin-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 60% 200% at 100% 50%, rgba(201,146,42,0.12) 0%, transparent 60%);
    pointer-events: none;
}
.admin-banner__inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    position: relative;
    z-index: 1;
}
.admin-banner__left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.admin-banner__icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: rgba(201,146,42,0.15);
    border: 1px solid rgba(201,146,42,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.admin-banner__icon svg {
    width: 16px;
    height: 16px;
    stroke: var(--gold-lt);
}
.admin-banner__title {
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.01em;
}
.admin-banner__sub {
    font-size: 11px;
    color: rgba(255,255,255,0.4);
    margin-top: 1px;
}
.admin-banner__btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    background: linear-gradient(135deg, var(--gold-lt), var(--gold));
    color: #fff;
    border-radius: var(--radius-pill);
    font-family: 'Instrument Sans', sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-decoration: none;
    transition: all var(--t);
    box-shadow: 0 4px 16px rgba(201,146,42,0.35);
    flex-shrink: 0;
}
.admin-banner__btn svg {
    width: 13px;
    height: 13px;
    stroke: rgba(255,255,255,0.85);
    flex-shrink: 0;
}
.admin-banner__arrow { transition: transform var(--t); }
.admin-banner__btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 28px rgba(201,146,42,0.50);
}
.admin-banner__btn:hover .admin-banner__arrow { transform: translateX(3px); }

/* ── Lien admin dans le dropdown ── */
.user-dropdown__admin { color: var(--gold-dk) !important; font-weight: 600 !important; }
.user-dropdown__admin:hover { background: var(--gold-bg) !important; }

/* ── Dropdown utilisateur ── */
.user-pill { position: relative; }
.user-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 220px;
    background: #fff;
    border: 1px solid #ede8df;
    border-radius: 16px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.14);
    overflow: hidden;
    opacity: 0;
    transform: translateY(-8px) scale(0.97);
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.16,1,0.3,1);
    transform-origin: top right;
    z-index: 300;
}
.user-dropdown--open { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
.user-dropdown__header { padding: 14px 16px 12px; border-bottom: 1px solid #ede8df; background: #fdf6e3; }
.user-dropdown__name { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: #0e0d0b; letter-spacing: -0.01em; }
.user-dropdown__email { font-size: 11px; color: rgba(14,13,11,0.4); margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.user-dropdown__list { list-style: none; padding: 6px 0; }
.user-dropdown__link { display: block; width: 100%; padding: 9px 16px; font-family: 'Instrument Sans', sans-serif; font-size: 13px; color: #0e0d0b; text-decoration: none; border: none; background: none; cursor: pointer; text-align: left; transition: background 0.2s; }
.user-dropdown__link:hover { background: #f4f0e8; }
.user-dropdown__sep { height: 1px; background: #ede8df; margin: 4px 0; }
.user-dropdown__logout { color: #c0392b; }
.user-dropdown__logout:hover { background: rgba(239,68,68,0.06); }

@media (max-width: 640px) {
    .admin-banner { padding: 0 20px; }
    .admin-banner__sub { display: none; }
    .admin-banner__btn { padding: 8px 14px; font-size: 11px; }
    .admin-banner__btn svg:first-child { display: none; }
}
</style>


{{-- ══ JS ══ --}}
<script>
(function () {
    'use strict';

    /* ── Modal ── */
    const modal            = document.getElementById('reservationModal');
    const closeBtn         = modal.querySelector('.close-modal');
    const modalIdInput     = document.getElementById('modalRoomId');
    const modalNameHidden  = document.getElementById('modalRoomName_hidden');
    const modalTitle       = document.getElementById('modalRoomName');
    const modalDescription = document.getElementById('modalRoomDescription');
    const modalCapChip     = document.getElementById('modalCapacityChip');
    const modalLocChip     = document.getElementById('modalLocationChip');
    const startInput       = document.getElementById('start_time');
    const endInput         = document.getElementById('end_time');
    const errorBox         = document.getElementById('modalError');

    const pad        = n => String(n).padStart(2, '0');
    const toLocalISO = d =>
        `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:00`;

    function showError(msg) {
        errorBox.innerHTML = `<span>⚠️</span> ${msg}`;
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

    function openModal(roomId, roomName, start = null, end = null, description = '', capacity = '', location = '') {
        modalIdInput.value    = roomId;
        modalNameHidden.value = roomName;
        modalTitle.textContent = roomName || 'Réservation';
        modalDescription.textContent = description || 'Pas de description disponible.';
        if (modalCapChip) modalCapChip.textContent = `🪑 ${capacity || '—'} places`;
        if (modalLocChip) modalLocChip.textContent = `📍 ${location || '—'}`;
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
        openModal(
            btn.dataset.id,
            btn.dataset.name,
            null, null,
            btn.dataset.description,
            btn.dataset.capacity,
            btn.dataset.location
        );
    });

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    modal.querySelector('form').addEventListener('submit', function (e) {
        clearError();
        if (!startInput.value || !endInput.value) {
            e.preventDefault();
            showError('Veuillez remplir les deux champs de date.');
            return;
        }
        if (endInput.value <= startInput.value) {
            e.preventDefault();
            showError("L'heure de fin doit être après l'heure de début.");
            endInput.classList.add('input--error');
            endInput.focus();
        }
    });

    /* ── Notification panel ── */
    const bell     = document.getElementById('notifBell');
    const panel    = document.getElementById('notifPanel');
    const clearBtn = document.getElementById('notifClear');

    if (bell && panel) {
        bell.addEventListener('click', e => {
            e.stopPropagation();
            panel.classList.toggle('notif-panel--open');
        });
        document.addEventListener('click', e => {
            if (!bell.contains(e.target)) panel.classList.remove('notif-panel--open');
        });
        if (clearBtn) {
            clearBtn.addEventListener('click', e => {
                e.stopPropagation();
                document.getElementById('notifList').innerHTML = '<li class="notif-empty">Aucune notification</li>';
                const badge = bell.querySelector('.notif-bell__badge');
                if (badge) badge.remove();
            });
        }
    }

    /* ── Dropdown utilisateur ── */
    const userPill     = document.getElementById('userPill');
    const userDropdown = document.getElementById('userDropdown');

    if (userPill && userDropdown) {
        userPill.addEventListener('click', e => {
            e.stopPropagation();
            userDropdown.classList.toggle('user-dropdown--open');
        });
        document.addEventListener('click', e => {
            if (!userPill.contains(e.target)) userDropdown.classList.remove('user-dropdown--open');
        });
    }

    /* ── Filtres ── */
    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.addEventListener('click', function () {
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('.pin-card').forEach(card => {
                const cap = parseInt(card.dataset.capacity) || 0;
                let show = true;
                if (filter === 'small')  show = cap <= 6;
                if (filter === 'medium') show = cap > 6 && cap <= 15;
                if (filter === 'large')  show = cap > 15;
                card.style.display = show ? '' : 'none';
            });
        });
    });

    /* ── Tri ── */
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            const grid  = document.querySelector('.pinterest-grid');
            const cards = [...grid.querySelectorAll('.pin-card')];
            cards.sort((a, b) => {
                if (this.value === 'capacity') return (parseInt(a.dataset.capacity)||0) - (parseInt(b.dataset.capacity)||0);
                if (this.value === 'name')     return (a.dataset.name||'').localeCompare(b.dataset.name||'');
                if (this.value === 'location') return (a.dataset.location||'').localeCompare(b.dataset.location||'');
                return 0;
            });
            cards.forEach(c => grid.appendChild(c));
        });
    }

    /* ── Toast ── */
    const toast = document.getElementById('toast');
    if (toast) {
        requestAnimationFrame(() => toast.classList.add('toast--visible'));
        const autoClose = setTimeout(() => dismissToast(toast), 4500);
        toast.querySelector('.toast__close').addEventListener('click', () => {
            clearTimeout(autoClose);
            dismissToast(toast);
        });
    }

    function dismissToast(el) {
        el.classList.remove('toast--visible');
        el.classList.add('toast--hiding');
        el.addEventListener('transitionend', () => el.remove(), { once: true });
    }

})();
</script>
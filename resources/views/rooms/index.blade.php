<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EspaceIdées — Salles</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

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
           class="topbar-nav__link {{ request()->routeIs('rooms.index') ? 'active' : '' }}">Salles</a>
        @auth
        <a href="{{ route('reservations.index') }}"
           class="topbar-nav__link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">Mes réservations</a>
        @endauth
        <a href="#" class="topbar-nav__link">Calendrier</a>
    </div>

    <div class="topbar-actions">

        <div class="notif-bell" id="notifBell" aria-label="Notifications">
            <svg class="notif-bell__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            @php $notifCount = session('notifications') ? count(session('notifications')) : 0; @endphp
            @if($notifCount > 0)<span class="notif-bell__badge">{{ $notifCount }}</span>@endif
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
            @else
                <a href="{{ route('login') }}?unauthorized=1" class="btn-admin btn-admin--locked">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Admin
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-admin btn-admin--locked">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Admin
            </a>
        @endauth

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
                            <button type="submit" class="user-dropdown__link user-dropdown__logout">🚪 Se déconnecter</button>
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
        <p class="site-hero__sub">Trouvez et réservez la salle parfaite pour vos réunions, workshops et événements.</p>
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
                @auth
                    @if(auth()->user()->role === 'admin')
                        <p class="admin-banner__title">Mode administrateur</p>
                        <p class="admin-banner__sub">Vous avez accès au tableau de bord de gestion</p>
                    @else
                        <p class="admin-banner__title">Espace Administration</p>
                        <p class="admin-banner__sub">Accès réservé aux administrateurs</p>
                    @endif
                @else
                    <p class="admin-banner__title">Espace Administration</p>
                    <p class="admin-banner__sub">Connectez-vous avec un compte administrateur</p>
                @endauth
            </div>
        </div>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="admin-banner__btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Tableau de bord Admin
                    <svg class="admin-banner__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}?unauthorized=1" class="admin-banner__btn admin-banner__btn--locked">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Accès restreint
                    <svg class="admin-banner__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="admin-banner__btn admin-banner__btn--locked">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Se connecter
                <svg class="admin-banner__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        @endauth
    </div>
</div>


{{-- ══ FILTRES ══ --}}
<div class="filters-bar">
    <div class="filters-bar__left">

        {{-- Groupe : Capacité --}}
        <button class="filter-chip active" data-filter="all"    data-group="capacity">Toutes</button>
        <button class="filter-chip"        data-filter="small"  data-group="capacity">Petites ≤100</button>
        <button class="filter-chip"        data-filter="medium" data-group="capacity">Moyennes 100-200</button>
        <button class="filter-chip"        data-filter="large"  data-group="capacity">Grandes 200+</button>

        {{-- Séparateur --}}
        <span style="width:1px;background:var(--stone);margin:4px 6px;flex-shrink:0;"></span>

        {{-- Groupe : Type --}}
        <button class="filter-chip active"  data-filter="all"        data-group="type">Tous types</button>
        <button class="filter-chip"         data-filter="standard"   data-group="type">⭐ Standard</button>
        <button class="filter-chip"         data-filter="premium"    data-group="type">✨ Premium</button>
        <button class="filter-chip"         data-filter="vip"        data-group="type">👑 VIP</button>
        <button class="filter-chip"         data-filter="conference" data-group="type">🎤 Conférence</button>
        <button class="filter-chip"         data-filter="coworking"  data-group="type">💼 Coworking</button>
        <button class="filter-chip"         data-filter="mariage"    data-group="type">💒 Mariage</button>

    </div>
    <div class="filters-bar__right">
        <span class="sort-label">Trier par</span>
        <select class="sort-select" id="sortSelect">
            <option value="name">Nom</option>
            <option value="capacity">Capacité</option>
            <option value="location">Étage</option>
            <option value="type">Type</option>
        </select>
    </div>
</div>


{{-- ══ SECTION HEADER ══ --}}
<div class="section-header">
    <span class="section-header__title">Salles disponibles</span>
    <span class="section-header__count" id="roomCount">
        {{ $rooms->count() }} salle{{ $rooms->count() > 1 ? 's' : '' }}
    </span>
</div>


{{-- ══ GRILLE PINTEREST ══ --}}
<div class="pinterest-grid">
    @foreach($rooms as $room)
        @php
            $roomType   = $room->type ?? 'standard';
            $typeLabels = [
                'standard'   => ['⭐', 'Standard'],
                'premium'    => ['✨', 'Premium'],
                'vip'        => ['👑', 'VIP'],
                'conference' => ['🎤', 'Conférence'],
                'coworking'  => ['💼', 'Coworking'],
                'mariage'    => ['💒', 'Mariage'],
            ];
            $typeInfo = $typeLabels[$roomType] ?? ['⭐', ucfirst($roomType)];
        @endphp
        <div class="pin-card"
             data-capacity="{{ $room->capacity }}"
             data-name="{{ $room->name }}"
             data-location="{{ $room->location }}"
             data-type="{{ $roomType }}">

            <div class="pin-image-container">

                @if($room->image)
                    @if(str_starts_with($room->image, 'data:'))
                        <img src="{{ $room->image }}" alt="{{ $room->name }}" loading="lazy" class="pin-image">
                    @else
                        <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" loading="lazy" class="pin-image">
                    @endif
                @else
                    <div class="pin-placeholder">🏠</div>
                @endif

                {{-- Ruban type --}}
                <span class="pin-ribbon">{{ $typeInfo[0] }} {{ $typeInfo[1] }}</span>

                <div class="pin-overlay">
                    <button type="button" class="pin-btn open-modal"
                        data-id="{{ $room->id }}"
                        data-name="{{ $room->name }}"
                        data-description="{{ $room->description ?? 'Pas de description disponible.' }}"
                        data-capacity="{{ $room->capacity }}"
                        data-location="{{ $room->location }}"
                        data-price="{{ $room->prix }}">
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
                <span class="modal-meta-chip" id="modalPriceChip">💰 — FCFA</span>
            </div>
        </div>

        <div class="modal-body">
            <form method="POST" action="{{ route('reservations.store') }}">
                @csrf
                <input type="hidden" name="room_id"   id="modalRoomId">
                <input type="hidden" name="room_name"  id="modalRoomName_hidden">

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

                <div class="form-group">
                    <label class="payment-label">Mode de paiement</label>
                    <input type="hidden" name="payment_method" id="payment_method" value="">
                    <div class="payment-cards" id="paymentCards">

                        <button type="button" class="payment-card" data-value="cash" aria-pressed="false">
                            <div class="payment-card__icon">
                                <svg viewBox="0 0 48 48" fill="none">
                                    <rect x="4" y="12" width="40" height="26" rx="4" stroke="currentColor" stroke-width="2.5" fill="none"/>
                                    <circle cx="24" cy="25" r="7" stroke="currentColor" stroke-width="2.5" fill="none"/>
                                    <circle cx="24" cy="25" r="3" fill="currentColor"/>
                                    <line x1="4" y1="19" x2="44" y2="19" stroke="currentColor" stroke-width="2"/>
                                    <line x1="4" y1="31" x2="44" y2="31" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </div>
                            <span class="payment-card__name">Espèces</span>
                            <span class="payment-card__desc">Paiement sur place</span>
                            <span class="payment-card__check">
                                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/></svg>
                            </span>
                        </button>

                        <button type="button" class="payment-card" data-value="mobile_money" aria-pressed="false">
                            <div class="payment-card__icon">
                                <svg viewBox="0 0 48 48" fill="none">
                                    <rect x="13" y="4" width="22" height="40" rx="4" stroke="currentColor" stroke-width="2.5" fill="none"/>
                                    <line x1="13" y1="12" x2="35" y2="12" stroke="currentColor" stroke-width="2"/>
                                    <line x1="13" y1="36" x2="35" y2="36" stroke="currentColor" stroke-width="2"/>
                                    <circle cx="24" cy="40" r="2" fill="currentColor"/>
                                    <path d="M19 22 L24 18 L29 22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                    <path d="M24 18 L24 28" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M20 28 L28 28" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="payment-card__name">Mobile Money</span>
                            <span class="payment-card__desc">MTN / Orange Money</span>
                            <span class="payment-card__check">
                                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/></svg>
                            </span>
                        </button>

                        <button type="button" class="payment-card" data-value="card" aria-pressed="false">
                            <div class="payment-card__icon">
                                <svg viewBox="0 0 48 48" fill="none">
                                    <rect x="4" y="10" width="40" height="28" rx="4" stroke="currentColor" stroke-width="2.5" fill="none"/>
                                    <rect x="4" y="17" width="40" height="7" fill="currentColor" opacity="0.15"/>
                                    <line x1="4" y1="17" x2="44" y2="17" stroke="currentColor" stroke-width="2"/>
                                    <rect x="10" y="28" width="10" height="4" rx="1" fill="currentColor" opacity="0.5"/>
                                    <rect x="24" y="28" width="6" height="4" rx="1" fill="currentColor" opacity="0.3"/>
                                </svg>
                            </div>
                            <span class="payment-card__name">Carte bancaire</span>
                            <span class="payment-card__desc">Visa / Mastercard</span>
                            <span class="payment-card__check">
                                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/></svg>
                            </span>
                        </button>

                    </div>
                </div>

                @auth
                    <button type="submit" class="btn-confirm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/>
                        </svg>
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


{{-- ══ JS ══ --}}
<script>
(function () {
    'use strict';

    /*
       FILTRES (capacité + type combinés)
     */
    const activeFilters = { capacity: 'all', type: 'all' };

    function applyFilters() {
        const cards = document.querySelectorAll('.pin-card');
        let visible = 0;

        cards.forEach(card => {
            const cap  = parseInt(card.dataset.capacity) || 0;
            const type = card.dataset.type || 'standard';

            let showCap = true;
            if (activeFilters.capacity === 'small')  showCap = cap <= 100;
            if (activeFilters.capacity === 'medium') showCap = cap > 100 && cap <= 200;
            if (activeFilters.capacity === 'large')  showCap = cap > 200;

            const showType = activeFilters.type === 'all' || type === activeFilters.type;

            const show = showCap && showType;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        const countEl = document.getElementById('roomCount');
        if (countEl) countEl.textContent = visible + ' salle' + (visible > 1 ? 's' : '');
    }

    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.addEventListener('click', function () {
            const group = this.dataset.group;
            // Désactive uniquement les chips du même groupe
            document.querySelectorAll(`.filter-chip[data-group="${group}"]`)
                    .forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            activeFilters[group] = this.dataset.filter;
            applyFilters();
        });
    });

    /* ════════════════════════════
       TRI
    ════════════════════════════ */
    const typeOrder = { standard:0, premium:1, vip:2, conference:3, coworking:4, mariage:5 };

    document.getElementById('sortSelect').addEventListener('change', function () {
        const g     = document.querySelector('.pinterest-grid');
        const cards = [...g.querySelectorAll('.pin-card')];
        cards.sort((a, b) => {
            if (this.value === 'capacity') return (parseInt(a.dataset.capacity)||0) - (parseInt(b.dataset.capacity)||0);
            if (this.value === 'name')     return (a.dataset.name||'').localeCompare(b.dataset.name||'');
            if (this.value === 'location') return (a.dataset.location||'').localeCompare(b.dataset.location||'');
            if (this.value === 'type')     return (typeOrder[a.dataset.type]??99) - (typeOrder[b.dataset.type]??99);
            return 0;
        });
        cards.forEach(c => g.appendChild(c));
    });

    /* ════════════════════════════
       MODAL
    ════════════════════════════ */
    const modal           = document.getElementById('reservationModal');
    const closeBtn        = modal.querySelector('.close-modal');
    const modalIdInput    = document.getElementById('modalRoomId');
    const modalNameHidden = document.getElementById('modalRoomName_hidden');
    const modalTitle      = document.getElementById('modalRoomName');
    const modalDesc       = document.getElementById('modalRoomDescription');
    const modalCapChip    = document.getElementById('modalCapacityChip');
    const modalLocChip    = document.getElementById('modalLocationChip');
    const modalPriceChip  = document.getElementById('modalPriceChip');
    const startInput      = document.getElementById('start_time');
    const endInput        = document.getElementById('end_time');
    const paymentMethod   = document.getElementById('payment_method');
    const errorBox        = document.getElementById('modalError');
    const form            = modal.querySelector('form');
    const submitBtn       = form.querySelector('.btn-confirm');
    const paymentCards    = document.getElementById('paymentCards');

    let pricePerHour = 0;

    const pad        = n => String(n).padStart(2, '0');
    const toLocalISO = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:00`;

    function showError(msg) {
        errorBox.innerHTML = `<span>⚠️</span> ${msg}`;
        errorBox.classList.add('modal-error--visible');
    }
    function clearError() {
        errorBox.classList.remove('modal-error--visible');
        errorBox.innerHTML = '';
    }
    function updatePrice() {
        const s = new Date(startInput.value), e = new Date(endInput.value);
        if (startInput.value && endInput.value && e > s) {
            modalPriceChip.textContent = `💰 ${Math.ceil((e-s)/3600000 * pricePerHour).toLocaleString('fr-FR')} FCFA`;
        } else {
            modalPriceChip.textContent = `💰 ${pricePerHour.toLocaleString('fr-FR')} FCFA/h`;
        }
    }
    function resetPaymentCards() {
        paymentCards.querySelectorAll('.payment-card').forEach(c => {
            c.classList.remove('selected'); c.setAttribute('aria-pressed','false');
        });
        paymentMethod.value = '';
    }
    function openModal(id, name, start, end, desc, cap, loc, price) {
        modalIdInput.value    = id;
        modalNameHidden.value = name;
        modalTitle.textContent = name || 'Réservation';
        modalDesc.textContent  = desc || 'Pas de description disponible.';
        modalCapChip.textContent   = `🪑 ${cap||'—'} places`;
        modalLocChip.textContent   = `📍 ${loc||'—'}`;
        pricePerHour = parseFloat(price)||0;
        modalPriceChip.textContent = `💰 ${pricePerHour.toLocaleString('fr-FR')} FCFA/h`;
        clearError();
        if (start && end) {
            startInput.value = start; endInput.value = end;
        } else {
            const now = new Date(); now.setMinutes(0,0,0); now.setHours(now.getHours()+1);
            startInput.value = toLocalISO(now); now.setHours(now.getHours()+1); endInput.value = toLocalISO(now);
        }
        updatePrice(); resetPaymentCards();
        modal.classList.add('active'); document.body.style.overflow = 'hidden';
    }
    function closeModal() { modal.classList.remove('active'); document.body.style.overflow = ''; }

    startInput.addEventListener('change', updatePrice);
    endInput.addEventListener('change',   updatePrice);

    if (window.__modalError) {
        const { roomId, roomName, start, end, errors } = window.__modalError;
        openModal(roomId, roomName, start, end);
        if (errors?.length) showError(errors[0]);
    }

    document.querySelector('.pinterest-grid').addEventListener('click', e => {
        const btn = e.target.closest('.open-modal');
        if (!btn) return;
        openModal(btn.dataset.id, btn.dataset.name, null, null,
                  btn.dataset.description, btn.dataset.capacity,
                  btn.dataset.location, btn.dataset.price);
    });

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    paymentCards.addEventListener('click', e => {
        const card = e.target.closest('.payment-card');
        if (!card) return;
        paymentCards.querySelectorAll('.payment-card').forEach(c => {
            c.classList.remove('selected'); c.setAttribute('aria-pressed','false');
        });
        card.classList.add('selected'); card.setAttribute('aria-pressed','true');
        paymentMethod.value = card.dataset.value;
    });

    form.addEventListener('submit', function (e) {
        clearError();
        if (!startInput.value || !endInput.value) { e.preventDefault(); showError('Veuillez remplir les deux champs de date.'); return; }
        if (endInput.value <= startInput.value)   { e.preventDefault(); showError("L'heure de fin doit être après l'heure de début."); endInput.classList.add('input--error'); endInput.focus(); return; }
        if (!paymentMethod.value)                  { e.preventDefault(); showError('Veuillez choisir un mode de paiement.'); return; }
        if (submitBtn) submitBtn.disabled = true;
        showError({ mobile_money:'📱 Paiement Mobile Money en cours...', card:'💳 Paiement par carte en cours...', cash:'💵 Paiement en espèces enregistré...' }[paymentMethod.value] || 'Traitement en cours...');
        e.preventDefault(); setTimeout(() => form.submit(), 2000);
    });

    /* ════════════════════════════
       NOTIFICATIONS
     */
    const bell  = document.getElementById('notifBell');
    const panel = document.getElementById('notifPanel');
    const clearBtn = document.getElementById('notifClear');
    if (bell && panel) {
        bell.addEventListener('click', e => { e.stopPropagation(); panel.classList.toggle('notif-panel--open'); });
        document.addEventListener('click', e => { if (!bell.contains(e.target)) panel.classList.remove('notif-panel--open'); });
        if (clearBtn) clearBtn.addEventListener('click', e => {
            e.stopPropagation();
            document.getElementById('notifList').innerHTML = '<li class="notif-empty">Aucune notification</li>';
            bell.querySelector('.notif-bell__badge')?.remove();
        });
    }

    /*
       DROPDOWN USER
   */
    const userPill     = document.getElementById('userPill');
    const userDropdown = document.getElementById('userDropdown');
    if (userPill && userDropdown) {
        userPill.addEventListener('click', e => { e.stopPropagation(); userDropdown.classList.toggle('user-dropdown--open'); });
        document.addEventListener('click', e => { if (!userPill.contains(e.target)) userDropdown.classList.remove('user-dropdown--open'); });
    }

    /* 
       TOAST
    */
    const toast = document.getElementById('toast');
    if (toast) {
        requestAnimationFrame(() => toast.classList.add('toast--visible'));
        const t = setTimeout(() => dismissToast(toast), 4500);
        toast.querySelector('.toast__close').addEventListener('click', () => { clearTimeout(t); dismissToast(toast); });
    }
    function dismissToast(el) {
        el.classList.remove('toast--visible'); el.classList.add('toast--hiding');
        el.addEventListener('transitionend', () => el.remove(), { once: true });
    }

})();
</script>

</body>
</html>
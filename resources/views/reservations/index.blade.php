
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

{{-- ══ TOAST ══ --}}
@if(session('success'))
<div id="toast" class="toast toast--success" role="alert" aria-live="polite">
    <span class="toast__icon">✅</span>
    <div class="toast__body">
        <strong class="toast__title">Succès</strong>
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

        @auth
            @if(auth()->user()->is_admin ?? false)
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
        <p class="site-hero__eyebrow">Mon espace</p>
        <h1 class="site-hero__title">
            <span class="site-hero__title-line">Mes</span>
            <em class="site-hero__title-accent">réservations</em>
        </h1>
        <p class="site-hero__sub">
            Retrouvez toutes vos réservations passées et à venir en un coup d'œil.
        </p>
    </div>
    <div class="site-hero__stats">
        <div class="hero-stat">
            <div class="hero-stat__val">{{ $reservations->count() }}</div>
            <div class="hero-stat__lbl">Total</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat__val">
                {{ $reservations->filter(fn($r) => \Carbon\Carbon::parse($r->start_time)->isFuture())->count() }}
            </div>
            <div class="hero-stat__lbl">À venir</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat__val">
                {{ $reservations->filter(fn($r) => \Carbon\Carbon::parse($r->start_time)->isPast())->count() }}
            </div>
            <div class="hero-stat__lbl">Passées</div>
        </div>
    </div>
</header>


{{-- ══ FILTRES ══ --}}
<div class="filters-bar">
    <div class="filters-bar__left">
        <button class="filter-chip active" data-resv-filter="all">Toutes</button>
        <button class="filter-chip" data-resv-filter="upcoming">À venir</button>
        <button class="filter-chip" data-resv-filter="past">Passées</button>
    </div>
    <div class="filters-bar__right">
        <span class="sort-label">Trier par</span>
        <select class="sort-select" id="resvSortSelect">
            <option value="date-asc">Date ↑</option>
            <option value="date-desc">Date ↓</option>
            <option value="room">Salle</option>
        </select>
    </div>
</div>


{{-- ══ SECTION HEADER ══ --}}
<div class="section-header">
    <span class="section-header__title">Toutes les réservations</span>
    <span class="section-header__count">
        {{ $reservations->count() }} réservation{{ $reservations->count() > 1 ? 's' : '' }}
    </span>
</div>


{{-- ══ CONTENU ══ --}}
<div class="resv-page">

    @if($reservations->count() > 0)

        <div class="resv-grid" id="resvList">

            @foreach($reservations as $reservation)
                @php
                    $start         = \Carbon\Carbon::parse($reservation->start_time);
                    $end           = \Carbon\Carbon::parse($reservation->end_time);
                    $isPast        = $start->isPast();
                    $isToday       = $start->isToday();
                    $duration      = $start->diffInMinutes($end);
                    $hours         = intdiv($duration, 60);
                    $mins          = $duration % 60;
                    $durationLabel = $hours > 0
                        ? $hours . 'h' . ($mins > 0 ? $mins : '')
                        : $mins . 'min';

                    $countdown = null;
                    if ($isToday && !$isPast) {
                        $diffMins = now()->diffInMinutes($start, false);
                        if ($diffMins > 0 && $diffMins < 60)  $countdown = 'Dans ' . $diffMins . 'min';
                        elseif ($diffMins >= 60)               $countdown = 'Dans ' . intdiv($diffMins, 60) . 'h';
                    }

                    $dowLabels = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
                    $dow = $dowLabels[$start->dayOfWeek];
                @endphp

                {{-- ══ CARTE (5 zones : stripe / image / header / body / footer) ══ --}}
                <div class="resv-card {{ $isPast ? 'resv-card--past' : 'resv-card--upcoming' }}"
                     data-status="{{ $isPast ? 'past' : 'upcoming' }}"
                     data-start="{{ $start->timestamp }}"
                     data-room="{{ $reservation->room->name ?? '' }}">

                    {{-- 1. STRIPE --}}
                    <div class="resv-card__stripe"></div>

                    {{-- 2. IMAGE --}}
                    <div class="resv-card__image">
                        @if($reservation->room && $reservation->room->image)
                            <img src="{{ asset('storage/' . $reservation->room->image) }}"
                                 alt="{{ $reservation->room->name }}">
                        @else
                            <div class="resv-card__placeholder">🏢</div>
                        @endif
                    </div>

                    {{-- 3. HEADER SOMBRE --}}
                    <div class="resv-card__header">

                        <div class="resv-card__header-row">
                            <div class="resv-card__date">
                                <span class="resv-card__dow">{{ $dow }}</span>
                                <span class="resv-card__day">{{ $start->format('d') }}</span>
                                <span class="resv-card__month-year">
                                    {{ strtoupper($start->translatedFormat('M')) }} {{ $start->format('Y') }}
                                </span>
                            </div>
                            @if($isToday)
                                <span class="resv-badge resv-badge--today">Aujourd'hui</span>
                            @elseif(!$isPast)
                                <span class="resv-badge resv-badge--upcoming">À venir</span>
                            @else
                                <span class="resv-badge resv-badge--past">Terminée</span>
                            @endif
                        </div>

                        <h3 class="resv-card__room">{{ $reservation->room->name ?? 'Salle inconnue' }}</h3>
                        <p class="resv-card__loc">
                            📍 {{ $reservation->room->location ?? '—' }}
                            @if($reservation->room->capacity ?? false)
                                · {{ $reservation->room->capacity }} places
                            @endif
                        </p>

                    </div>{{-- /resv-card__header --}}

                    {{-- 4. BODY — horaires --}}
                    <div class="resv-card__body">
                        <div class="resv-card__times">

                            <div class="resv-tblock">
                                <span class="resv-tblock__lbl">Début</span>
                                <span class="resv-tblock__val">{{ $start->format('H:i') }}</span>
                            </div>

                            <div class="resv-ttrack {{ $isPast ? 'resv-ttrack--past' : '' }}">
                                <svg viewBox="0 0 60 8" preserveAspectRatio="none" fill="none">
                                    <line x1="0" y1="4" x2="50" y2="4" stroke-width="1" stroke-dasharray="3 2"/>
                                    <path d="M46 1.5L51 4L46 6.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="resv-dur {{ $isPast ? 'resv-dur--past' : '' }}">{{ $durationLabel }}</span>
                            </div>

                            <div class="resv-tblock">
                                <span class="resv-tblock__lbl">Fin</span>
                                <span class="resv-tblock__val">{{ $end->format('H:i') }}</span>
                            </div>

                        </div>
                    </div>{{-- /resv-card__body --}}

                    {{-- 5. FOOTER — action --}}
                    <div class="resv-card__footer">

                        @if($countdown)
                            <span class="resv-countdown">{{ $countdown }}</span>
                        @elseif($reservation->room->capacity ?? false)
                            <span class="resv-cap">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <circle cx="12" cy="8" r="3"/>
                                    <path d="M20 21a8 8 0 1 0-16 0"/>
                                </svg>
                                {{ $reservation->room->capacity }} places
                            </span>
                        @else
                            <span></span>
                        @endif

                        @if(!$isPast)
                            <form method="POST"
                                  action="{{ route('reservations.destroy', $reservation->id) }}"
                                  class="resv-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="resv-btn resv-btn--cancel">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2.5" stroke-linecap="round">
                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                        <line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                    Annuler
                                </button>
                            </form>
                        @else
                            <a href="{{ route('rooms.index') }}" class="resv-btn resv-btn--rebook">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round">
                                    <path d="M1 4v6h6"/>
                                    <path d="M3.51 15a9 9 0 1 0 .49-3.51"/>
                                </svg>
                                Rebooker
                            </a>
                        @endif

                    </div>{{-- /resv-card__footer --}}

                </div>{{-- /resv-card --}}

            @endforeach

        </div>{{-- /resv-grid --}}

    @else

        <div class="resv-empty">
            <div class="resv-empty__icon">
                <svg viewBox="0 0 64 64" fill="none">
                    <rect x="8" y="14" width="48" height="44" rx="6" stroke="currentColor" stroke-width="2"/>
                    <path d="M8 26h48" stroke="currentColor" stroke-width="2"/>
                    <path d="M20 8v12M44 8v12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M20 38h4M30 38h4M40 38h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M20 46h4M30 46h4M40 46h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h2 class="resv-empty__title">Aucune réservation</h2>
            <p class="resv-empty__text">
                Vous n'avez encore effectué aucune réservation.<br>
                Explorez nos salles et réservez dès maintenant.
            </p>
            <a href="{{ route('rooms.index') }}" class="btn-confirm"
               style="display:inline-flex;width:auto;padding:14px 32px;text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Voir les salles
            </a>
        </div>

    @endif

</div>{{-- /resv-page --}}


{{-- ══ STYLES ══ --}}
<style>

/* ─── Page wrapper ─── */
.resv-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 48px 64px;
}

/* ─── Grille 3 colonnes ─── */
.resv-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 28px;
}

/* ═══════════════════════════════════════
   CARTE — flex colonne, rapport carré
   Structure :
     stripe (3px)
     image  (80px)
     header (auto, fond sombre)
     body   (flex:1, horaires)
     footer (auto, action)
   ═══════════════════════════════════════ */
.resv-card {
    display: flex;
    flex-direction: column;
    background: var(--surface);
    border: 1px solid var(--stone);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-card);
    transition: transform var(--t), box-shadow var(--t), border-color var(--t);
    cursor: pointer;
    animation: cardIn 0.45s var(--ease-out) both;
    aspect-ratio: 1 / 1;
}
.resv-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,.12);
    border-color: var(--gold-rim);
}
.resv-card--past       { opacity: .72; }
.resv-card--past:hover { opacity: 1; }

/* 1. Stripe */
.resv-card__stripe {
    height: 3px;
    flex-shrink: 0;
    background: linear-gradient(to right, var(--gold-lt), var(--gold));
}
.resv-card--past .resv-card__stripe { background: var(--stone); }

/* 2. Image */
.resv-card__image {
    flex-shrink: 0;
    height: 80px;
    overflow: hidden;
}
.resv-card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .5s var(--ease-out);
}
.resv-card:hover .resv-card__image img { transform: scale(1.06); }
.resv-card__placeholder {
    width: 100%;
    height: 100%;
    background: var(--stone-2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
}

/* 3. Header sombre */
.resv-card__header {
    flex-shrink: 0;
    background: var(--ink);
    padding: 12px 14px 10px;
    position: relative;
    overflow: hidden;
}
.resv-card__header::after {
    content: '';
    position: absolute;
    right: -14px; top: -14px;
    width: 72px; height: 72px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,146,42,.2) 0%, transparent 70%);
    pointer-events: none;
}
.resv-card--past .resv-card__header { background: #2a2926; }

.resv-card__header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 7px;
}

.resv-card__date       { display: flex; flex-direction: column; line-height: 1; }
.resv-card__dow        { font-size: 8px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--gold); margin-bottom: 2px; }
.resv-card__day        { font-family: 'Syne', sans-serif; font-size: 1.7rem; font-weight: 800; color: #fff; letter-spacing: -.04em; line-height: .9; }
.resv-card__month-year { font-size: 8px; font-weight: 600; color: rgba(255,255,255,.32); letter-spacing: .08em; text-transform: uppercase; margin-top: 4px; }

.resv-card--past .resv-card__dow  { color: rgba(255,255,255,.3); }
.resv-card--past .resv-card__day  { color: rgba(255,255,255,.45); }

.resv-badge { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: var(--radius-pill); font-size: 8px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; font-family: 'Instrument Sans', sans-serif; flex-shrink: 0; }
.resv-badge--upcoming { background: rgba(201,146,42,.18); color: rgba(232,184,75,.9);   border: 1px solid rgba(201,146,42,.35); }
.resv-badge--today    { background: rgba(201,146,42,.22); color: var(--gold-lt);         border: 1px solid rgba(201,146,42,.5); box-shadow: 0 0 0 2px rgba(201,146,42,.12); }
.resv-badge--past     { background: rgba(255,255,255,.06); color: rgba(255,255,255,.35); border: 1px solid rgba(255,255,255,.12); }

.resv-card__room { font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 800; color: #fff; letter-spacing: -.02em; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; position: relative; z-index: 1; }
.resv-card__loc  { font-size: 10px; color: rgba(255,255,255,.32); margin-top: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; position: relative; z-index: 1; }

/* 4. Body — horaires */
.resv-card__body {
    flex: 1;
    display: flex;
    align-items: center;
    padding: 0 14px;
    min-height: 0;
}
.resv-card__times {
    display: flex;
    align-items: center;
    gap: 6px;
    width: 100%;
}
.resv-tblock           { display: flex; flex-direction: column; align-items: center; }
.resv-tblock__lbl      { font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: .14em; color: var(--ink-40); }
.resv-tblock__val      { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 800; color: var(--ink); letter-spacing: -.02em; line-height: 1.1; }

.resv-ttrack           { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 2px; }
.resv-ttrack svg       { width: 100%; height: 8px; display: block; }
.resv-ttrack svg line,
.resv-ttrack svg path  { stroke: var(--gold); }
.resv-ttrack--past svg line,
.resv-ttrack--past svg path { stroke: var(--stone); }

.resv-dur       { font-size: 9px; font-weight: 700; color: var(--gold-dk); background: var(--gold-bg); border: 1px solid var(--gold-rim); padding: 1px 6px; border-radius: var(--radius-pill); font-family: 'Instrument Sans', sans-serif; }
.resv-dur--past { background: var(--stone-2); border-color: var(--stone); color: var(--ink-40); }

/* 5. Footer */
.resv-card__footer {
    flex-shrink: 0;
    border-top: 1px solid var(--stone);
    padding: 9px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.resv-countdown { font-size: 9px; font-weight: 700; color: var(--gold-dk); background: var(--gold-bg); border: 1px solid var(--gold-rim); border-radius: var(--radius-pill); padding: 2px 8px; font-family: 'Instrument Sans', sans-serif; }
.resv-cap       { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; color: var(--ink-40); }

.resv-btn     { display: inline-flex; align-items: center; gap: 4px; height: 28px; padding: 0 12px; border-radius: var(--radius-pill); font-family: 'Instrument Sans', sans-serif; font-size: 10px; font-weight: 700; cursor: pointer; text-decoration: none; transition: all var(--t); border: none; letter-spacing: .02em; white-space: nowrap; }
.resv-btn svg { width: 10px; height: 10px; flex-shrink: 0; }
.resv-btn--cancel       { background: transparent; color: #c0392b; border: 1px solid rgba(239,68,68,.25); }
.resv-btn--cancel:hover { background: rgba(239,68,68,.08); }
.resv-btn--rebook       { background: var(--gold-bg); color: var(--gold-dk); border: 1px solid var(--gold-rim); }
.resv-btn--rebook:hover { background: var(--gold); color: #fff; }

.resv-delete-form { display: contents; }

/* ─── État vide ─── */
.resv-empty { text-align: center; padding: 80px 40px; display: flex; flex-direction: column; align-items: center; gap: 16px; }
.resv-empty__icon { width: 72px; height: 72px; border-radius: var(--radius-xl); background: var(--gold-bg); border: 1px solid var(--gold-rim); display: flex; align-items: center; justify-content: center; color: var(--gold); margin-bottom: 8px; }
.resv-empty__icon svg { width: 36px; height: 36px; }
.resv-empty__title { font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 800; color: var(--ink); letter-spacing: -.03em; }
.resv-empty__text  { font-size: 14px; color: var(--ink-40); max-width: 340px; line-height: 1.65; margin-bottom: 8px; }

/* ─── Animation ─── */
@keyframes cardIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.resv-grid .resv-card:nth-child(1)   { animation-delay: .04s; }
.resv-grid .resv-card:nth-child(2)   { animation-delay: .08s; }
.resv-grid .resv-card:nth-child(3)   { animation-delay: .12s; }
.resv-grid .resv-card:nth-child(4)   { animation-delay: .16s; }
.resv-grid .resv-card:nth-child(5)   { animation-delay: .20s; }
.resv-grid .resv-card:nth-child(n+6) { animation-delay: .24s; }

/* ─── Dropdown utilisateur ─── */
.user-pill { position: relative; }
.user-dropdown { position: absolute; top: calc(100% + 10px); right: 0; width: 220px; background: #fff; border: 1px solid #ede8df; border-radius: 16px; box-shadow: 0 16px 48px rgba(0,0,0,.14); overflow: hidden; opacity: 0; transform: translateY(-8px) scale(.97); pointer-events: none; transition: opacity .2s ease, transform .2s cubic-bezier(.16,1,.3,1); transform-origin: top right; z-index: 300; }
.user-dropdown--open { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
.user-dropdown__header { padding: 14px 16px 12px; border-bottom: 1px solid #ede8df; background: #fdf6e3; }
.user-dropdown__name   { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: #0e0d0b; }
.user-dropdown__email  { font-size: 11px; color: rgba(14,13,11,.4); margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.user-dropdown__list   { list-style: none; padding: 6px 0; }
.user-dropdown__link   { display: block; width: 100%; padding: 9px 16px; font-family: 'Instrument Sans', sans-serif; font-size: 13px; color: #0e0d0b; text-decoration: none; border: none; background: none; cursor: pointer; text-align: left; transition: background .2s; }
.user-dropdown__link:hover   { background: #f4f0e8; }
.user-dropdown__sep          { height: 1px; background: #ede8df; margin: 4px 0; }
.user-dropdown__logout       { color: #c0392b; }
.user-dropdown__logout:hover { background: rgba(239,68,68,.06); }

/* ─── Responsive ─── */
@media (max-width: 1024px) {
    .resv-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 600px) {
    .resv-page { padding: 0 16px 40px; }
    .resv-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
    .resv-card__image { height: 60px; }
}
@media (max-width: 400px) {
    .resv-grid { grid-template-columns: 1fr; }
    .resv-card { aspect-ratio: auto; min-height: 260px; }
}

</style>


{{-- ══ JS ══ --}}
<script>
(function () {
    'use strict';

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
    document.querySelectorAll('[data-resv-filter]').forEach(chip => {
        chip.addEventListener('click', function () {
            document.querySelectorAll('[data-resv-filter]').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.resvFilter;
            document.querySelectorAll('.resv-card').forEach(card => {
                card.style.display = (filter === 'all' || card.dataset.status === filter) ? '' : 'none';
            });
            const visible = [...document.querySelectorAll('.resv-card')].filter(c => c.style.display !== 'none').length;
            const countEl = document.querySelector('.section-header__count');
            if (countEl) countEl.textContent = visible + ' réservation' + (visible > 1 ? 's' : '');
        });
    });

    /* ── Tri ── */
    const sortSelect = document.getElementById('resvSortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            const grid  = document.getElementById('resvList');
            if (!grid) return;
            const cards = [...grid.querySelectorAll('.resv-card')];
            cards.sort((a, b) => {
                if (this.value === 'date-asc')  return (parseInt(a.dataset.start) || 0) - (parseInt(b.dataset.start) || 0);
                if (this.value === 'date-desc') return (parseInt(b.dataset.start) || 0) - (parseInt(a.dataset.start) || 0);
                if (this.value === 'room')      return (a.dataset.room || '').localeCompare(b.dataset.room || '');
                return 0;
            });
            cards.forEach(c => grid.appendChild(c));
        });
    }

    /* ── Confirmation suppression ── */
    document.querySelectorAll('.resv-delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm('Annuler cette réservation définitivement ?')) e.preventDefault();
        });
    });

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

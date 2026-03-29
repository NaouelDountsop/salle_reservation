<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — EspaceIdées</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

{{-- ══ HAMBURGER ══ --}}
<button class="sidebar-hamburger" id="sidebarHamburger"
        aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="adminSidebar">
    <span class="sidebar-hamburger__bar"></span>
    <span class="sidebar-hamburger__bar"></span>
    <span class="sidebar-hamburger__bar"></span>
</button>

{{-- ══ TOPBAR MOBILE ══ --}}
<div class="admin-mobile-topbar" aria-hidden="true">
    <a href="{{ route('rooms.index') }}" class="admin-mobile-topbar__logo">
        <div class="admin-mobile-topbar__mark">
            <svg viewBox="0 0 16 16"><path d="M3 8h10M8 3v10"/></svg>
        </div>
        <span class="admin-mobile-topbar__name">EspaceIdées</span>
        <span class="admin-mobile-topbar__badge">Admin</span>
    </a>
    <span class="admin-mobile-topbar__crumb" id="mobileBreadcrumb">Tableau de bord</span>
</div>

{{-- ══ OVERLAY SIDEBAR MOBILE ══ --}}
<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

<div class="admin-layout">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navigation principale">

        <a href="{{ route('rooms.index') }}" class="sidebar-logo">
            <div class="sidebar-logo__mark">
                <svg viewBox="0 0 16 16"><path d="M3 8h10M8 3v10"/></svg>
            </div>
            <span class="sidebar-logo__name">EspaceIdées</span>
            <span class="sidebar-logo__badge">Admin</span>
        </a>

        <nav class="sidebar-nav">
            <span class="sidebar-nav__label">Vue générale</span>
            <button class="sidebar-nav__link active" data-panel="dashboard">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                Tableau de bord
            </button>
            <span class="sidebar-nav__label">Gestion</span>
            <button class="sidebar-nav__link" data-panel="rooms">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Salles
                <span class="sidebar-nav__count">{{ $totalRooms }}</span>
            </button>
            <button class="sidebar-nav__link" data-panel="reservations">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Réservations
                <span class="sidebar-nav__count">{{ $totalReservations }}</span>
            </button>
            <button class="sidebar-nav__link" data-panel="users">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                Utilisateurs
                <span class="sidebar-nav__count">{{ $totalUsers }}</span>
            </button>
        </nav>

        <div class="sidebar-footer">
            @auth
            <div class="sidebar-user">
                <div class="sidebar-user__avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                </div>
                <div class="sidebar-user__info">
                    <div class="sidebar-user__name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user__role">Administrateur</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout" title="Se déconnecter">
                        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </aside>

    {{-- ══ ZONE PRINCIPALE ══ --}}
    <div class="admin-main">

        <div class="admin-topbar">
            <div class="admin-topbar__left">
                <span class="admin-topbar__crumb">EspaceIdées</span>
                <span class="admin-topbar__sep">/</span>
                <span class="admin-topbar__crumb active" id="breadcrumb">Tableau de bord</span>
            </div>
            <span class="admin-topbar__date" id="adminDate"></span>
        </div>

        <header class="admin-hero">
            <div class="admin-hero__inner">
                <p class="admin-hero__eyebrow">Administration</p>
                <h1 class="admin-hero__title">Tableau de <em>bord</em></h1>
                <p class="admin-hero__sub">Bienvenue, <strong style="color:var(--gold-lt);font-weight:600;">{{ auth()->user()->name }}</strong></p>
            </div>
            <div class="admin-hero__stats">
                <div class="hero-stat"><div class="hero-stat__val">{{ $totalUsers }}</div><div class="hero-stat__lbl">Utilisateurs</div></div>
                <div class="hero-stat"><div class="hero-stat__val">{{ $totalReservations }}</div><div class="hero-stat__lbl">Réservations</div></div>
                <div class="hero-stat"><div class="hero-stat__val">{{ $totalRooms }}</div><div class="hero-stat__lbl">Salles</div></div>
            </div>
        </header>

        <div class="admin-content">

            {{-- ── PANEL : Dashboard ── --}}
            <div class="admin-panel active" id="panel-dashboard">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Vue d'ensemble</div>
                        <div class="panel-subtitle">Résumé des dernières activités</div>
                    </div>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead><tr><th>Utilisateur</th><th>Email</th><th>Rôle</th></tr></thead>
                        <tbody>
                            @foreach($users->take(5) as $user)
                            <tr class="user-row"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role ?? ($user->is_admin ? 'admin' : 'user') }}"
                                data-created="{{ $user->created_at?->translatedFormat('d M Y') ?? '—' }}"
                                data-resv-count="{{ $user->reservations?->count() ?? 0 }}"
                                data-delete-url="{{ route('admin.users.destroy', $user->id) }}">
                                <td>
                                    <div class="tbl-user">
                                        <div class="tbl-avatar">{{ strtoupper(substr($user->name,0,1)) }}{{ strtoupper(substr(explode(' ',$user->name)[1]??'',0,1)) }}</div>
                                        <div><div class="tbl-name">{{ $user->name }}</div></div>
                                    </div>
                                </td>
                                <td style="color:var(--ink-40);font-size:12px;">{{ $user->email }}</td>
                                <td>
                                    @if(($user->role??'')=='admin'||($user->is_admin??false))
                                        <span class="status-badge status-badge--admin">Admin</span>
                                    @else
                                        <span class="status-badge status-badge--user">Utilisateur</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead><tr><th>Utilisateur</th><th>Salle</th><th>Date</th><th>Statut</th></tr></thead>
                        <tbody>
                            @foreach($reservations->take(5) as $res)
                            @php
                                $start   = \Carbon\Carbon::parse($res->start_time);
                                $end     = \Carbon\Carbon::parse($res->end_time);
                                $isPast  = $start->isPast();
                                $isToday = $start->isToday();
                            @endphp
                            <tr class="resv-row"
                                data-id="{{ $res->id }}"
                                data-user="{{ $res->user->name ?? '—' }}"
                                data-room="{{ $res->room->name ?? '—' }}"
                                data-location="{{ $res->room->location ?? '—' }}"
                                data-start="{{ $start->format('d/m/Y H:i') }}"
                                data-end="{{ $end->format('H:i') }}"
                                data-status="{{ $isPast ? 'past' : ($isToday ? 'today' : 'upcoming') }}">
                                <td>
                                    <div class="tbl-user">
                                        <div class="tbl-avatar" style="background:var(--stone-2);color:var(--ink-40);font-size:9px;">{{ strtoupper(substr($res->user->name??'?',0,1)) }}</div>
                                        <div class="tbl-name">{{ $res->user->name ?? '—' }}</div>
                                    </div>
                                </td>
                                <td><span class="tbl-room-chip">🏢 {{ $res->room->name ?? '—' }}</span></td>
                                <td><div><div class="tbl-date__main">{{ $start->translatedFormat('d M Y') }}</div><div class="tbl-date__time">{{ $start->format('H:i') }}</div></div></td>
                                <td>
                                    @if($isPast) <span class="status-badge status-badge--past">Terminée</span>
                                    @elseif($isToday) <span class="status-badge status-badge--upcoming">Aujourd'hui</span>
                                    @else <span class="status-badge status-badge--upcoming">À venir</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── PANEL : Salles ── --}}
            <div class="admin-panel" id="panel-rooms">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Salles</div>
                        <div class="panel-subtitle">{{ $totalRooms }} salles enregistrées</div>
                    </div>
                    <button class="btn-add-room" id="btnOpenAddRoom">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        <span>Ajouter une salle</span>
                    </button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead><tr><th>Salle</th><th>Type</th><th>Localisation</th><th>Capacité</th><th>Prix</th><th>Statut</th><th></th></tr></thead>
                        <tbody>
                            @foreach($rooms as $room)
                            @php
                                $hasActiveResv = $room->reservations->filter(fn($r) => \Carbon\Carbon::parse($r->start_time)->isPast() === false)->count();
                                $nextResv = $room->reservations->filter(fn($r) => \Carbon\Carbon::parse($r->start_time)->isFuture())->sortBy('start_time')->first();
                                $isOccupied = $room->reservations->filter(function($r) {
                                    $s = \Carbon\Carbon::parse($r->start_time);
                                    $e = \Carbon\Carbon::parse($r->end_time);
                                    return now()->between($s, $e);
                                })->count() > 0;

                                $typeLabels = [
                                    'standard'   => ['⭐', 'Standard'],
                                    'premium'    => ['✨', 'Premium'],
                                    'vip'        => ['👑', 'VIP'],
                                    'conference' => ['🎤', 'Conférence'],
                                    'coworking'  => ['💼', 'Coworking'],
                                    'mariage'    => ['💒', 'Mariage'],
                                ];
                                $roomType  = $room->type ?? 'standard';
                                $typeInfo  = $typeLabels[$roomType] ?? ['⭐', ucfirst($roomType)];
                            @endphp
                            <tr class="room-row"
                                data-id="{{ $room->id }}"
                                data-name="{{ $room->name }}"
                                data-type="{{ $roomType }}"
                                data-location="{{ $room->location ?? '' }}"
                                data-capacity="{{ $room->capacity ?? '' }}"
                                data-prix="{{ $room->prix ?? '' }}"
                                data-description="{{ $room->description ?? '' }}"
                                data-resv-count="{{ $room->reservations->count() }}"
                                data-upcoming="{{ $hasActiveResv }}"
                                data-status="{{ $isOccupied ? 'taken' : 'free' }}"
                                data-next="{{ $nextResv ? \Carbon\Carbon::parse($nextResv->start_time)->format('d/m/Y H:i') : '' }}"
                                data-next-user="{{ $nextResv ? ($nextResv->user->name ?? '—') : '' }}"
                                data-edit-url="{{ route('admin.rooms.update', $room->id) }}">
                                <td>
                                    <div class="tbl-user">
                                        <div class="tbl-avatar" style="border-radius:8px;background:var(--stone-2);color:var(--ink-40);font-size:16px;">🏢</div>
                                        <div class="tbl-name">{{ $room->name }}</div>
                                    </div>
                                </td>
                                <td><span class="type-badge type-badge--{{ $roomType }}">{{ $typeInfo[0] }} {{ $typeInfo[1] }}</span></td>
                                <td style="color:var(--ink-40);font-size:12px;">📍 {{ $room->location ?? '—' }}</td>
                                <td style="font-size:13px;color:var(--ink);">@if($room->capacity) 👥 {{ $room->capacity }} places @else — @endif</td>
                                <td style="font-size:13px;color:var(--ink);">@if($room->prix) {{ number_format($room->prix, 0, ',', ' ') }} FCFA @else — @endif</td>
                                <td>
                                    @if($isOccupied)
                                        <span class="status-badge status-badge--taken">Occupée</span>
                                    @else
                                        <span class="status-badge status-badge--free">Libre</span>
                                    @endif
                                </td>
                                <td><svg class="tbl-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── PANEL : Réservations ── --}}
            <div class="admin-panel" id="panel-reservations">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Réservations</div>
                        <div class="panel-subtitle">{{ $totalReservations }} réservations au total</div>
                    </div>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead><tr><th>Utilisateur</th><th>Salle</th><th>Date & heure</th><th>Durée</th><th>Statut</th><th></th></tr></thead>
                        <tbody>
                            @foreach($allReservations as $res)
                            @php
                                $start    = \Carbon\Carbon::parse($res->start_time);
                                $end      = \Carbon\Carbon::parse($res->end_time);
                                $isPast   = $start->isPast();
                                $isToday  = $start->isToday();
                                $duration = $start->diffInMinutes($end);
                                $durLabel = ($duration >= 60 ? intdiv($duration,60).'h'.($duration%60?$duration%60:'') : $duration.'min');
                            @endphp
                            <tr class="resv-row"
                                data-id="{{ $res->id }}"
                                data-user="{{ $res->user->name ?? '—' }}"
                                data-user-email="{{ $res->user->email ?? '—' }}"
                                data-room="{{ $res->room->name ?? '—' }}"
                                data-location="{{ $res->room->location ?? '—' }}"
                                data-start="{{ $start->format('d/m/Y H:i') }}"
                                data-end="{{ $end->format('H:i') }}"
                                data-duration="{{ $durLabel }}"
                                data-status="{{ $isPast ? 'past' : ($isToday ? 'today' : 'upcoming') }}">
                                <td>
                                    <div class="tbl-user">
                                        <div class="tbl-avatar" style="background:var(--stone-2);color:var(--ink-40);">{{ strtoupper(substr($res->user->name??'?',0,1)) }}</div>
                                        <div>
                                            <div class="tbl-name">{{ $res->user->name ?? '—' }}</div>
                                            <div class="tbl-email">{{ $res->user->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="tbl-room-chip">🏢 {{ $res->room->name ?? '—' }}</span></td>
                                <td><div><div class="tbl-date__main">{{ $start->translatedFormat('d M Y') }}</div><div class="tbl-date__time">{{ $start->format('H:i') }} → {{ $end->format('H:i') }}</div></div></td>
                                <td style="font-size:12px;color:var(--ink-40);">{{ $durLabel }}</td>
                                <td>
                                    @if($isPast) <span class="status-badge status-badge--past">Terminée</span>
                                    @elseif($isToday) <span class="status-badge status-badge--upcoming">Aujourd'hui</span>
                                    @else <span class="status-badge status-badge--upcoming">À venir</span>
                                    @endif
                                </td>
                                <td><svg class="tbl-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── PANEL : Utilisateurs ── --}}
            <div class="admin-panel" id="panel-users">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Utilisateurs</div>
                        <div class="panel-subtitle">{{ $totalUsers }} comptes enregistrés</div>
                    </div>
                    <button class="btn-add-user" id="btnOpenAddUser">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/>
                            <line x1="19" y1="11" x2="19" y2="17"/><line x1="16" y1="14" x2="22" y2="14"/>
                        </svg>
                        <span>Ajouter un utilisateur</span>
                    </button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead><tr><th>Utilisateur</th><th>Email</th><th>Rôle</th><th>Inscrit le</th><th>Réservations</th><th></th></tr></thead>
                        <tbody>
                            @foreach($allUsers as $user)
                            <tr class="user-row"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ ($user->role??'')==='admin'||($user->is_admin??false) ? 'admin' : 'user' }}"
                                data-created="{{ $user->created_at?->translatedFormat('d M Y') ?? '—' }}"
                                data-resv-count="{{ $user->reservations?->count() ?? 0 }}"
                                data-delete-url="{{ route('admin.users.destroy', $user->id) }}">
                                <td>
                                    <div class="tbl-user">
                                        <div class="tbl-avatar">{{ strtoupper(substr($user->name,0,1)) }}{{ strtoupper(substr(explode(' ',$user->name)[1]??'',0,1)) }}</div>
                                        <div><div class="tbl-name">{{ $user->name }}</div></div>
                                    </div>
                                </td>
                                <td style="color:var(--ink-40);font-size:12px;">{{ $user->email }}</td>
                                <td>
                                    @if(($user->role??'')==='admin'||($user->is_admin??false))
                                        <span class="status-badge status-badge--admin">Admin</span>
                                    @else
                                        <span class="status-badge status-badge--user">Utilisateur</span>
                                    @endif
                                </td>
                                <td style="font-size:12px;color:var(--ink-40);">{{ $user->created_at?->translatedFormat('d M Y') ?? '—' }}</td>
                                <td style="font-size:13px;font-weight:600;color:var(--ink);">{{ $user->reservations?->count() ?? 0 }}</td>
                                <td><svg class="tbl-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- /admin-content --}}
    </div>{{-- /admin-main --}}
</div>{{-- /admin-layout --}}


{{-- ══ OVERLAY PARTAGÉ ══ --}}
<div class="detail-overlay" id="detailOverlay"></div>


{{-- ══ DETAIL DRAWER ══ --}}
<div class="detail-drawer" id="detailDrawer">
    <div class="drawer-header" id="drawerHeader">
        <button class="drawer-close" id="drawerClose">&times;</button>
        <div class="drawer-eyebrow" id="drawerEyebrow">Détail</div>
        <div class="drawer-title" id="drawerTitle">—</div>
        <div class="drawer-meta" id="drawerMeta"></div>
    </div>
    <div class="drawer-body" id="drawerBody"></div>
    <div class="drawer-actions" id="drawerActions"></div>
    <div class="delete-confirm" id="deleteConfirm">
        <p class="delete-confirm__text" id="deleteConfirmText">Confirmer la suppression ?</p>
        <div class="delete-confirm__btns">
            <button class="btn-confirm-yes" id="deleteConfirmYes">Oui, supprimer</button>
            <button class="btn-confirm-no" id="deleteConfirmNo">Annuler</button>
        </div>
    </div>
</div>


{{-- ══ ADD / EDIT ROOM DRAWER ══ --}}
<div class="detail-drawer" id="addRoomDrawer">
    <div class="drawer-header">
        <button class="drawer-close" id="addRoomClose">&times;</button>
        <div class="drawer-eyebrow" id="addRoomEyebrow">Gestion des salles</div>
        <div class="drawer-title" id="addRoomTitle">Nouvelle salle</div>
    </div>
    <form id="addRoomForm" method="POST" action="{{ route('rooms.store') }}"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;flex:1;overflow:hidden;">
        @csrf
        <input type="hidden" name="_method" id="addRoomMethod" value="POST">

        <div class="drawer-body" style="display:flex;flex-direction:column;gap:16px;">

            @if($errors->any())
            <div class="form-errors">
                <ul>@foreach($errors->all() as $e)<li>⚠ {{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="form-group">
                <label>Nom de la salle *</label>
                <input type="text" name="name" id="roomFieldName"
                       value="{{ old('name') }}" placeholder="ex: Salle Einstein" required>
            </div>

            <div class="form-group">
                <label>Type de salle *</label>
                <select name="type" id="roomFieldType" required>
                    <option value="standard"   id="typeOpt_standard">⭐ Standard</option>
                    <option value="premium"    id="typeOpt_premium">✨ Premium</option>
                    <option value="vip"        id="typeOpt_vip">👑 VIP</option>
                    <option value="conference" id="typeOpt_conference">🎤 Conférence</option>
                    <option value="coworking"  id="typeOpt_coworking">💼 Coworking</option>
                    <option value="mariage"    id="typeOpt_mariage">💒 Mariage</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Capacité *</label>
                    <input type="number" name="capacity" id="roomFieldCapacity"
                           value="{{ old('capacity') }}" placeholder="ex: 12" min="1" required>
                </div>
                <div class="form-group">
                    <label>Prix/h (FCFA) *</label>
                    <input type="number" name="prix" id="roomFieldPrix"
                           value="{{ old('prix') }}" placeholder="ex: 15000" step="0.01" min="0" required>
                </div>
            </div>

            <div class="form-group">
                <label>Localisation</label>
                <input type="text" name="location" id="roomFieldLocation"
                       value="{{ old('location') }}" placeholder="ex: Bâtiment A, 2ème étage">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="roomFieldDescription"
                          placeholder="Équipements, caractéristiques particulières...">{{ old('description') }}</textarea>
            </div>

            <div class="drawer-divider"></div>

            <div class="form-group">
                <label>Image de la salle</label>
                <div class="upload-zone">
                    <input type="file" name="image" accept="image/*" id="addRoomImageInput">
                    <div class="upload-zone__icon">🖼️</div>
                    <div class="upload-zone__text"><strong>Cliquez</strong> ou glissez une image ici<br>JPG, PNG, WEBP — 5 Mo max</div>
                    <img class="upload-preview" id="addRoomPreview" alt="Aperçu">
                </div>
            </div>

        </div>

        <div class="drawer-actions">
            <button type="button" class="btn-drawer btn-drawer--secondary" id="addRoomCancel">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Annuler
            </button>
            <button type="submit" class="btn-drawer btn-drawer--primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span id="addRoomSubmitLabel">Créer la salle</span>
            </button>
        </div>
    </form>
</div>


{{-- ══ ADD USER DRAWER ══ --}}
<div class="detail-drawer" id="addUserDrawer">
    <div class="drawer-header">
        <button class="drawer-close" id="addUserClose">&times;</button>
        <div class="drawer-eyebrow">Gestion des utilisateurs</div>
        <div class="drawer-title">Nouvel utilisateur</div>
    </div>
    <form method="POST" action="{{ route('admin.users.store') }}"
          style="display:flex;flex-direction:column;flex:1;overflow:hidden;">
        @csrf

        <div class="drawer-body" style="display:flex;flex-direction:column;gap:16px;">

            @if($errors->hasAny(['user_name','user_email','user_password','user_role']))
            <div class="form-errors">
                <ul>
                    @foreach($errors->get('user_name') as $e)<li>⚠ {{ $e }}</li>@endforeach
                    @foreach($errors->get('user_email') as $e)<li>⚠ {{ $e }}</li>@endforeach
                    @foreach($errors->get('user_password') as $e)<li>⚠ {{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif

            <div class="form-group">
                <label>Nom complet *</label>
                <input type="text" name="user_name" value="{{ old('user_name') }}" placeholder="ex: Jean Dupont" required>
            </div>
            <div class="form-group">
                <label>Adresse email *</label>
                <input type="email" name="user_email" value="{{ old('user_email') }}" placeholder="ex: jean@exemple.com" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Mot de passe *</label>
                    <input type="password" name="user_password" placeholder="Min. 8 caractères" required>
                </div>
                <div class="form-group">
                    <label>Confirmer *</label>
                    <input type="password" name="user_password_confirmation" placeholder="Répéter" required>
                </div>
            </div>
            <div class="form-group">
                <label>Rôle *</label>
                <select name="user_role" required>
                    <option value="user"  {{ old('user_role','user')==='user'  ? 'selected' : '' }}>👤 Utilisateur</option>
                    <option value="admin" {{ old('user_role')==='admin' ? 'selected' : '' }}>⚡ Administrateur</option>
                </select>
            </div>

        </div>

        <div class="drawer-actions">
            <button type="button" class="btn-drawer btn-drawer--secondary" id="addUserCancel">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Annuler
            </button>
            <button type="submit" class="btn-drawer btn-drawer--primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                Créer l'utilisateur
            </button>
        </div>
    </form>
</div>


{{-- Formulaire suppression utilisateur --}}
<form id="deleteUserForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>


<script>
(function () {
    'use strict';

    /* ════════════════════════════
       HAMBURGER
    ════════════════════════════ */
    const hamburger  = document.getElementById('sidebarHamburger');
    const sidebar    = document.getElementById('adminSidebar');
    const sidebarOvl = document.getElementById('sidebarOverlay');

    function openSidebar()  { sidebar.classList.add('is-open'); sidebarOvl.classList.add('open'); hamburger.classList.add('is-open'); hamburger.setAttribute('aria-expanded','true'); document.body.style.overflow='hidden'; }
    function closeSidebar() { sidebar.classList.remove('is-open'); sidebarOvl.classList.remove('open'); hamburger.classList.remove('is-open'); hamburger.setAttribute('aria-expanded','false'); document.body.style.overflow=''; }

    hamburger.addEventListener('click', () => sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar());
    sidebarOvl.addEventListener('click', closeSidebar);
    sidebar.querySelectorAll('[data-panel]').forEach(btn => btn.addEventListener('click', () => { if (window.innerWidth <= 900) closeSidebar(); }));

    /* ════════════════════════════
       DATE
    ════════════════════════════ */
    const dateEl = document.getElementById('adminDate');
    if (dateEl) dateEl.textContent = new Date().toLocaleDateString('fr-FR', { weekday:'long', day:'numeric', month:'long', year:'numeric' });

    /* ════════════════════════════
       NAVIGATION PANELS
    ════════════════════════════ */
    const panelLabels = { dashboard:'Tableau de bord', rooms:'Salles', reservations:'Réservations', users:'Utilisateurs' };
    document.querySelectorAll('[data-panel]').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('[data-panel]').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.admin-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('panel-' + this.dataset.panel)?.classList.add('active');
            const label = panelLabels[this.dataset.panel] || '';
            const bc = document.getElementById('breadcrumb'); if (bc) bc.textContent = label;
            const mbc = document.getElementById('mobileBreadcrumb'); if (mbc) mbc.textContent = label;
        });
    });

    /* ════════════════════════════
       DRAWERS
    ════════════════════════════ */
    const overlay       = document.getElementById('detailOverlay');
    const detailDrawer  = document.getElementById('detailDrawer');
    const addRoomDrawer = document.getElementById('addRoomDrawer');
    const addUserDrawer = document.getElementById('addUserDrawer');
    const allDrawers    = [detailDrawer, addRoomDrawer, addUserDrawer];

    function closeAll()     { overlay.classList.remove('open'); allDrawers.forEach(d => d.classList.remove('open')); }
    function openDrawer(d)  { allDrawers.forEach(x => x.classList.remove('open')); overlay.classList.add('open'); d.classList.add('open'); }

    overlay.addEventListener('click', closeAll);
    document.getElementById('drawerClose').addEventListener('click', closeAll);
    document.getElementById('addRoomClose').addEventListener('click', closeAll);
    document.getElementById('addRoomCancel').addEventListener('click', closeAll);
    document.getElementById('addUserClose').addEventListener('click', closeAll);
    document.getElementById('addUserCancel').addEventListener('click', closeAll);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeSidebar(); closeAll(); } });
    window.__closeDrawer = closeAll;

    /* ════════════════════════════
       ADD ROOM — Création
    ════════════════════════════ */
    function openAddRoomCreate() {
        const form = document.getElementById('addRoomForm');
        form.action = "{{ route('rooms.store') }}";
        document.getElementById('addRoomMethod').value        = 'POST';
        document.getElementById('addRoomEyebrow').textContent = 'Gestion des salles';
        document.getElementById('addRoomTitle').textContent   = 'Nouvelle salle';
        document.getElementById('addRoomSubmitLabel').textContent = 'Créer la salle';
        document.getElementById('roomFieldName').value        = '';
        document.getElementById('roomFieldType').value        = 'standard';
        document.getElementById('roomFieldCapacity').value    = '';
        document.getElementById('roomFieldPrix').value        = '';
        document.getElementById('roomFieldLocation').value    = '';
        document.getElementById('roomFieldDescription').value = '';
        const prev = document.getElementById('addRoomPreview'); prev.style.display='none'; prev.src='';
        openDrawer(addRoomDrawer);
    }

    /* ════════════════════════════
       ADD ROOM — Édition
    ════════════════════════════ */
    function openEditRoom(d) {
        const form = document.getElementById('addRoomForm');
        form.action = d.editUrl;
        document.getElementById('addRoomMethod').value        = 'PUT';
        document.getElementById('addRoomEyebrow').textContent = 'Modifier la salle';
        document.getElementById('addRoomTitle').textContent   = d.name;
        document.getElementById('addRoomSubmitLabel').textContent = 'Enregistrer les modifications';
        document.getElementById('roomFieldName').value        = d.name        || '';
        document.getElementById('roomFieldType').value        = d.type        || 'standard';
        document.getElementById('roomFieldCapacity').value    = d.capacity    || '';
        document.getElementById('roomFieldPrix').value        = d.prix        || '';
        document.getElementById('roomFieldLocation').value    = d.location    || '';
        document.getElementById('roomFieldDescription').value = d.description || '';
        const prev = document.getElementById('addRoomPreview'); prev.style.display='none'; prev.src='';
        openDrawer(addRoomDrawer);
    }

    document.getElementById('btnOpenAddRoom').addEventListener('click', openAddRoomCreate);
    document.getElementById('addRoomImageInput').addEventListener('change', function () {
        const file = this.files[0]; if (!file) return;
        const p = document.getElementById('addRoomPreview'); p.src = URL.createObjectURL(file); p.style.display='block';
    });

    /* ════════════════════════════
       ADD USER
    ════════════════════════════ */
    document.getElementById('btnOpenAddUser').addEventListener('click', () => openDrawer(addUserDrawer));

    @if($errors->hasAny(['user_name','user_email','user_password','user_role']))
    document.addEventListener('DOMContentLoaded', () => { document.querySelector('[data-panel="users"]')?.click(); openDrawer(addUserDrawer); });
    @endif

    @if($errors->hasAny(['name','capacity','prix','location','description','type']))
    document.addEventListener('DOMContentLoaded', () => { document.querySelector('[data-panel="rooms"]')?.click(); openAddRoomCreate(); });
    @endif

    /* ════════════════════════════
       HELPERS
    ════════════════════════════ */
    function field(label, value, muted=false) {
        return `<div class="drawer-field"><span class="drawer-field__label">${label}</span><div class="drawer-field__val ${muted?'muted':''}">${value||'—'}</div></div>`;
    }
    function chip(text) { return `<span class="drawer-chip">${text}</span>`; }
    function statusBadge(type, label) { return `<span class="status-badge status-badge--${type}">${label}</span>`; }

    const typeLabelsJS = {
        standard:   '⭐ Standard',
        premium:    '✨ Premium',
        vip:        '👑 VIP',
        conference: '🎤 Conférence',
        coworking:  '💼 Coworking',
        mariage:    '💒 Mariage',
    };

    /* ════════════════════════════
       USER ROWS
    ════════════════════════════ */
    document.querySelectorAll('.user-row').forEach(row => {
        row.addEventListener('click', function () {
            const d = this.dataset;
            const isAdmin  = d.role === 'admin';
            const initials = d.name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2);

            document.getElementById('drawerEyebrow').textContent = 'Fiche utilisateur';
            document.getElementById('drawerTitle').innerHTML = `<div class="drawer-avatar-lg">${initials}</div>${d.name}`;
            document.getElementById('drawerMeta').innerHTML =
                chip(isAdmin ? '⚡ Administrateur' : '👤 Utilisateur') +
                chip(`📅 ${d.resvCount} réservation${d.resvCount>1?'s':''}`);

            document.getElementById('drawerBody').innerHTML =
                field('Email', `<a href="mailto:${d.email}" style="color:var(--gold-dk);text-decoration:none;">${d.email}</a>`) +
                field('Rôle', isAdmin ? statusBadge('admin','Admin') : statusBadge('user','Utilisateur')) +
                field('Inscrit le', d.created) +
                field('Réservations', d.resvCount) +
                '<div class="drawer-divider"></div>' +
                field('ID', `#${d.id}`, true);

            const actions = document.getElementById('drawerActions');
            const deleteUrl = d.deleteUrl;
            actions.innerHTML = `
                <button class="btn-drawer btn-drawer--secondary" onclick="window.__closeDrawer()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Fermer
                </button>
                <button class="btn-drawer btn-drawer--delete" id="btnDeleteUser">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Supprimer
                </button>`;

            const confirmBox = document.getElementById('deleteConfirm');
            document.getElementById('deleteConfirmText').textContent = `Supprimer "${d.name}" définitivement ?`;
            confirmBox.classList.remove('visible');
            document.getElementById('btnDeleteUser').addEventListener('click', () => confirmBox.classList.add('visible'));
            document.getElementById('deleteConfirmYes').onclick = () => { const f = document.getElementById('deleteUserForm'); f.action = deleteUrl; f.submit(); };
            document.getElementById('deleteConfirmNo').onclick  = () => confirmBox.classList.remove('visible');

            openDrawer(detailDrawer);
            document.getElementById('deleteConfirm').classList.remove('visible');
        });
    });

    /* ════════════════════════════
       ROOM ROWS
    ════════════════════════════ */
    document.querySelectorAll('.room-row').forEach(row => {
        row.addEventListener('click', function () {
            const d = this.dataset;
            const isFree  = d.status === 'free';
            const typeLabel = typeLabelsJS[d.type] || d.type || 'Standard';

            document.getElementById('drawerEyebrow').textContent = 'Fiche salle';
            document.getElementById('drawerTitle').textContent   = d.name;
            document.getElementById('drawerMeta').innerHTML =
                chip(`📍 ${d.location||'—'}`) +
                chip(typeLabel) +
                chip(isFree ? '🟢 Libre' : '🔴 Occupée') +
                (d.capacity ? chip(`👥 ${d.capacity} places`) : '') +
                (d.prix ? chip(`💰 ${parseInt(d.prix).toLocaleString('fr-FR')} FCFA/h`) : '');

            document.getElementById('drawerBody').innerHTML =
                field('Statut', isFree ? statusBadge('free','Libre') : statusBadge('taken','Occupée')) +
                field('Type', typeLabel) +
                field('Localisation', d.location) +
                field('Capacité', d.capacity ? d.capacity+' personnes' : '—') +
                field('Prix horaire', d.prix ? parseInt(d.prix).toLocaleString('fr-FR')+' FCFA' : '—') +
                field('Total réservations', d.resvCount) +
                field('Réservations à venir', d.upcoming) +
                (d.next ? field('Prochaine réservation', `${d.next} — par ${d.nextUser}`) : '') +
                (d.description ? '<div class="drawer-divider"></div>'+field('Description', d.description, true) : '');

            document.getElementById('drawerActions').innerHTML = `
                <button class="btn-drawer btn-drawer--secondary" onclick="window.__closeDrawer()">Fermer</button>
                <button class="btn-drawer btn-drawer--edit" id="btnEditRoom">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Modifier
                </button>`;

            document.getElementById('deleteConfirm').classList.remove('visible');
            document.getElementById('btnEditRoom').addEventListener('click', () => openEditRoom(d));
            openDrawer(detailDrawer);
        });
    });

    /* ════════════════════════════
       RESERVATION ROWS
    ════════════════════════════ */
    document.querySelectorAll('.resv-row').forEach(row => {
        row.addEventListener('click', function () {
            const d = this.dataset;
            const statusMap = { past:['past','Terminée'], today:['upcoming',"Aujourd'hui"], upcoming:['upcoming','À venir'] };
            const [sc, sl] = statusMap[d.status] || ['past','—'];

            document.getElementById('drawerEyebrow').textContent = 'Détail réservation';
            document.getElementById('drawerTitle').textContent   = d.room;
            document.getElementById('drawerMeta').innerHTML =
                chip(`👤 ${d.user}`) + chip(`${d.status==='past'?'✅':'📅'} ${sl}`);

            document.getElementById('drawerBody').innerHTML =
                field('Statut', statusBadge(sc,sl)) +
                field('Salle', d.room) +
                field('Localisation', d.location) +
                '<div class="drawer-divider"></div>' +
                field('Réservé par', d.user) +
                (d.userEmail ? field('Email', `<a href="mailto:${d.userEmail}" style="color:var(--gold-dk);text-decoration:none;">${d.userEmail}</a>`) : '') +
                '<div class="drawer-divider"></div>' +
                field('Date', d.start.split(' ')[0]) +
                field('Horaires', `${d.start.split(' ')[1]} → ${d.end}`) +
                (d.duration ? field('Durée', d.duration) : '') +
                field('ID réservation', `#${d.id}`, true);

            document.getElementById('drawerActions').innerHTML =
                `<button class="btn-drawer btn-drawer--secondary" onclick="window.__closeDrawer()">Fermer</button>`;
            document.getElementById('deleteConfirm').classList.remove('visible');
            openDrawer(detailDrawer);
        });
    });

})();
</script>

</body>
</html>
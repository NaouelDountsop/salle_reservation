<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — EspaceIdées</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>

/* ══════════════════════════════════════════════
   ADMIN DASHBOARD — Dynamic Gold Edition
   ══════════════════════════════════════════════ */

body { margin: 0; padding: 0; }

.admin-layout { display: flex; min-height: 100vh; }

/* ══════════════════════════════════
   SIDEBAR
   ══════════════════════════════════ */
.admin-sidebar {
    width: 240px; flex-shrink: 0;
    background: var(--ink);
    display: flex; flex-direction: column;
    position: fixed; top: 0; left: 0;
    height: 100vh; z-index: 400;
    overflow: hidden;
}

.admin-sidebar::before {
    content: '';
    position: absolute; bottom: -60px; left: -60px;
    width: 220px; height: 220px; border-radius: 50%;
    background: radial-gradient(circle, rgba(201,146,42,0.14) 0%, transparent 70%);
    pointer-events: none;
}

.admin-sidebar::after {
    content: '';
    position: absolute; top: 0; left: 0;
    width: 3px; height: 100%;
    background: linear-gradient(to bottom, var(--gold-lt), var(--gold), transparent);
}

/* Logo */
.sidebar-logo {
    display: flex; align-items: center; gap: 10px;
    padding: 24px 20px 20px; text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,0.07); flex-shrink: 0;
}

.sidebar-logo__mark {
    width: 32px; height: 32px; background: var(--gold);
    border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}

.sidebar-logo__mark svg { width: 14px; height: 14px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; }

.sidebar-logo__name { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: #fff; letter-spacing: -0.02em; }

.sidebar-logo__badge {
    margin-left: auto; font-size: 8px; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; background: rgba(201,146,42,0.2); color: var(--gold-lt);
    border: 1px solid rgba(201,146,42,0.3); padding: 2px 6px;
    border-radius: var(--radius-pill); font-family: 'Instrument Sans', sans-serif;
}

/* Nav */
.sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }

.sidebar-nav__label {
    font-size: 9px; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase;
    color: rgba(255,255,255,0.25); padding: 0 8px; margin-bottom: 6px; margin-top: 16px; display: block;
}
.sidebar-nav__label:first-child { margin-top: 0; }

.sidebar-nav__link {
    display: flex; align-items: center; gap: 10px; padding: 9px 10px;
    border-radius: var(--radius-md); font-family: 'Instrument Sans', sans-serif;
    font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.5);
    text-decoration: none; transition: all var(--t); cursor: pointer;
    border: none; background: none; width: 100%; text-align: left; position: relative;
}

.sidebar-nav__link svg {
    width: 15px; height: 15px; flex-shrink: 0; stroke: currentColor; fill: none;
    stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; opacity: 0.6; transition: opacity var(--t);
}

.sidebar-nav__link:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.85); }
.sidebar-nav__link:hover svg { opacity: 1; }

.sidebar-nav__link.active {
    background: rgba(201,146,42,0.15); color: var(--gold-lt); font-weight: 600;
}
.sidebar-nav__link.active svg { opacity: 1; stroke: var(--gold-lt); }
.sidebar-nav__link.active::before {
    content: ''; position: absolute; left: -4px; top: 50%; transform: translateY(-50%);
    width: 3px; height: 18px; background: var(--gold); border-radius: 2px;
}

.sidebar-nav__count {
    margin-left: auto; font-size: 10px; font-weight: 700;
    background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.4);
    padding: 1px 7px; border-radius: var(--radius-pill); font-family: 'Instrument Sans', sans-serif;
}

.sidebar-nav__link.active .sidebar-nav__count {
    background: rgba(201,146,42,0.2); color: var(--gold-lt);
}

/* Footer */
.sidebar-footer { border-top: 1px solid rgba(255,255,255,0.07); padding: 14px 16px; flex-shrink: 0; }

.sidebar-user { display: flex; align-items: center; gap: 10px; }

.sidebar-user__avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold-lt), var(--gold));
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-size: 10px; font-weight: 800; color: #fff; flex-shrink: 0;
}

.sidebar-user__info { flex: 1; min-width: 0; }
.sidebar-user__name { font-size: 12px; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: 'Instrument Sans', sans-serif; }
.sidebar-user__role { font-size: 10px; color: var(--gold); font-family: 'Instrument Sans', sans-serif; margin-top: 1px; }

.sidebar-logout {
    display: flex; align-items: center; justify-content: center;
    width: 28px; height: 28px; border-radius: var(--radius-sm);
    background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);
    cursor: pointer; color: rgba(239,68,68,0.7); transition: all var(--t); flex-shrink: 0;
}
.sidebar-logout svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }
.sidebar-logout:hover { background: rgba(239,68,68,0.2); color: #ef4444; }

/* ══════════════════════════════════
   MAIN AREA
   ══════════════════════════════════ */
.admin-main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

/* Topbar */
.admin-topbar {
    background: var(--surface); border-bottom: 1px solid var(--stone);
    padding: 0 36px; height: 52px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 200;
}

.admin-topbar__left { display: flex; align-items: center; gap: 4px; }
.admin-topbar__crumb { font-size: 12px; color: var(--ink-40); font-family: 'Instrument Sans', sans-serif; }
.admin-topbar__sep { font-size: 12px; color: var(--stone); margin: 0 4px; }
.admin-topbar__crumb.active { color: var(--ink); font-weight: 600; }
.admin-topbar__date { font-size: 11px; color: var(--ink-40); font-family: 'Instrument Sans', sans-serif; }

/* Hero */
.admin-hero {
    background: var(--ink); padding: 28px 36px;
    display: grid; grid-template-columns: 1fr auto;
    align-items: center; gap: 24px; position: relative; overflow: hidden;
}
.admin-hero::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 55% 150% at 85% 50%, rgba(201,146,42,0.18) 0%, transparent 70%);
    pointer-events: none;
}
.admin-hero__inner { position: relative; z-index: 1; animation: fadeUp 0.7s var(--ease-out) both; }
.admin-hero__eyebrow {
    font-size: 9px; font-weight: 600; letter-spacing: 0.22em; text-transform: uppercase;
    color: var(--gold-lt); margin-bottom: 8px; display: flex; align-items: center; gap: 8px;
}
.admin-hero__eyebrow::before { content: ''; display: inline-block; width: 16px; height: 1.5px; background: var(--gold); border-radius: 2px; }
.admin-hero__title { font-family: 'Syne', sans-serif; font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color: #fff; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 6px; }
.admin-hero__title em { font-style: italic; font-weight: 400; color: var(--gold-lt); }
.admin-hero__sub { font-size: 13px; color: rgba(255,255,255,0.45); }
.admin-hero__stats { display: flex; align-items: stretch; border-left: 1px solid rgba(255,255,255,0.08); position: relative; z-index: 1; animation: fadeUp 0.7s 0.08s var(--ease-out) both; }
.hero-stat { padding: 16px 22px; border-right: 1px solid rgba(255,255,255,0.08); text-align: center; }
.hero-stat__val { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800; color: var(--gold-lt); line-height: 1; margin-bottom: 4px; }
.hero-stat__lbl { font-size: 9px; font-weight: 500; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.35); }

@keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

/* ══════════════════════════════════
   PANELS DE CONTENU
   ══════════════════════════════════ */
.admin-content { flex: 1; position: relative; }

/* Chaque section est cachée par défaut, visible si active */
.admin-panel {
    display: none;
    padding: 28px 36px 64px;
    animation: fadeUp 0.35s var(--ease-out) both;
}
.admin-panel.active { display: block; }

/* Section header */
.panel-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; padding-bottom: 16px;
    border-bottom: 1px solid var(--stone);
}
.panel-title { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: var(--ink); letter-spacing: -0.02em; }
.panel-subtitle { font-size: 12px; color: var(--ink-40); margin-top: 2px; }

/* ── Tables ── */
.admin-table-wrap {
    background: var(--surface); border: 1px solid var(--stone);
    border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-card);
    margin-bottom: 28px;
}
.admin-table-wrap::before { content: ''; display: block; height: 3px; background: linear-gradient(to right, var(--gold-lt), var(--gold)); }

.admin-table { width: 100%; border-collapse: collapse; }
.admin-table thead tr { background: var(--ink); }
.admin-table thead th {
    padding: 10px 16px; text-align: left; font-family: 'Instrument Sans', sans-serif;
    font-size: 9px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase;
    color: rgba(255,255,255,0.4); white-space: nowrap;
}
.admin-table thead th:first-child::before { content: ''; display: inline-block; width: 10px; height: 1.5px; background: var(--gold); margin-right: 8px; vertical-align: middle; border-radius: 2px; }
.admin-table tbody tr { border-bottom: 1px solid var(--stone); transition: background var(--t); cursor: pointer; }
.admin-table tbody tr:last-child { border-bottom: none; }
.admin-table tbody tr:hover { background: var(--gold-bg); }
.admin-table tbody td { padding: 12px 16px; font-size: 13px; color: var(--ink); vertical-align: middle; }

/* Cells */
.tbl-user { display: flex; align-items: center; gap: 10px; }
.tbl-avatar {
    width: 30px; height: 30px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold-lt), var(--gold));
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-size: 10px; font-weight: 800; color: #fff; flex-shrink: 0;
}
.tbl-name { font-weight: 600; font-size: 13px; color: var(--ink); }
.tbl-email { font-size: 11px; color: var(--ink-40); margin-top: 1px; }

.tbl-date__main { font-size: 13px; font-weight: 600; color: var(--ink); }
.tbl-date__time { font-size: 11px; color: var(--ink-40); margin-top: 1px; }

/* Badges statuts */
.status-badge {
    display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px;
    border-radius: var(--radius-pill); font-size: 10px; font-weight: 700;
    letter-spacing: 0.06em; text-transform: uppercase; font-family: 'Instrument Sans', sans-serif;
}
.status-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }

.status-badge--free    { background: rgba(34,162,94,0.1);  color: #16a34a; border: 1px solid rgba(34,162,94,0.25); }
.status-badge--free::before    { background: #22c55e; }
.status-badge--taken   { background: rgba(239,68,68,0.08); color: #dc2626; border: 1px solid rgba(239,68,68,0.2); }
.status-badge--taken::before   { background: #ef4444; }
.status-badge--upcoming { background: rgba(201,146,42,0.12); color: var(--gold-dk); border: 1px solid var(--gold-rim); }
.status-badge--upcoming::before { background: var(--gold); }
.status-badge--past    { background: var(--stone-2); color: var(--ink-40); border: 1px solid var(--stone); }
.status-badge--past::before    { background: var(--stone); }
.status-badge--admin   { background: rgba(201,146,42,0.14); color: var(--gold-dk); border: 1px solid rgba(201,146,42,0.3); }
.status-badge--admin::before   { background: var(--gold); }
.status-badge--user    { background: var(--stone-2); color: var(--ink-40); border: 1px solid var(--stone); }
.status-badge--user::before    { background: var(--stone); }

.tbl-room-chip {
    display: inline-flex; align-items: center; gap: 5px;
    background: var(--stone-2); border: 1px solid var(--stone);
    padding: 3px 10px; border-radius: var(--radius-pill);
    font-size: 12px; font-weight: 600; color: var(--ink-70);
}

/* Indicateur "cliquable" */
.tbl-chevron { color: var(--ink-40); transition: color var(--t); }
.admin-table tbody tr:hover .tbl-chevron { color: var(--gold); }

/* ══════════════════════════════════
   DETAIL DRAWER (panneau latéral)
   ══════════════════════════════════ */
.detail-overlay {
    position: fixed; inset: 0; z-index: 900;
    background: rgba(14,13,11,0.45);
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    opacity: 0; pointer-events: none;
    transition: opacity 0.3s;
}
.detail-overlay.open { opacity: 1; pointer-events: auto; }

.detail-drawer {
    position: fixed; top: 0; right: 0; bottom: 0;
    width: 420px; max-width: 95vw;
    background: var(--surface);
    z-index: 901;
    display: flex; flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.38s var(--ease-out);
    box-shadow: -24px 0 80px rgba(0,0,0,0.18);
}
.detail-drawer.open { transform: translateX(0); }

/* Drawer header sombre */
.drawer-header {
    background: var(--ink); padding: 24px 24px 20px;
    position: relative; overflow: hidden; flex-shrink: 0;
}
.drawer-header::before {
    content: ''; position: absolute; right: -20px; top: -20px;
    width: 120px; height: 120px; border-radius: 50%;
    background: radial-gradient(circle, rgba(201,146,42,0.22) 0%, transparent 70%);
    pointer-events: none;
}
.drawer-close {
    position: absolute; top: 16px; right: 16px;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
    cursor: pointer; color: rgba(255,255,255,0.6); font-size: 16px;
    display: flex; align-items: center; justify-content: center;
    transition: all var(--t); z-index: 2;
}
.drawer-close:hover { background: rgba(255,255,255,0.2); color: #fff; }

.drawer-eyebrow {
    font-size: 9px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 8px; display: flex; align-items: center; gap: 6px; position: relative; z-index: 1;
}
.drawer-eyebrow::before { content: ''; display: inline-block; width: 12px; height: 1.5px; background: var(--gold); border-radius: 2px; }

.drawer-title { font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; line-height: 1.15; position: relative; z-index: 1; margin-bottom: 6px; }

.drawer-meta { display: flex; flex-wrap: wrap; gap: 6px; position: relative; z-index: 1; margin-top: 10px; }
.drawer-chip {
    display: inline-flex; align-items: center; gap: 4px;
    background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
    padding: 4px 10px; border-radius: var(--radius-pill);
    font-size: 11px; color: rgba(255,255,255,0.6); font-family: 'Instrument Sans', sans-serif;
}

/* Drawer body */
.drawer-body { flex: 1; overflow-y: auto; padding: 24px; }

.drawer-field { margin-bottom: 18px; }
.drawer-field__label {
    font-size: 9px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase;
    color: var(--ink-40); margin-bottom: 5px; display: block;
}
.drawer-field__val { font-size: 14px; color: var(--ink); font-weight: 500; }
.drawer-field__val.muted { color: var(--ink-40); font-size: 13px; }

.drawer-divider { height: 1px; background: var(--stone); margin: 20px 0; }

/* Drawer actions */
.drawer-actions { padding: 16px 24px; border-top: 1px solid var(--stone); display: flex; gap: 10px; flex-shrink: 0; }

.btn-drawer {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
    height: 38px; border-radius: var(--radius-md);
    font-family: 'Instrument Sans', sans-serif; font-size: 12px; font-weight: 700;
    cursor: pointer; text-decoration: none; transition: all var(--t); border: none; letter-spacing: 0.02em;
}
.btn-drawer svg { width: 13px; height: 13px; flex-shrink: 0; }

.btn-drawer--delete { background: rgba(239,68,68,0.08); color: #dc2626; border: 1px solid rgba(239,68,68,0.2); }
.btn-drawer--delete:hover { background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.4); }

.btn-drawer--secondary { background: var(--stone-2); color: var(--ink-70); border: 1px solid var(--stone); }
.btn-drawer--secondary:hover { background: var(--stone); }

/* Confirm delete inline */
.delete-confirm {
    display: none; padding: 14px 24px; background: rgba(239,68,68,0.06);
    border-top: 1px solid rgba(239,68,68,0.15); flex-shrink: 0;
}
.delete-confirm.visible { display: block; }
.delete-confirm__text { font-size: 13px; color: #dc2626; font-weight: 500; margin-bottom: 12px; font-family: 'Instrument Sans', sans-serif; }
.delete-confirm__btns { display: flex; gap: 8px; }
.btn-confirm-yes {
    flex: 1; padding: 9px; border-radius: var(--radius-md);
    background: #dc2626; color: #fff; border: none;
    font-family: 'Instrument Sans', sans-serif; font-size: 12px; font-weight: 700; cursor: pointer;
    transition: all var(--t);
}
.btn-confirm-yes:hover { background: #b91c1c; }
.btn-confirm-no {
    flex: 1; padding: 9px; border-radius: var(--radius-md);
    background: var(--stone-2); color: var(--ink-70); border: 1px solid var(--stone);
    font-family: 'Instrument Sans', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer;
    transition: all var(--t);
}
.btn-confirm-no:hover { background: var(--stone); }

/* ── Avatar large dans drawer ── */
.drawer-avatar-lg {
    width: 48px; height: 48px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold-lt), var(--gold));
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 800; color: #fff;
    position: relative; z-index: 1; margin-bottom: 12px;
}

/* Reservation list dans drawer room */
.drawer-resv-list { display: flex; flex-direction: column; gap: 8px; }
.drawer-resv-item {
    background: var(--stone-2); border: 1px solid var(--stone);
    border-radius: var(--radius-md); padding: 10px 14px;
    display: flex; align-items: center; justify-content: space-between;
}
.drawer-resv-item__info { display: flex; flex-direction: column; gap: 2px; }
.drawer-resv-item__name { font-size: 12px; font-weight: 600; color: var(--ink); }
.drawer-resv-item__time { font-size: 11px; color: var(--ink-40); }

/* ══════════════════════════════════
   RESPONSIVE
   ══════════════════════════════════ */
@media (max-width: 900px) {
    .admin-sidebar { transform: translateX(-100%); transition: transform 0.3s var(--ease-out); }
    .admin-sidebar.open { transform: translateX(0); }
    .admin-main { margin-left: 0; }
    .admin-hero { grid-template-columns: 1fr; padding: 24px 20px; }
    .admin-hero__stats { border-left: none; border-top: 1px solid rgba(255,255,255,0.08); }
    .admin-panel { padding: 20px 16px 48px; }
    .admin-topbar { padding: 0 20px; }
    .detail-drawer { width: 100%; }
}

</style>
</head>

<body>
<div class="admin-layout">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="admin-sidebar" id="adminSidebar">

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
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                </svg>
                Tableau de bord
            </button>

            <span class="sidebar-nav__label">Gestion</span>

            <button class="sidebar-nav__link" data-panel="rooms">
                <svg viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Salles
                <span class="sidebar-nav__count">{{ $totalRooms }}</span>
            </button>

            <button class="sidebar-nav__link" data-panel="reservations">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Réservations
                <span class="sidebar-nav__count">{{ $totalReservations }}</span>
            </button>

            <button class="sidebar-nav__link" data-panel="users">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M20 21a8 8 0 1 0-16 0"/>
                </svg>
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
                        <svg viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
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
                <div class="hero-stat">
                    <div class="hero-stat__val">{{ $totalUsers }}</div>
                    <div class="hero-stat__lbl">Utilisateurs</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat__val">{{ $totalReservations }}</div>
                    <div class="hero-stat__lbl">Réservations</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat__val">{{ $totalRooms }}</div>
                    <div class="hero-stat__lbl">Salles</div>
                </div>
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
                            <tr class="user-row" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-role="{{ $user->role ?? ($user->is_admin ? 'admin' : 'user') }}" data-created="{{ $user->created_at?->format('d/m/Y') ?? '—' }}">
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
                                $start = \Carbon\Carbon::parse($res->start_time);
                                $end   = \Carbon\Carbon::parse($res->end_time);
                                $isPast = $start->isPast();
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
                                <td>
                                    <div><div class="tbl-date__main">{{ $start->translatedFormat('d M Y') }}</div><div class="tbl-date__time">{{ $start->format('H:i') }}</div></div>
                                </td>
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
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead><tr><th>Salle</th><th>Localisation</th><th>Capacité</th><th>Statut</th><th></th></tr></thead>
                        <tbody>
                            @foreach($rooms as $room)
                            @php
                                $hasActiveResv = $room->reservations
                                    ->filter(fn($r) => \Carbon\Carbon::parse($r->start_time)->isPast() === false)
                                    ->count();
                                $nextResv = $room->reservations
                                    ->filter(fn($r) => \Carbon\Carbon::parse($r->start_time)->isFuture())
                                    ->sortBy('start_time')->first();
                                $isOccupied = $room->reservations->filter(function($r) {
                                    $s = \Carbon\Carbon::parse($r->start_time);
                                    $e = \Carbon\Carbon::parse($r->end_time);
                                    return now()->between($s, $e);
                                })->count() > 0;
                            @endphp
                            <tr class="room-row"
                                data-id="{{ $room->id }}"
                                data-name="{{ $room->name }}"
                                data-location="{{ $room->location ?? '—' }}"
                                data-capacity="{{ $room->capacity ?? '—' }}"
                                data-description="{{ $room->description ?? '' }}"
                                data-resv-count="{{ $room->reservations->count() }}"
                                data-upcoming="{{ $hasActiveResv }}"
                                data-status="{{ $isOccupied ? 'taken' : 'free' }}"
                                data-next="{{ $nextResv ? \Carbon\Carbon::parse($nextResv->start_time)->format('d/m/Y H:i') : '' }}"
                                data-next-user="{{ $nextResv ? ($nextResv->user->name ?? '—') : '' }}">
                                <td>
                                    <div class="tbl-user">
                                        <div class="tbl-avatar" style="border-radius:8px;background:var(--stone-2);color:var(--ink-40);font-size:16px;">🏢</div>
                                        <div class="tbl-name">{{ $room->name }}</div>
                                    </div>
                                </td>
                                <td style="color:var(--ink-40);font-size:12px;">📍 {{ $room->location ?? '—' }}</td>
                                <td style="font-size:13px;color:var(--ink);">
                                    @if($room->capacity) 👥 {{ $room->capacity }} places @else — @endif
                                </td>
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
                                $start = \Carbon\Carbon::parse($res->start_time);
                                $end   = \Carbon\Carbon::parse($res->end_time);
                                $isPast  = $start->isPast();
                                $isToday = $start->isToday();
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
                                <td>
                                    <div><div class="tbl-date__main">{{ $start->translatedFormat('d M Y') }}</div><div class="tbl-date__time">{{ $start->format('H:i') }} → {{ $end->format('H:i') }}</div></div>
                                </td>
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
                        <div class="panel-subtitle">{{ $totalUsers }} comptes enregistrés — cliquez sur une ligne pour les détails</div>
                    </div>
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
                                        <div>
                                            <div class="tbl-name">{{ $user->name }}</div>
                                        </div>
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


{{-- ══ DETAIL DRAWER ══ --}}
<div class="detail-overlay" id="detailOverlay"></div>
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

{{-- Formulaire de suppression (soumis via JS) --}}
<form id="deleteUserForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>


<script>
(function () {
    'use strict';

    /* ── Date ── */
    const dateEl = document.getElementById('adminDate');
    if (dateEl) dateEl.textContent = new Date().toLocaleDateString('fr-FR', { weekday:'long', day:'numeric', month:'long', year:'numeric' });

    /* ── Navigation panels ── */
    const panelLabels = { dashboard: 'Tableau de bord', rooms: 'Salles', reservations: 'Réservations', users: 'Utilisateurs' };

    document.querySelectorAll('[data-panel]').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('[data-panel]').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.admin-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('panel-' + this.dataset.panel)?.classList.add('active');
            document.getElementById('breadcrumb').textContent = panelLabels[this.dataset.panel] || '';
        });
    });

    /* ── Drawer ── */
    const overlay     = document.getElementById('detailOverlay');
    const drawer      = document.getElementById('detailDrawer');
    const drawerClose = document.getElementById('drawerClose');

    function openDrawer() {
        overlay.classList.add('open');
        drawer.classList.add('open');
        document.getElementById('deleteConfirm').classList.remove('visible');
    }

    function closeDrawer() {
        overlay.classList.remove('open');
        drawer.classList.remove('open');
    }

    overlay.addEventListener('click', closeDrawer);
    drawerClose.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });

    function field(label, value, muted = false) {
        return `<div class="drawer-field">
            <span class="drawer-field__label">${label}</span>
            <div class="drawer-field__val ${muted ? 'muted' : ''}">${value || '—'}</div>
        </div>`;
    }

    function chip(text) {
        return `<span class="drawer-chip">${text}</span>`;
    }

    function statusBadge(type, label) {
        return `<span class="status-badge status-badge--${type}">${label}</span>`;
    }

    /* ── USER rows ── */
    document.querySelectorAll('.user-row').forEach(row => {
        row.addEventListener('click', function () {
            const d = this.dataset;
            const isAdmin = d.role === 'admin';
            const initials = d.name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0,2);

            document.getElementById('drawerEyebrow').textContent = 'Fiche utilisateur';
            document.getElementById('drawerTitle').innerHTML = `
                <div class="drawer-avatar-lg">${initials}</div>
                ${d.name}
            `;
            document.getElementById('drawerMeta').innerHTML =
                chip(isAdmin ? '⚡ Administrateur' : '👤 Utilisateur') +
                chip(`📅 ${d.resvCount} réservation${d.resvCount > 1 ? 's' : ''}`);

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
                <button class="btn-drawer btn-drawer--secondary" onclick="closeDrawerFn()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Fermer
                </button>
                <button class="btn-drawer btn-drawer--delete" id="btnDeleteUser">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Supprimer
                </button>
            `;

            const confirmBox = document.getElementById('deleteConfirm');
            document.getElementById('deleteConfirmText').textContent = `Supprimer "${d.name}" définitivement ?`;
            confirmBox.classList.remove('visible');

            document.getElementById('btnDeleteUser').addEventListener('click', () => {
                confirmBox.classList.add('visible');
            });

            document.getElementById('deleteConfirmYes').onclick = () => {
                const form = document.getElementById('deleteUserForm');
                form.action = deleteUrl;
                form.submit();
            };

            document.getElementById('deleteConfirmNo').onclick = () => {
                confirmBox.classList.remove('visible');
            };

            openDrawer();
        });
    });

    window.closeDrawerFn = closeDrawer;

    /* ── ROOM rows ── */
    document.querySelectorAll('.room-row').forEach(row => {
        row.addEventListener('click', function () {
            const d = this.dataset;
            const isFree = d.status === 'free';

            document.getElementById('drawerEyebrow').textContent = 'Fiche salle';
            document.getElementById('drawerTitle').textContent = d.name;
            document.getElementById('drawerMeta').innerHTML =
                chip(`📍 ${d.location}`) +
                chip(isFree ? '🟢 Libre' : '🔴 Occupée') +
                (d.capacity !== '—' ? chip(`👥 ${d.capacity} places`) : '');

            document.getElementById('drawerBody').innerHTML =
                field('Statut actuel', isFree ? statusBadge('free','Libre') : statusBadge('taken','Occupée')) +
                field('Localisation', d.location) +
                field('Capacité', d.capacity !== '—' ? d.capacity + ' personnes' : '—') +
                field('Total réservations', d.resvCount) +
                field('Réservations à venir', d.upcoming) +
                (d.next ? field('Prochaine réservation', `${d.next} — par ${d.nextUser}`) : '') +
                (d.description ? '<div class="drawer-divider"></div>' + field('Description', d.description, true) : '');

            document.getElementById('drawerActions').innerHTML = `
                <button class="btn-drawer btn-drawer--secondary" onclick="closeDrawerFn()">Fermer</button>
            `;
            document.getElementById('deleteConfirm').classList.remove('visible');

            openDrawer();
        });
    });

    /* ── RESERVATION rows ── */
    document.querySelectorAll('.resv-row').forEach(row => {
        row.addEventListener('click', function () {
            const d = this.dataset;
            const statusMap = { past: ['past','Terminée'], today: ['upcoming','Aujourd\'hui'], upcoming: ['upcoming','À venir'] };
            const [sc, sl] = statusMap[d.status] || ['past','—'];

            document.getElementById('drawerEyebrow').textContent = 'Détail réservation';
            document.getElementById('drawerTitle').textContent = d.room;
            document.getElementById('drawerMeta').innerHTML =
                chip(`👤 ${d.user}`) +
                chip(statusMap[d.status] ? `${d.status === 'past' ? '✅' : '📅'} ${sl}` : '');

            document.getElementById('drawerBody').innerHTML =
                field('Statut', statusBadge(sc, sl)) +
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

            document.getElementById('drawerActions').innerHTML = `
                <button class="btn-drawer btn-drawer--secondary" onclick="closeDrawerFn()">Fermer</button>
            `;
            document.getElementById('deleteConfirm').classList.remove('visible');

            openDrawer();
        });
    });

})();
</script>

</body>
</html>
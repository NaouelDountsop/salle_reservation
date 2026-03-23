

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="auth-container">

    {{-- ══ PARTIE IMAGE ══ --}}
    <div class="auth-left" style="background-image: url('{{ asset('images/salle-bg.jpg') }}');">
        <div class="auth-badge">
            <span class="auth-badge__dot"></span>
            <span class="auth-badge__text">Espace &amp; Réservation</span>
        </div>
        <div class="auth-text">
            <h1>Vos espaces,<br><em>à portée de clic.</em></h1>
            <p>Réservez salles de réunion, workshops et espaces professionnels en quelques secondes.</p>
        </div>
    </div>

    {{-- ══ FORMULAIRE ══ --}}
    <div class="auth-right">
        <div class="auth-box">

            {{-- Logo --}}
            <div class="auth-logo">
                <div class="auth-logo__mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <span class="auth-logo__name">SallesApp</span>
            </div>

            {{-- Titre --}}
            <div class="auth-heading">
                <h2>Bon retour.</h2>
                <p>Connectez-vous pour accéder à votre espace.</p>
            </div>
            <div class="auth-divider"></div>

            {{-- Erreurs de validation --}}
            @if($errors->any())
                <div class="auth-error" role="alert">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('error'))
                <div class="auth-error" role="alert">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('login.post') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="email">Adresse e-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="vous@exemple.com"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="auth-field">
                    <label for="password">Mot de passe</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="auth-submit">
                    Se connecter
                </button>
            </form>

            <div class="auth-link">
                Pas encore de compte ?
                <a href="{{ route('register') }}">Créer un compte</a>
            </div>

        </div>
    </div>

</div>
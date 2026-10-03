<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MarséBazaar')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF5EA] text-[#1B1A17] font-sans">

    <header class="bg-[#1E2A4A] text-white">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('produits.index') }}" class="font-display font-extrabold text-xl tracking-tight">
                Marsé<span class="text-[#E1A940]">Bazaar</span>
            </a>

            <nav class="flex items-center gap-5 text-sm">
                @auth
                    @if(auth()->user()->role === 'vendeur')
                        <a href="{{ route('vendeur.dashboard') }}" class="hover:text-[#E1A940] transition">Ma boutique</a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#E1A940] transition">Administration</a>
                    @endif

                    <a href="{{ route('commande.historique') }}" class="hover:text-[#E1A940] transition">Mes commandes</a>
                    <a href="{{ route('panier.index') }}" class="hover:text-[#E1A940] transition">🛒 Panier</a>

                    <span class="text-[#C9D0E0]">{{ Auth::user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg transition">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-[#E1A940] transition">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-[#E1A940] text-[#3a2a08] font-bold px-4 py-2 rounded-lg hover:bg-[#c99632] transition">
                        Inscription
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8">
        @yield('content')
    </main>

    <footer class="mt-16 border-t border-[#E4DAC5] py-6">
        <p class="max-w-6xl mx-auto px-6 text-xs text-[#6b6558]">
            ©️ {{ date('Y') }} MarséBazaar — Plateforme de marketplace locale
        </p>
    </footer>

    {{-- Notifications temps réel pour le vendeur --}}
    @auth
    @if(auth()->user()->role === 'vendeur' && auth()->user()->boutique)
    <div id="toast-zone" style="position:fixed; top:16px; right:16px; z-index:9999; display:flex; flex-direction:column; gap:12px;"></div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.Echo) { console.error('Echo non initialisé'); return; }

        const boutiqueId = {{ auth()->user()->boutique->id }};
        const urlCommandes = "{{ route('vendeur.dashboard') }}";

        window.Echo.private('boutique.' + boutiqueId)
            .listen('.nouvelle.commande', (e) => {
                const toast = document.createElement('a');
                toast.href = urlCommandes;
                toast.className = 'block w-80 bg-[#1E2A4A] text-white border-l-4 border-[#E1A940] rounded-xl shadow-lg p-4 transition';

                const titre = document.createElement('p');
                titre.className = 'font-bold text-[#E1A940]';
                titre.textContent = '🔔 Nouvelle commande !';

                const detail = document.createElement('p');
                detail.className = 'text-sm mt-1';
                detail.textContent = e.nomProduit + ' — ' + Number(e.montant).toLocaleString('fr-FR') + ' FCFA';

                toast.append(titre, detail);
                document.getElementById('toast-zone').appendChild(toast);
                setTimeout(() => toast.remove(), 8000);
            });
    });
    </script>
    @endif
    @endauth

</body>
</html>
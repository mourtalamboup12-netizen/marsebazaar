@extends('layouts.boutique')

@section('title', $produit->nom_produit . ' - MarséBazaar')

@section('content')

    <a href="{{ route('produits.index') }}" class="text-sm text-gray-500 underline">← Retour au catalogue</a>

    <div class="mt-4 grid md:grid-cols-2 gap-8">

        <div class="h-64 bg-[#F1E9D8] rounded-xl flex items-center justify-center text-6xl">
            🛍️
        </div>

        <div>
            <p class="text-sm font-bold text-[#3B6E4E]">
                🏪 {{ $produit->boutique->nom_boutique }}
            </p>

            <h1 class="text-2xl font-bold mt-2">{{ $produit->nom_produit }}</h1>

            <p class="text-3xl font-extrabold text-[#1E2A4A] mt-3">
                {{ number_format($produit->prix, 0, ',', ' ') }} F
            </p>

            <p class="text-gray-600 mt-4">{{ $produit->description }}</p>

            <p class="text-sm text-[#3B6E4E] font-bold mt-4">
                ✓ En stock ({{ $produit->stock }} disponibles)
            </p>

            <form method="POST" action="{{ route('panier.ajouter', $produit) }}" class="mt-6">
                @csrf
                <input type="hidden" name="quantite" value="1">
                <button type="submit" class="bg-[#1E2A4A] text-white px-6 py-3 rounded-lg font-bold">
                    Ajouter au panier
                </button>
            </form>
        </div>

    </div>

    <div class="mt-10">
    <h2 class="text-lg font-bold mb-3">Avis clients</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @forelse($produit->avis as $avis)
        <div class="border-b border-gray-200 py-3">
            <p class="font-bold text-sm">{{ $avis->client->name ?? 'Client' }} — {{ $avis->note }}/5</p>
            <p class="text-sm text-gray-600">{{ $avis->commentaire }}</p>
        </div>
    @empty
        <p class="text-gray-500 text-sm">Aucun avis pour ce produit pour le moment.</p>
    @endforelse

    @auth
        <div class="mt-6 bg-white border border-gray-200 rounded-xl p-4 max-w-md">
            <p class="font-bold text-sm mb-3">Laisser un avis</p>

            <form method="POST" action="{{ route('avis.store', $produit) }}">
                @csrf

                <label class="text-sm">Note</label>
                <select name="note" required class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 mb-3">
                    <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                    <option value="4">⭐⭐⭐⭐ (4)</option>
                    <option value="3">⭐⭐⭐ (3)</option>
                    <option value="2">⭐⭐ (2)</option>
                    <option value="1">⭐ (1)</option>
                </select>

                <label class="text-sm">Commentaire (optionnel)</label>
                <textarea name="commentaire" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 mb-3"></textarea>

                <button type="submit" class="bg-[#1E2A4A] text-white px-4 py-2 rounded-lg text-sm font-bold">
                    Envoyer mon avis
                </button>
            </form>
        </div>
    @else
        <p class="text-sm text-gray-500 mt-4">
            <a href="{{ route('login') }}" class="underline">Connecte-toi</a> pour laisser un avis.
        </p>
    @endauth
</div>

@endsection
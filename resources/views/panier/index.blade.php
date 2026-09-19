@extends('layouts.boutique')

@section('title', 'Mon panier - MarséBazaar')

@section('content')

    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">Mon panier</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @forelse($produits as $ligne)
        <div class="flex items-center justify-between bg-white border border-gray-100 rounded-xl shadow-sm px-5 py-4 mb-3">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-[#F1E9D8] rounded-lg flex items-center justify-center text-2xl">
                    🛍️
                </div>
                <div>
                    <p class="font-bold text-[#1E2A4A]">{{ $ligne['produit']->nom_produit }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $ligne['produit']->boutique->nom_boutique }} · Qté {{ $ligne['quantite'] }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <p class="font-bold text-[#1E2A4A]">
                    {{ number_format($ligne['sous_total'], 0, ',', ' ') }} F
                </p>

                <form method="POST" action="{{ route('panier.supprimer', $ligne['produit']) }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 underline">
                        Retirer
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <p class="text-gray-500 mb-2">Ton panier est vide pour le moment.</p>
            <a href="{{ route('produits.index') }}" class="text-[#1E2A4A] font-semibold underline text-sm">
                ← Voir le catalogue
            </a>
        </div>
    @endforelse

    @if(count($produits) > 0)
        <div class="mt-8 bg-white border border-gray-100 rounded-xl shadow-sm p-6 flex justify-between items-center">
            <p class="text-lg font-bold text-[#1E2A4A]">
                Total : {{ number_format($total, 0, ',', ' ') }} F
            </p>
            <a href="{{ route('commande.checkout') }}"
               class="bg-[#E1A940] hover:bg-[#c9942f] text-[#3a2a08] px-6 py-3 rounded-lg font-bold transition">
                Passer la commande
            </a>
        </div>
    @endif

@endsection
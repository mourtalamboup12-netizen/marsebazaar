@extends('layouts.boutique')

@section('title', 'Tableau de bord - MarséBazaar')

@section('content')

    <p class="text-sm text-gray-500">Bonjour 👋</p>
    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">{{ Auth::user()->name }}</h1>

    <div class="grid md:grid-cols-2 gap-4 mb-8">
        <a href="{{ route('produits.index') }}"
           class="bg-white border border-gray-100 shadow-sm hover:border-[#1E2A4A] rounded-xl p-6 transition">
            <p class="text-2xl mb-2">🛍️</p>
            <p class="font-bold text-[#1E2A4A]">Parcourir le catalogue</p>
            <p class="text-sm text-gray-500 mt-1">Découvre les produits des boutiques locales</p>
        </a>

        <a href="{{ route('commande.historique') }}"
           class="bg-white border border-gray-100 shadow-sm hover:border-[#1E2A4A] rounded-xl p-6 transition">
            <p class="text-2xl mb-2">📦</p>
            <p class="font-bold text-[#1E2A4A]">Mes commandes</p>
            <p class="text-sm text-gray-500 mt-1">Suis l'avancement de tes livraisons avec ColisPlus</p>
        </a>
    </div>

    <a href="{{ route('panier.index') }}" class="text-sm text-[#1E2A4A] font-semibold underline">
        🛒 Voir mon panier
    </a>
    <div class="mt-8 bg-white border border-gray-100 shadow-sm rounded-xl p-6 max-w-md">
        <p class="font-bold text-[#1E2A4A] mb-1">Tu es aussi commerçant ?</p>
        <p class="text-sm text-gray-500 mb-4">Ouvre ta boutique sur MarséBazaar et vends tes produits.</p>

        <form method="POST" action="{{ route('devenir.vendeur') }}">
            @csrf
            <button type="submit"
                class="bg-[#E1A940] hover:bg-[#c9942f] text-[#3a2a08] px-5 py-2.5 rounded-lg font-bold text-sm transition">
                Devenir vendeur
            </button>
        </form>
    </div>

@endsection
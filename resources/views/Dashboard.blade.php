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

@endsection
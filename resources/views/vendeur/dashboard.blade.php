@extends('layouts.boutique')

@section('title', 'Tableau de bord - MarséBazaar')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(!$boutique->valide)
        <div class="bg-[#F1E9D8] text-[#3a2a08] px-4 py-3 rounded-lg mb-6 text-sm border border-[#E4DAC5]">
            ⏳ Ta boutique est en attente de validation par un administrateur. Elle ne sera visible dans le catalogue qu'une fois validée.
        </div>
    @endif

    <p class="text-sm text-gray-500">Bonjour 👋</p>
    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">Boutique {{ $boutique->nom_boutique }}</h1>

    {{-- Statistiques --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-5">
            <p class="text-2xl font-extrabold text-[#1E2A4A]">{{ $nbProduits }}</p>
            <p class="text-xs text-gray-500 mt-1">Produits en ligne</p>
        </div>
        <div class="bg-[#E1A940] rounded-xl p-5 shadow-sm">
            <p class="text-2xl font-extrabold text-[#3a2a08]">{{ number_format($chiffreAffaires, 0, ',', ' ') }} F</p>
            <p class="text-xs text-[#3a2a08] mt-1">Chiffre d'affaires</p>
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('vendeur.produits.creer') }}"
           class="bg-[#1E2A4A] hover:bg-[#2E3F68] text-white px-5 py-3 rounded-lg font-bold transition">
            + Ajouter un produit
        </a>
        <a href="{{ route('vendeur.produits') }}"
           class="bg-white border border-gray-200 hover:border-[#1E2A4A] text-[#1E2A4A] px-5 py-3 rounded-lg font-semibold transition">
            Voir mes produits
        </a>
        <a href="{{ route('vendeur.commandes') }}"
           class="bg-white border border-gray-200 hover:border-[#1E2A4A] text-[#1E2A4A] px-5 py-3 rounded-lg font-semibold transition">
            Commandes reçues
        </a>
        <a href="{{ route('vendeur.questions') }}"
           class="bg-white border border-gray-200 hover:border-[#1E2A4A] text-[#1E2A4A] px-5 py-3 rounded-lg font-semibold transition">
            Questions clients
        </a>
    </div>

@endsection
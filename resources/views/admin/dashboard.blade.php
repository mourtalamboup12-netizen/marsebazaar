@extends('layouts.boutique')

@section('title', 'Administration - MarséBazaar')

@section('content')

    <h1 class="text-xl font-bold mb-6">Tableau de bord administrateur</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-2xl font-extrabold text-[#1E2A4A]">{{ $nbUtilisateurs }}</p>
            <p class="text-xs text-gray-500">Utilisateurs</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-2xl font-extrabold text-[#1E2A4A]">{{ $nbBoutiquesActives }}</p>
            <p class="text-xs text-gray-500">Boutiques actives</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-2xl font-extrabold text-[#1E2A4A]">{{ $nbCommandesTotales }}</p>
            <p class="text-xs text-gray-500">Commandes totales</p>
        </div>
        <div class="bg-[#E1A940] rounded-xl p-4">
            <p class="text-2xl font-extrabold text-[#3a2a08]">{{ $nbVendeursEnAttente }}</p>
            <p class="text-xs text-[#3a2a08]">Vendeurs en attente</p>
        </div>
    </div>

    <a href="{{ route('admin.boutiques') }}" class="bg-[#1E2A4A] text-white px-5 py-3 rounded-lg font-bold inline-block">
        Gérer les demandes vendeurs
    </a>

@endsection
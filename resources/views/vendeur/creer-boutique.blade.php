@extends('layouts.boutique')

@section('title', 'Créer ma boutique - MarséBazaar')

@section('content')

    <div class="max-w-md mx-auto text-center py-10">
        <p class="text-4xl mb-4">🏪</p>
        <h1 class="text-xl font-bold mb-2">Bienvenue vendeur !</h1>
        <p class="text-gray-600 mb-6">Avant de commencer à vendre, crée ta boutique sur MarséBazaar.</p>

        <form method="POST" action="{{ route('vendeur.boutique.creer') }}" class="text-left">
            @csrf

            <label class="text-sm font-bold">Nom de la boutique</label>
            <input type="text" name="nom_boutique" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1 mb-4">

            <label class="text-sm font-bold">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1 mb-4"></textarea>

            <button type="submit" class="bg-[#1E2A4A] text-white px-6 py-3 rounded-lg font-bold w-full">
                Créer ma boutique
            </button>
        </form>
    </div>

@endsection
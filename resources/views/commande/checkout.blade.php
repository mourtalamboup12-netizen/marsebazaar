@extends('layouts.boutique')

@section('title', 'Finaliser la commande - MarséBazaar')

@section('content')

    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">Finaliser ma commande</h1>

    {{-- Récapitulatif --}}
    <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 mb-6">
        <h2 class="font-bold text-[#1E2A4A] mb-4">Récapitulatif</h2>

        @foreach($produits as $ligne)
            <div class="flex justify-between border-b border-gray-100 py-3 text-sm text-gray-700">
                <span>{{ $ligne['produit']->nom_produit }} × {{ $ligne['quantite'] }}</span>
                <span class="font-semibold text-[#1E2A4A]">{{ number_format($ligne['sous_total'], 0, ',', ' ') }} F</span>
            </div>
        @endforeach

        <div class="flex justify-between pt-4 font-bold text-lg text-[#1E2A4A]">
            <span>Total</span>
            <span>{{ number_format($total, 0, ',', ' ') }} F</span>
        </div>
    </div>

    {{-- Paiement --}}
    <form method="POST" action="{{ route('commande.valider') }}"
          class="bg-white border border-gray-100 rounded-xl shadow-sm p-6"
          x-data="{ mode: '' }">
        @csrf

        <h2 class="font-bold text-[#1E2A4A] mb-4">Mode de paiement</h2>

        <label class="flex items-center gap-3 border rounded-lg px-4 py-3 mb-3 cursor-pointer transition"
               :class="mode === 'wave' ? 'border-[#1E2A4A] bg-[#F1E9D8]' : 'border-gray-300'">
            <input type="radio" name="mode_paiement" value="wave" x-model="mode" required class="accent-[#1E2A4A]">
            <span class="font-medium">Wave</span>
        </label>

        <label class="flex items-center gap-3 border rounded-lg px-4 py-3 mb-3 cursor-pointer transition"
               :class="mode === 'orange_money' ? 'border-[#1E2A4A] bg-[#F1E9D8]' : 'border-gray-300'">
            <input type="radio" name="mode_paiement" value="orange_money" x-model="mode" class="accent-[#1E2A4A]">
            <span class="font-medium">Orange Money</span>
        </label>

        <label class="flex items-center gap-3 border rounded-lg px-4 py-3 mb-6 cursor-pointer transition"
               :class="mode === 'livraison' ? 'border-[#1E2A4A] bg-[#F1E9D8]' : 'border-gray-300'">
            <input type="radio" name="mode_paiement" value="livraison" x-model="mode" class="accent-[#1E2A4A]">
            <span class="font-medium">Paiement à la livraison</span>
        </label>

        <button type="submit" class="bg-[#E1A940] hover:bg-[#c9942f] text-[#3a2a08] px-6 py-3 rounded-lg font-bold w-full transition">
            Confirmer la commande
        </button>
    </form>

@endsection
@extends('layouts.boutique')

@section('title', 'Commande confirmée - MarséBazaar')

@section('content')

    <div class="text-center py-10">
        <p class="text-4xl mb-4">✅</p>
        <h1 class="text-xl font-bold">Commande confirmée !</h1>

        <p class="text-gray-600 mt-2">
            Commande n° MB-{{ $commande->id }} — Total : {{ number_format($commande->montant_total, 0, ',', ' ') }} F
        </p>

        <p class="text-sm text-gray-500 mt-1">
            Mode de paiement : {{ str_replace('_', ' ', $commande->mode_paiement) }}
        </p>

        <a href="{{ route('produits.index') }}" class="inline-block mt-6 text-[#1E2A4A] underline text-sm">
            ← Retour au catalogue
        </a>
    </div>

@endsection
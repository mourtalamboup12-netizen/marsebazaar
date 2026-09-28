@extends('layouts.boutique')

@section('title', 'Mes commandes - MarséBazaar')

@section('content')

    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">Mes commandes</h1>

    @forelse($commandes as $commande)
        @php
            $dernierStatut = $commande->suivis->last()->statut ?? 'confirmee';
            $labels = [
                'confirmee' => 'Confirmée',
                'en_preparation' => 'En préparation',
                'expediee' => 'Expédiée',
                'en_livraison' => 'En livraison',
                'livree' => 'Livrée',
                'annulee' => 'Annulée',
            ];
            $icones = [
                'confirmee' => '✅',
                'en_preparation' => '📦',
                'expediee' => '🚚',
                'en_livraison' => '🛵',
                'livree' => '🏠',
                'annulee' => '❌',
            ];
        @endphp

        <a href="{{ route('commande.suivi', $commande) }}"
           class="flex items-center justify-between border border-gray-100 rounded-xl p-5 mb-3 shadow-sm hover:shadow-md hover:border-[#1E2A4A] transition bg-white">
            <div>
                <p class="font-bold text-[#1E2A4A]">Commande n° MB-{{ $commande->id }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $commande->created_at->format('d/m/Y') }} · {{ number_format($commande->montant_total, 0, ',', ' ') }} F
                </p>
            </div>

            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-[#F1E9D8] text-[#1E2A4A] whitespace-nowrap">
                {{ $icones[$dernierStatut] ?? '📦' }} {{ $labels[$dernierStatut] ?? $dernierStatut }}
            </span>
        </a>
    @empty
        <div class="text-center py-12">
            <p class="text-gray-500 mb-2">Tu n'as pas encore passé de commande.</p>
            <a href="{{ route('produits.index') }}" class="text-[#1E2A4A] font-semibold underline text-sm">
                ← Voir le catalogue
            </a>
        </div>
    @endforelse

@endsection
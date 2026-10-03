@extends('layouts.boutique')

@section('title', 'Commandes reçues - MarséBazaar')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">Commandes reçues</h1>

    @php
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

    @forelse($commandes as $commande)
        @php
            $statutActuel = $commande->suivis->last()->statut ?? 'confirmee';
        @endphp

        <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-5 mb-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="font-bold text-[#1E2A4A]">Commande n° MB-{{ $commande->id }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        Client : {{ $commande->client->name }} · {{ $commande->created_at->format('d/m/Y') }}
                    </p>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-[#F1E9D8] text-[#1E2A4A] whitespace-nowrap">
                    {{ $icones[$statutActuel] ?? '📦' }} {{ $labels[$statutActuel] }}
                </span>
            </div>

            <div class="text-sm text-gray-600 mb-3 space-y-0.5">
                @foreach($commande->lignes as $ligne)
                    <p>{{ $ligne->produit?->nom_produit ?? 'Produit indisponible' }} × {{ $ligne->quantite }}</p>
                @endforeach
            </div>

            <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                <span class="font-bold text-[#E1A940]">
                    {{ number_format($commande->montant_total, 0, ',', ' ') }} F
                </span>

                <div class="flex items-center gap-3">
                    <a href="{{ route('vendeur.commandes.show', $commande) }}"
                       class="text-sm font-semibold text-[#1E2A4A] border border-gray-200 hover:border-[#1E2A4A] px-3 py-1.5 rounded-lg transition">
                        Voir / Discuter
                    </a>

                    @if($statutActuel !== 'livree')
                        <form method="POST" action="{{ route('vendeur.commandes.statut', $commande) }}" class="flex gap-2">
                            @csrf
                            <select name="statut" class="rounded-lg border-gray-300 focus:border-[#1E2A4A] focus:ring-[#1E2A4A] text-sm py-1.5">
                                @foreach($etapes as $etape)
                                    <option value="{{ $etape }}" @selected($etape === $statutActuel)>
                                        {{ $labels[$etape] }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="bg-[#1E2A4A] hover:bg-[#2E3F68] text-white px-4 py-1.5 rounded-lg text-sm font-bold transition">
                                Mettre à jour
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <p class="text-gray-500">Aucune commande reçue pour le moment.</p>
        </div>
    @endforelse

@endsection
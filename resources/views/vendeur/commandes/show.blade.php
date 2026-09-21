@extends('layouts.boutique')

@section('title', 'Commande MB-' . $commande->id . ' - MarséBazaar')

@section('content')

    <a href="{{ route('vendeur.commandes') }}" class="text-sm text-gray-500 hover:text-[#1E2A4A] underline">
        ← Commandes reçues
    </a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mt-4 mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $labels = [
            'confirmee' => 'Confirmée',
            'en_preparation' => 'En préparation',
            'expediee' => 'Expédiée',
            'en_livraison' => 'En livraison',
            'livree' => 'Livrée',
        ];
        $statutActuel = $commande->suivis->last()->statut ?? 'confirmee';
    @endphp

    <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-6 mt-4 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="font-bold text-[#1E2A4A] text-lg">Commande n° MB-{{ $commande->id }}</p>
                <p class="text-sm text-gray-500 mt-1">
                   Client : {{ $commande->client->name }} · {{ $commande->created_at->format('d/m/Y') }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                  📞 {{ $commande->telephone }}
                </p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-[#F1E9D8] text-[#1E2A4A] whitespace-nowrap">
                {{ $labels[$statutActuel] }}
            </span>
        </div>

        <div class="text-sm text-gray-700 space-y-1 mb-4 border-t border-gray-100 pt-4">
            @foreach($commande->lignes as $ligne)
                <div class="flex justify-between">
                    <span>{{ $ligne->produit->nom_produit }} × {{ $ligne->quantite }}</span>
                    <span class="font-semibold">{{ number_format($ligne->prix_unitaire * $ligne->quantite, 0, ',', ' ') }} F</span>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center border-t border-gray-100 pt-4">
            <span class="font-bold text-[#E1A940] text-lg">
                {{ number_format($commande->montant_total, 0, ',', ' ') }} F
            </span>

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

    {{-- Discussion avec le client --}}
    <div class="max-w-md">
        <h2 class="font-bold text-[#1E2A4A] mb-3">Discussion avec le client</h2>

        <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-4 mb-3 max-h-80 overflow-y-auto space-y-3">
            @forelse($commande->messages as $message)
                @php $estMoi = $message->id_expediteur === auth()->id(); @endphp
                <div class="flex {{ $estMoi ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] {{ $estMoi ? 'bg-[#1E2A4A] text-white' : 'bg-[#F1E9D8] text-[#1B1A17]' }} rounded-xl px-4 py-2">
                        <p class="text-xs font-semibold mb-0.5 {{ $estMoi ? 'text-gray-300' : 'text-[#6b6558]' }}">
                            {{ $estMoi ? 'Toi' : $message->expediteur->name }}
                        </p>
                        <p class="text-sm">{{ $message->contenu }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Aucun message pour le moment.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('messages.store', $commande) }}" class="flex gap-2">
            @csrf
            <input type="text" name="contenu" required placeholder="Écrire un message..."
                   class="flex-1 rounded-lg border-gray-300 focus:border-[#1E2A4A] focus:ring-[#1E2A4A] text-sm">
            <button type="submit"
                class="bg-[#1E2A4A] hover:bg-[#2E3F68] text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                Envoyer
            </button>
        </form>
    </div>

@endsection 

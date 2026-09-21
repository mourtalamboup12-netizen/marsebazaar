@extends('layouts.boutique')

@section('title', 'Suivi ColisPlus - MarséBazaar')

@section('content')

    <a href="{{ route('commande.historique') }}" class="text-sm text-gray-500 hover:text-[#1E2A4A] underline">← Mes commandes</a>

    <div class="bg-[#1E2A4A] text-white rounded-xl p-5 mt-4 mb-8 shadow-sm">
        <span class="inline-block bg-[#E1A940] text-[#3a2a08] text-xs font-bold px-3 py-1 rounded-full">
            📦 ColisPlus
        </span>
        <p class="text-sm text-gray-300 mt-2">Commande n° MB-{{ $commande->id }}</p>
        <h1 class="text-xl font-bold mt-1">
            @php
                $labels = [
                    'confirmee' => 'Commande confirmée',
                    'en_preparation' => 'En préparation',
                    'expediee' => 'Expédiée',
                    'en_livraison' => 'En livraison',
                    'livree' => 'Livrée',
                ];
            @endphp
            {{ $labels[$etapes[$indexActuel]] }}
        </h1>
    </div>

    <div class="max-w-md">
        @foreach($etapes as $i => $etape)
            @php
                $suivi = $commande->suivis->firstWhere('statut', $etape);
                $termine = $i <= $indexActuel;
                $enCours = $i === $indexActuel;
            @endphp

            <div class="flex gap-4 {{ !$loop->last ? 'pb-7 border-l-2 ml-3' : 'ml-3' }} {{ $termine ? 'border-[#3B6E4E]' : 'border-gray-200' }}">
                <div class="-ml-3">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white
                        {{ $termine ? ($enCours ? 'bg-[#E1A940] text-[#3a2a08]' : 'bg-[#3B6E4E]') : 'bg-gray-300' }}">
                        {{ $termine ? '✓' : $i + 1 }}
                    </div>
                </div>
                <div class="-mt-1">
                    <p class="font-bold text-sm {{ $termine ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $labels[$etape] }}
                    </p>
                    <p class="text-xs text-gray-500">
                        @if($suivi)
                            {{ $suivi->created_at->format('d/m/Y à H:i') }}
                        @else
                            En attente
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 bg-white border border-gray-100 shadow-sm rounded-xl p-4 max-w-md">
        <div class="flex justify-between text-sm py-1">
            <span class="text-gray-500">Mode de paiement</span>
            <span class="font-bold text-[#1E2A4A]">{{ str_replace('_', ' ', $commande->mode_paiement) }}</span>
        </div>
        <div class="flex justify-between text-sm py-1">
            <span class="text-gray-500">Montant</span>
            <span class="font-bold text-[#1E2A4A]">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</span>
        </div>
        <div class="flex justify-between text-sm py-1">
        <span class="text-gray-500">Téléphone</span>
        <span class="font-bold text-[#1E2A4A]">{{ $commande->telephone }}</span>
        </div>
    </div>
    {{-- Discussion avec le vendeur --}}
    <div class="mt-8 max-w-md">
        <h2 class="font-bold text-[#1E2A4A] mb-3">Discussion avec le vendeur</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

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
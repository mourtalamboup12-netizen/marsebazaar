@extends('layouts.boutique')

@section('title', 'Question sur ' . $produit->nom_produit . ' - MarséBazaar')

@section('content')

    <a href="{{ route('vendeur.questions') }}" class="text-sm text-gray-500 hover:text-[#1E2A4A] underline">
        ← Questions clients
    </a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mt-4 mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-5 mt-4 mb-6">
        <p class="font-bold text-[#1E2A4A]">{{ $produit->nom_produit }}</p>
        <p class="text-sm text-gray-500 mt-1">Discussion avec {{ $client->name }}</p>
    </div>

    <div class="max-w-md">
        <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-4 mb-3 max-h-80 overflow-y-auto space-y-3">
            @forelse($messages as $message)
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

        <form method="POST" action="{{ route('questions.repondre', [$produit, $client]) }}" class="flex gap-2">
            @csrf
            <input type="text" name="contenu" required placeholder="Écrire une réponse..."
                   class="flex-1 rounded-lg border-gray-300 focus:border-[#1E2A4A] focus:ring-[#1E2A4A] text-sm">
            <button type="submit"
                class="bg-[#1E2A4A] hover:bg-[#2E3F68] text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                Répondre
            </button>
        </form>
    </div>

@endsection 

@extends('layouts.boutique')

@section('title', 'Boutiques en attente - MarséBazaar')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-xl font-bold mb-6">Demandes de boutiques en attente</h1>

    @forelse($boutiques as $boutique)
        <div class="flex items-center justify-between border border-gray-200 rounded-xl p-4 mb-3 bg-white">
            <div>
                <p class="font-bold">{{ $boutique->nom_boutique }}</p>
                <p class="text-sm text-gray-500">
                    Vendeur : {{ $boutique->vendeur->name }} ({{ $boutique->vendeur->email }})
                </p>
                @if($boutique->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $boutique->description }}</p>
                @endif
            </div>

            <div class="flex gap-2">
                <form method="POST" action="{{ route('admin.boutiques.valider', $boutique) }}">
                    @csrf
                    <button type="submit" class="bg-[#3B6E4E] text-white px-4 py-2 rounded-lg text-sm font-bold">
                        Valider
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.boutiques.refuser', $boutique) }}"
                      onsubmit="return confirm('Refuser et supprimer cette boutique ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-[#EFE3E3] text-[#C1502E] px-4 py-2 rounded-lg text-sm font-bold">
                        Refuser
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Aucune demande en attente.</p>
    @endforelse

@endsection
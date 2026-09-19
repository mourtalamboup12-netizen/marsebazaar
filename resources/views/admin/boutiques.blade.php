@extends('layouts.boutique')

@section('title', 'Boutiques en attente - MarséBazaar')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">Demandes de boutiques en attente</h1>

    @forelse($boutiques as $boutique)
        <div class="flex items-center justify-between bg-white border border-gray-100 shadow-sm rounded-xl p-5 mb-3">
            <div>
                <p class="font-bold text-[#1E2A4A]">{{ $boutique->nom_boutique }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    Vendeur : {{ $boutique->vendeur->name }} ({{ $boutique->vendeur->email }})
                </p>
                @if($boutique->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $boutique->description }}</p>
                @endif
            </div>

            <div class="flex gap-2">
                <form method="POST" action="{{ route('admin.boutiques.valider', $boutique) }}">
                    @csrf
                    <button type="submit"
                        class="bg-[#3B6E4E] hover:bg-[#2d5539] text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                        Valider
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.boutiques.refuser', $boutique) }}"
                      onsubmit="return confirm('Refuser et supprimer cette boutique ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-[#EFE3E3] hover:bg-[#e5d0d0] text-[#C1502E] px-4 py-2 rounded-lg text-sm font-bold transition">
                        Refuser
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <p class="text-gray-500">Aucune demande en attente.</p>
        </div>
    @endforelse

@endsection
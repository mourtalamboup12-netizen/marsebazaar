@extends('layouts.boutique')

@section('title', 'Mes produits - MarséBazaar')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#1E2A4A]">Mes produits</h1>
        <a href="{{ route('vendeur.produits.creer') }}"
           class="bg-[#1E2A4A] hover:bg-[#2E3F68] text-white px-4 py-2 rounded-lg font-bold text-sm transition">
            + Ajouter un produit
        </a>
    </div>

    @forelse($produits as $produit)
        <div class="flex items-center justify-between bg-white border border-gray-100 shadow-sm rounded-xl p-5 mb-3">
            <div>
                <p class="font-bold text-[#1E2A4A]">{{ $produit->nom_produit }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $produit->categorie->nom_categorie }} · Stock : {{ $produit->stock }}
                </p>
                <p class="font-bold text-[#E1A940] mt-1">{{ number_format($produit->prix, 0, ',', ' ') }} F</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('vendeur.produits.edit', $produit) }}"
                   class="text-sm font-semibold text-[#1E2A4A] border border-gray-200 hover:border-[#1E2A4A] px-3 py-1.5 rounded-lg transition">
                    Modifier
                </a>
                <form method="POST" action="{{ route('vendeur.produits.destroy', $produit) }}"
                      onsubmit="return confirm('Supprimer ce produit ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-sm font-semibold text-red-600 border border-red-200 hover:bg-red-50 px-3 py-1.5 rounded-lg transition">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <p class="text-gray-500">Aucun produit pour le moment.</p>
        </div>
    @endforelse

@endsection
@extends('layouts.boutique')

@section('title', 'Catalogue - MarséBazaar')

@section('content')

    <form method="GET" class="mb-8 flex flex-col md:flex-row gap-3">
        <input type="text" name="recherche" value="{{ request('recherche') }}"
               placeholder="Rechercher un produit..."
               class="flex-1 border border-[#E4DAC5] rounded-lg px-4 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#1E2A4A]">

        <select name="categorie" class="border border-[#E4DAC5] rounded-lg px-4 py-2.5 bg-white">
            <option value="">Toutes catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('categorie') == $cat->id)>
                    {{ $cat->nom_categorie }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-[#1E2A4A] text-white font-bold px-6 py-2.5 rounded-lg hover:bg-[#2E3F68] transition">
            Filtrer
        </button>
    </form>

    <h1 class="font-display font-bold text-lg mb-4">Produits</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($produits as $produit)
            <a href="{{ route('produits.show', $produit) }}"
               class="bg-white border border-[#E4DAC5] rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition">
                <div class="h-32 bg-[#F1E9D8] flex items-center justify-center text-4xl">
                    🛍️
                </div>
                <div class="p-3">
                    <p class="font-bold text-sm leading-snug">{{ $produit->nom_produit }}</p>
                    <p class="text-xs text-[#6b6558] mb-1.5">{{ $produit->boutique->nom_boutique }}</p>
                    <p class="text-[#1E2A4A] font-bold">{{ number_format($produit->prix, 0, ',', ' ') }} F</p>
                </div>
            </a>
        @empty
            <p class="col-span-4 text-[#6b6558]">Aucun produit trouvé.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $produits->links() }}
    </div>

@endsection
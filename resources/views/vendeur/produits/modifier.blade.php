@extends('layouts.boutique')

@section('title', 'Modifier ' . $produit->nom_produit . ' - MarséBazaar')

@section('content')

    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">Modifier le produit</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm max-w-md">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vendeur.produits.update', $produit) }}"
          enctype="multipart/form-data"
          class="max-w-md bg-white border border-gray-100 shadow-sm rounded-xl p-6">
        @csrf
        @method('PUT')

        <label class="text-sm font-bold text-[#1E2A4A]">Nom du produit</label>
        <input type="text" name="nom_produit" value="{{ old('nom_produit', $produit->nom_produit) }}" required
               class="w-full rounded-lg border-gray-300 focus:border-[#1E2A4A] focus:ring-[#1E2A4A] mt-1 mb-4">

        <label class="text-sm font-bold text-[#1E2A4A]">Description</label>
        <textarea name="description" rows="3"
                  class="w-full rounded-lg border-gray-300 focus:border-[#1E2A4A] focus:ring-[#1E2A4A] mt-1 mb-4">{{ old('description', $produit->description) }}</textarea>

        <label class="text-sm font-bold text-[#1E2A4A]">Prix (F CFA)</label>
        <input type="number" name="prix" value="{{ old('prix', $produit->prix) }}" step="0.01" required
               class="w-full rounded-lg border-gray-300 focus:border-[#1E2A4A] focus:ring-[#1E2A4A] mt-1 mb-4">

        <label class="text-sm font-bold text-[#1E2A4A]">Stock disponible</label>
        <input type="number" name="stock" value="{{ old('stock', $produit->stock) }}" required
               class="w-full rounded-lg border-gray-300 focus:border-[#1E2A4A] focus:ring-[#1E2A4A] mt-1 mb-4">

        <label class="text-sm font-bold text-[#1E2A4A]">Catégorie</label>
        <select name="id_categorie" required
                class="w-full rounded-lg border-gray-300 focus:border-[#1E2A4A] focus:ring-[#1E2A4A] mt-1 mb-6">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('id_categorie', $produit->id_categorie) == $cat->id)>
                    {{ $cat->nom_categorie }}
                </option>
            @endforeach
        </select>
        @if($produit->photo)
            <img src="{{ asset('storage/'.$produit->photo) }}" class="w-24 h-24 object-cover rounded-lg mb-3">
        @endif

        <button type="submit"
            class="bg-[#1E2A4A] hover:bg-[#2E3F68] text-white px-6 py-3 rounded-lg font-bold w-full transition">
            Enregistrer les modifications
        </button>
    </form>

@endsection
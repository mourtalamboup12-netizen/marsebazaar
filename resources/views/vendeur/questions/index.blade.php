@extends('layouts.boutique')

@section('title', 'Questions clients - MarséBazaar')

@section('content')

    <h1 class="text-2xl font-bold text-[#1E2A4A] mb-6">Questions clients</h1>

    @forelse($fils as $fil)
        <a href="{{ route('vendeur.questions.show', [$fil->produit, $fil->client]) }}"
           class="flex items-center justify-between bg-white border border-gray-100 shadow-sm hover:border-[#1E2A4A] rounded-xl p-5 mb-3 transition">
            <div>
                <p class="font-bold text-[#1E2A4A]">{{ $fil->produit->nom_produit }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    Question de {{ $fil->client->name }}
                </p>
                <p class="text-sm text-gray-600 mt-1 truncate max-w-md">
                    "{{ $fil->contenu }}"
                </p>
            </div>
            <span class="text-xs text-gray-400 whitespace-nowrap">
                {{ $fil->created_at->diffForHumans() }}
            </span>
        </a>
    @empty
        <div class="text-center py-12">
            <p class="text-gray-500">Aucune question pour le moment.</p>
        </div>
    @endforelse

@endsection 

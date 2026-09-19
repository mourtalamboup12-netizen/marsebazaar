<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suivi_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_commande')->constrained('commandes')->onDelete('cascade');
            $table->enum('statut', ['confirmee', 'en_preparation', 'expediee', 'en_livraison', 'livree']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suivi_commandes');
    }
};
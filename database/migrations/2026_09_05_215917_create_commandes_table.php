<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant_total', 10, 2);
            $table->enum('mode_paiement', ['wave', 'orange_money', 'livraison']);
            $table->enum('statut_paiement', ['en_attente', 'paye', 'regle_a_la_livraison'])->default('en_attente');
            $table->foreignId('id_client')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
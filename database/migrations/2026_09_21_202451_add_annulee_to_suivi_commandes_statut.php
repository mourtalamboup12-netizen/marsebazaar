<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE suivi_commandes MODIFY statut ENUM('confirmee', 'en_preparation', 'expediee', 'en_livraison', 'livree', 'annulee')");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE suivi_commandes MODIFY statut ENUM('confirmee', 'en_preparation', 'expediee', 'en_livraison', 'livree')");
    }
};
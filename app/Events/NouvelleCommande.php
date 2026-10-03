<?php

namespace App\Events;

use App\Models\Commande;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NouvelleCommande implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idBoutique;
    public $nomProduit;
    public $montant;

    public function __construct($idBoutique, $nomProduit, $montant)
    {
        $this->idBoutique = $idBoutique;
        $this->nomProduit = $nomProduit;
        $this->montant = $montant;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('boutique.' . $this->idBoutique),
        ];
    }

    public function broadcastAs(): string
    {
        return 'nouvelle.commande';
    }

    public function broadcastWith(): array
    {
        return [
            'nomProduit' => $this->nomProduit,
            'montant' => $this->montant,
        ];
    }
}
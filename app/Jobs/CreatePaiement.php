<?php

namespace App\Jobs;

use App\Models\Commande;
use App\Models\Paiement;
use Carbon\Carbon;

class CreatePaiement extends Job
{
    protected $commande;

    /**
     * Create a new job instance.
     *
     * @param Commande $commande
     * @return void
     */
    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $commande = $this->commande;
        $date = Carbon::now();
        Paiement::create([
            'commande_id' => $commande->id,
            'created_at' => $date,
            'amount' => $commande->total,
        ]);
    }
}

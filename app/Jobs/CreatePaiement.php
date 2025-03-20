<?php

namespace App\Jobs;

use App\Models\Commande;
use App\Models\Paiement;
use App\Notifications\OrderPaid;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePaiement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        Paiement::create([
            'commande_id' => $this->commande->id,
            'date_paiement' => Carbon::now(),
            'montant' => $this->commande->total,
        ]);
        $this->commande->user->notify(new OrderPaid($this->commande));
    }
}

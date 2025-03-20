<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaid extends Notification
{
    use Queueable;

    protected $commande;

    /**
     * Create a new notification instance.
     *
     * @param Commande $commande
     * @return void
     */
    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Send the notification via email
    }

    /**
     * Build the mail message for the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $commande = $this->commande;

        return (new MailMessage)
            ->subject('Paiement de votre commande confirmé')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Nous avons bien reçu le paiement pour votre commande #' . $commande->id)
            ->line('Statut de la commande: ' . $commande->statut)
            ->line('Montant payé: ' . number_format($commande->total) . ' CFA')
            ->action('Voir la commande', route('commande.show', $commande))
            ->line('Merci pour votre paiement! Nous vous souhaitons une excellente journée.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'commande_id' => $this->commande->id,
            'total' => $this->commande->total,
            'statut' => $this->commande->statut,
        ];
    }
}

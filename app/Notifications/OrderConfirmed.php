<?php

namespace App\Notifications;

use App\Models\Commande;
use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmed extends Notification
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


        $pdf = app(PDF::class)->loadView('invoices.facture', compact('commande')); // 'invoices.facture' is the Blade view to generate the PDF

        $pdfContent = $pdf->output();

        return (new MailMessage)
            ->subject('Votre commande a été validée ')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Nous vous informons que votre commande #' . $commande->id . ' a été validée')
            ->line('Statut de la commande: ' . $commande->statut)
            ->line('Total: ' . number_format($commande->total) . ' CFA')
            ->action('Voir la commande', route('commande.show', $commande))
            ->line('Merci pour valider votre achat!')
            ->attachData($pdfContent, 'facture-' . $commande->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
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

<?php
namespace App\Notifications;

use App\Models\Commande;
use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

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
* @return \Illuminate\Notifications\Messages\MailMessage
*/
public function toMail($notifiable)
{
$commande = $this->commande;

Log::debug('Commande Notification:', ['commande' => $commande]);

// Generate PDF for the invoice (facture)
$pdf = app(PDF::class)->loadView('invoices.facture', compact('commande')); // 'invoices.facture' is the Blade view to generate the PDF

// Attach the generated PDF
$pdfContent = $pdf->output(); // Get the PDF content in binary form

return (new MailMessage)
->subject('Votre commande a été validée et payée')
->greeting('Bonjour ' . $notifiable->name)
->line('Nous vous informons que votre commande #' . $commande->id . ' a été validée et payée.')
->line('Statut de la commande: ' . $commande->statut)
->line('Total: ' . number_format($commande->total, 2) . ' CFA')
->action('Voir la commande', route('commande.show', $commande))
->line('Merci pour votre achat!')
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
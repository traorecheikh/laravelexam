<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - ISI Burger - Commande #{{ $commande->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            border-bottom: 2px solid #FF6B35;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }

        .company-details {
            float: right;
            text-align: right;
        }

        .invoice-title {
            color: #FF6B35;
            margin-top: 30px;
            font-size: 24px;
            font-weight: bold;
        }

        .client-details,
        .invoice-details {
            margin-bottom: 20px;
            width: 50%;
            float: left;
        }

        .invoice-id {
            font-size: 18px;
            font-weight: bold;
            color: #FF6B35;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th {
            background-color: #FF6B35;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-section {
            margin-top: 20px;
            text-align: right;
        }

        .total-line {
            font-weight: bold;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #FF6B35;
            border-top: 2px solid #FF6B35;
            padding-top: 10px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            text-align: center;
        }

        .payment-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #f7f7f7;
            border-radius: 5px;
        }

        .notes {
            margin-top: 30px;
            font-style: italic;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .status-paid {
            color: #28a745;
            font-weight: bold;
        }

        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }

        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }

        .barcode {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>

<body>
<div class="header clearfix">
    <div class="company-details">
        <h2>ISI Burger</h2>
        <p>12 Avenue de la Liberté<br>
            Dakar, Sénégal<br>
            Tél: +221 781706184<br>
            Email: contact@isiburger.sn<br>
            Site web: www.isiburger.sn<br>
            NINEA: 123456789</p>
    </div>
    <div>
        <img class="logo"
             src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/images/logo.png'))) }}"
             alt="Logo ISI Burger">
    </div>
</div>

<h1 class="invoice-title">FACTURE</h1>

<div class="clearfix">
    <div class="client-details">
        <h3>Informations Client</h3>
        <p><strong>Nom:</strong> {{ $commande->user->name }}<br>
            @if($commande->adresse_livraison)
                <strong>Adresse:</strong> {{ $commande->adresse_livraison }}<br>
            @endif
            <strong>Téléphone:</strong> {{ $commande->user->telephone }}<br>
            <strong>Email:</strong> {{ $commande->user->email }}<br>
            <strong>Client depuis:</strong> {{ $commande->user->created_at->format('d/m/Y') }}
        </p>
    </div>

    <div class="invoice-details">
        <h3>Détails de la Facture</h3>
        <p><span class="invoice-id">Facture
                    #{{ $commande->reference_facture ?? 'F-' . str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</span><br>
            <strong>Commande #:</strong> {{ $commande->id }}<br>
            <strong>Date de commande:</strong> {{ $commande->created_at->format('d/m/Y à H:i') }}<br>
            <strong>Mode de paiement:</strong> {{ $commande->mode_paiement }}<br>
            <strong>Référence paiement:</strong> {{ $commande->reference_paiement ?? 'N/A' }}<br>
            <strong>Statut:</strong>
            @if ($commande->statut == 'Payée')
                <span class="status-paid">{{ $commande->statut }}</span>
            @elseif($commande->statut == 'En attente')
                <span class="status-pending">{{ $commande->statut }}</span>
            @elseif($commande->statut == 'Annulée')
                <span class="status-cancelled">{{ $commande->statut }}</span>
            @else
                {{ $commande->statut }}
            @endif
        </p>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th>Produit</th>
        <th>Description</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Sous-total</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($commande->burgers as $produit)
        <tr>
            <td>{{ $produit->nom }}</td>
            <td>{{ $produit->description }}</td>
            <td>{{ $produit->pivot->quantite }}</td>
            <td>{{ number_format($produit->prix, 0, '.', ' ') }} CFA</td>
            <td>{{ number_format($produit->prix * $produit->pivot->quantite, 0, '.', ' ') }} CFA</td>
        </tr>
    @endforeach

    @if ($commande->burgers->count() > 0)
        @foreach ($commande->burgers as $supplement)
            <tr>
                <td>Supplément: {{ $supplement->nom }}</td>
                <td>{{ $supplement->description }}</td>
                <td>{{ $supplement->pivot->quantite }}</td>
                <td>{{ number_format($supplement->prix, 0, '.', ' ') }} CFA</td>
                <td>{{ number_format($supplement->prix * $supplement->pivot->quantite, 0, '.', ' ') }} CFA</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<div class="total-section">
    <p class="total-line"><strong>Sous-total:</strong> {{ number_format($commande->sous_total, 0, '.', ' ') }} CFA
    </p>
    <p class="total-line"><strong>Frais de livraison:</strong>
        {{ number_format($commande->frais_livraison, 0, '.', ' ') }} CFA</p>
    @if ($commande->code_promo)
        <p class="total-line"><strong>Code promo ({{ $commande->code_promo }}):</strong>
            -{{ number_format($commande->montant_reduction, 0, '.', ' ') }} CFA</p>
    @endif
    <p class="total-line"><strong>TVA (18%):</strong> {{ number_format($commande->montant_tva, 0, '.', ' ') }} CFA
    </p>
    <p class="grand-total"><strong>TOTAL:</strong> {{ number_format($commande->total, 0, '.', ' ') }} CFA</p>
</div>

<div class="payment-info">
    <h3>Informations de paiement</h3>
    <p>Veuillez effectuer votre règlement par virement bancaire ou via Orange Money/Wave ou en especes:</p>
    <p><strong>Coordonnées bancaires:</strong><br>
        Banque: CBAO Groupe Attijariwafa Bank<br>
        IBAN: SN01 1234 5678 9012 3456 7890<br>
        BIC/SWIFT: CBAOSNDA</p>

    <p><strong>Mobile Money:</strong><br>
        Orange Money: +221 78 277 55 79<br>
        Wave: +221 78 170 61 84</p>
</div>

<div class="notes">
    <h3>Notes</h3>
    <p>Merci de votre confiance! Votre satisfaction est notre priorité.</p>
    <p>Cette facture est valable pendant 14 jours. Pour toute question concernant cette facture, veuillez contacter
        notre service client au +221 33 865 25 17 ou par email à facturation@isiburger.sn</p>
</div>

<div class="barcode">
    <img
        src="data:image/png;base64,{{ generateBarcode($commande->reference_facture ?? 'F' . str_pad($commande->id, 6, '0', STR_PAD_LEFT)) }}"
        alt="Barcode">
</div>

<div class="footer">
    <p>ISI Burger SARL - RC: SN-DKR-2020-B-1234 - NINEA: 123456789</p>
    <p>12 Avenue de la Liberté, Dakar, Sénégal - Tél: +221 78 170 61 84 - Email: contact@isiburger.sn</p>
    <p>Facture générée le {{ now()->format('d/m/Y à H:i') }}</p>
</div>
</body>

</html>

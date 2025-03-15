<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Burger extends Model
{

    use HasFactory;

    protected $fillable = ['nom', 'prix', 'image', 'description', 'stock'];

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_burger')->withPivot('quantite');
    }
}

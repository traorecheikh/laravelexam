<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Burger extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ['nom', 'prix', 'image', 'description', 'stock'];

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_burger')->withPivot('quantite');
    }
}

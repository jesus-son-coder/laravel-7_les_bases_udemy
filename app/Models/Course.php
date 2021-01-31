<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Nouvelle propriété pour établir la liaison entre Course et Category :
    public function category()
    {
        // Cas d'une Relation ManyToOne :
        // ------------------------------
        // Un Cours appartient à une (seule) Category
        return $this->belongsTo('App\Models\Category');
    }

    // Le Propriétaire du Cours :
    public function user()
    {
        // Cas d'une Relation ManyToOne :
        return $this->belongsTo('App\Models\User');
    }

    public function sections()
    {
        return $this->hasMany('App\Models\Section');
    }

}

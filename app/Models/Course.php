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
        // Cas d'une Relation OneToMany :
        // ------------------------------
        // Un Cours appartient à une (seule) Category
        return $this->belongsTo('App\Models\Category');
    }

}

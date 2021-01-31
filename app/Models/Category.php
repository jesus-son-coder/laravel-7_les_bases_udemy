<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // Nouvelle propriété pour établir la liaison entre Category et Course :
    // courses : "s" au pluriel car on peut avoir 1 ou plusieurs courses.
    public function courses()
    {
        // Cas d'une Relation ManyToOne :
        // ------------------------------
        // Permet de récupérer tous les Courses appartenant à une Category :
        return $this->hasMany('App\Models\Course');
    }
}

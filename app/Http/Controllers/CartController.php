<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function store($id)
    {
        $course = Course::find($id);

        // Ajouter un Produit au Panier :
        $add = \Cart::session(Auth::user()->id)->add([
            'id' => $course->id,
            'name' => $course->title,
            'price' => $course->price,
            'quantity' => 1,
            /*
            'attributes' => [
                'slug' => $course->slug,
                // etc..
            ], */
            'associatedModel' => $course
        ]);

        return redirect()->route('cart.index');
    }

    public function delete($id)
    {
        \Cart::session(Auth::user()->id)->remove($id);

        return redirect()->route('cart.index')->with('success','Cours supprimé de vorte panier !');
    }
}

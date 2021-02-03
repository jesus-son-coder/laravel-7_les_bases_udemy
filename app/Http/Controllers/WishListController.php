<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function store($id)
    {
        $course = Course::find($id);

        // Ajouter un Produit à la WishList :
        $add = \Cart::session(Auth::user()->id . '_wishlist')->add([
            'id' => $course->id,
            'name' => $course->title,
            'price' => $course->price,
            'quantity' => 1,
            'associatedModel' => $course
        ]);

        return redirect()->route('cart.index');
    }

    public function destroy($id)
    {
        \Cart::session(Auth::user()->id . '_wishlist')->remove($id);

        return redirect()->route('cart.index')->with('success','Cours supprimé de votre liste de souhait !');

    }

    public function toCart($id)
    {

    }

    public function toWishList($id)
    {

    }

}

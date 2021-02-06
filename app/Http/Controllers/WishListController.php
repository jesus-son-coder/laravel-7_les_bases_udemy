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
        $wishlist = \Cart::session(Auth::user()->id . '_wishlist')->add([
            'id' => $course->id,
            'name' => $course->title,
            'price' => $course->price,
            'quantity' => 1,
            'associatedModel' => $course
        ]);

        return redirect()->route('cart.index')->with('success','Cours ajouté à votre liste de souhait !');
    }

    public function destroy($id)
    {
        \Cart::session(Auth::user()->id . '_wishlist')->remove($id);

        return redirect()->route('cart.index')->with('success','Cours supprimé de votre liste de souhait !');

    }

    public function toCart($id)
    {
        $course = Course::find($id);

        $wishlist = \Cart::session(Auth::user()->id . '_wishlist');
        $wishlist->remove($id);

        $cart = \Cart::session(Auth::user()->id);
        $cart->add([
            'id' => $course->id,
            'name' => $course->title,
            'price' => $course->price,
            'quantity' => 1,
            'associatedModel' => $course
        ]);

        return redirect()->route('cart.index')->with('success','Cours transféré dans votre panier !');
    }

    public function toWishList($id)
    {
        $course = Course::find($id);

        $cart = \Cart::session(Auth::user()->id);
        $cart->remove($id);

        $wishlist = \Cart::session(Auth::user()->id . '_wishlist');
        $wishlist->add([
            'id' => $course->id,
            'name' => $course->title,
            'price' => $course->price,
            'quantity' => 1,
            'associatedModel' => $course
        ]);

        return redirect()->route('cart.index')->with('success','Cours transféré dans votre liste de souhait !');
    }

}

@extends('layouts.app')


@section('content')

    <div class="container mb-4 pb-5">
        <p>{{ count(\Cart::session(Auth::user()->id)->getContent()) }} cours dans le panier</p>
        <div class="jumbotron">
            @if(count(\Cart::session(Auth::user()->id)->getContent()) > 0)
                <div class="d-flex justify-content-center">
                    <a href="{{ route('cart.clear') }}" class="btn btn-block btn-light w-25 mb-5">
                        Vider le panier
                    </a>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            {{-- Déboguer et voir le contenu du Panier lorsqu'un article est rajouté : --}}
                            {{--    {{ dd(\Cart::session(Auth::user()->id)->getContent()) }}   --}}
                            {{-- fin déboguage --}}
                            <table class="table table-striped">
                                <tbody>
                                @foreach(\Cart::session(Auth::user()->id)->getContent() as $produit)

                                    @php
                                        $tax = \Cart::getTotal() / 10;
                                        $roundedTax = round($tax, 2);
                                    @endphp

                                    <tr>

                                        <td>
                                            <a href="{{ route('courses.show', $produit->model->slug) }}">
                                            <img class="cart-img" src="/storage/courses/{{ $produit->model->user_id }}/{{ $produit->model->image }}" /></a>
                                        </td>
                                        <td>
                                            <a href="{{ route('courses.show', $produit->model->slug) }}">
                                                <p>
                                                    <b>{{ $produit->name }}</b>
                                                </p>
                                            </a>
                                            <p>
                                                Par {{ $produit->model->user->name }}
                                            </p>
                                        </td>

                                        <td class="text-left">
                                            <small><a class="btn border" href="{{ route('cart.delete', $produit->id) }}">Supprimer</a></small><br>
                                            <small><a class="btn border" href="#">Enregistrer pour plus tard</a></small><br>
                                            <small><a class="btn border" href="#">Ajouter à la liste de souhaits</a></small>
                                        </td>
                                        <td class="text-right">{{ $produit->price }} €</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Sous-total</td>
                                    <td class="text-right">{{ \Cart::getSubtotal() }} €</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Taxe</td>
                                    <td class="text-right">{{ $roundedTax }} €</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td class="text-right"><strong>{{ \Cart::getTotal() + $roundedTax }} €</strong></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="col mb-2">
                        <div class="row">
                            <div class="col-sm-12  col-md-6">
                                <a href="{{ route('courses.index') }}" class="btn btn-block btn-light">Continuer vos achats</a href="#">
                            </div>
                            <div class="col-sm-12 col-md-6 text-right">
                                <a href="#" class="btn btn-lg btn-block btn-success text-uppercase">Payer</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-cart text-center">
                    <i class="fas fa-shopping-cart fa-8x"></i>
                    <h4 class="my-5">Votre panier est vide. Continuez vos achats et trouvez un cours !</h4>
                    <a href="{{ route('courses.index') }}" class="primary-btn">
                        Continuez vos achats
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>

        {{--
        <div class="save-for-later jumbotron my-5">
            <h3>Enregistré pour plus tard</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td><img class="cart-img" src="https://blog.hyperiondev.com/wp-content/uploads/2019/02/Blog-Types-of-Web-Dev.jpg" /> </td>
                        <td><p><b>Titre du cours</b></p><p>Par Nom du formateur</p></td>
                        <td class="text-left">
                            <small><a class="btn border" href="#">Supprimer</a></small><br>
                            <small><a class="btn border" href="#">Ajouter au panier</a></small>
                        </td>
                        <td class="text-right">19,99 €</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        --}}

        <div class="wish-list jumbotron pt-3">
            <h3 class="my-3">Récemment ajouté à la liste de souhaits</h3>
            @if(count(\Cart::session(Auth::user()->id . '_wishlist')->getContent()) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        @foreach(\Cart::session(Auth::user()->id . '_wishlist')->getContent() as $produit)
                            <tr>
                                <td>
                                    <a href="{{ route('courses.show', $produit->model->slug) }}">
                                        <img class="cart-img" src="/storage/courses/{{ $produit->model->user_id }}/{{ $produit->model->image }}" />
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('courses.show', $produit->model->slug) }}">
                                        <p><b>{{ $produit->name }}</b></p>
                                    </a>
                                    <p>Par {{ $produit->model->user->name }}</p>
                                </td>
                                <td class="text-left">
                                    <small><a class="btn border" href="{{ route('wishlist.destroy', $produit->id) }}">Supprimer</a></small><br>
                                    <small><a class="btn border" href="#">Ajouter au panier</a></small>
                                </td>
                                <td class="text-right">{{ $produit->price }} €</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection

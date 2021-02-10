@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <form id="payment-form" class="jumbotron row contact_form" action="{{ route('checkout.charge') }}" method="POST">
                    @csrf
                    <div id="card-element" class="col-12">
                        <!-- Elements will create input elements here -->
                    </div>

                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert" class="col-12"></div>

                    <button type="submit" class="primary-btn my-3">Procéder au paiement</button>
                </form>
                <div class="order-details my-5">
                    <h3>Détails de la commande</h3>
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td><img class="cart-img" src="https://blog.hyperiondev.com/wp-content/uploads/2019/02/Blog-Types-of-Web-Dev.jpg" /> </td>
                            <td><p><b>Titre du cours</b></p><p>Par Nom du formateur</p></td>
                            <td class="text-right">19,99 €</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Résumé
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p>Prix d'origine:</p>
                            <p>19,99</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>Taxe:</p>
                            <p>3,00</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p><b>Prix total:</b></p>
                            <p><b>22,99</b></p>
                        </div>
                        <small class="card-text">Comme exigé par la loi, Elearning prélève les taxes sur les transactions applicables aux achats réalisés dans certaines juridictions fiscales.
                            En validant votre achat, vous acceptez ces Conditions générales d'utilisation.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('stripe')
<script>
    $(document).ready(function() {

        var stripe = Stripe('pk_test_51IGt6uAxJKVVgKTjsgHEAblOIWr3p7KYx06o49Pmc5xon4aJKoPfhBKosvCVBA4rt4d65H2uvwDHdW258TFOzHTl00EzAG0PMA');
        var elements = stripe.elements();
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        var card = elements.create("card", { style: style});
        card.mount('#card-element');

        // Gestion des erreurs :
        card.addEventListener('change', ({error}) => {
            const displayError = document.getElementById('card-errors');
            if(error) {
                displayError.classList.add('alert', 'alert-warning');
                displayError.textContent = error.message;
            } else {
                displayError.classList.remove('alert', 'alert-warning');
                displayError.textContent = '';
            }
        });


        // var checkoutButton = document.getElementById('submit');

        /*
        checkoutButton.addEventListener('click', function(event) {

            event.preventDefault();

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: 'Herve Seka'
                    }
                }
            }).then(function(result) {
                if(result.error) {
                    console.log(result.error.message);
                } else {
                    if(result.paymentIntent.status === 'succeeded') {

                    }
                }
            })
        }); */

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if(result.error) {
                    // Inform the user if there was an error :
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server :
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server :
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // submit the form :
            form.submit();

        }


    })
</script>
@stop

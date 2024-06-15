<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        .panel-title {
            display: inline;
            font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
</head>
<body>

<div class="container">

    <br><br><br><br>
    <div class="row">

        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">

                <div class="panel-body">
                    <h1>Stripe Payment Gateway</h1>

                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                          data-cc-on-file="false"   data-stripe-publishable-key="pk_test_51PRuTTCXXYQusRyCNejR2lr7ib2pUSCivnRTQANVD6QrFBVnwALbfxvyQ7Oxwv3luGUdbBTXUb4NIRNooIIjFPfm001QV2JvsD" id="payment-form">
                        @csrf

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input
                                    class='form-control' size='4' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                                                                class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                                                type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg btn-block" type="submit">Price: ($100) </button><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var $form = $("#payment-form");

        $form.submit(function (event) {
            event.preventDefault();

            var cardNumber = $('.card-number').val();
            var cvc = $('.card-cvc').val();
            var expMonth = $('.card-expiry-month').val();
            var expYear = $('.card-expiry-year').val();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.card.createToken({
                number: cardNumber,
                cvc: cvc,
                exp_month: expMonth,
                exp_year: expYear
            }, stripeResponseHandler);
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                // Show the errors on the form
                $('.payment-errors').text(response.error.message);
                $('.payment-errors').removeClass('hidden');
                $form.find('button').prop('disabled', false);
            } else {
                // Token was created successfully, inject the token into the form
                var token = response.id;
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // Submit the form
                $form.get(0).submit();
            }
        }
    });
</script>

</body>
</html>

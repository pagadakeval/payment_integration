<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    <title>Document</title>
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}
        
        input[type=text],input[type=number],input[type=email], select, textarea {
          width: 100%;
          padding: 12px;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
          margin-top: 6px;
          margin-bottom: 16px;
          resize: vertical;
        }
        
        input[type=submit] {
          background-color: #04AA6D;
          color: white;
          padding: 12px 20px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }
        
        input[type=submit]:hover {
          background-color: #45a049;
        }
        
        .container {
          border-radius: 5px;
          background-color: #f2f2f2;
          padding: 20px;
        }
        </style>
</head>
<body>


    <body>
        <div class="alert">

        </div>
        
        <div class="container">
          <form action="{{route('payment')}}" method="post" id="form">
            @csrf
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" class="fname" placeholder="Your name..">
        
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" class="lname" placeholder="Your last name..">
        
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="email" placeholder="Your Email..">

            <label for="email">Number</label>
            <input type="number" id="number" name="number" class="number" placeholder="Your number..">

            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount" class="amount" placeholder="">
            
            <div id="paypal-button-container"></div>
          </form>
        </div>
        
        
        </body>
    {{-- <div id="paypal-button-container"></div> --}}


{{-- stripe payment --}}
{{-- <script src="https://js.stripe.com/v3/"></script>
<script>

    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var card = elements.create('card', {hidePostalCode: true,
        style: style});
    card.mount('#card-element');
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    cardButton.addEventListener('click', async (e) => {
        e.preventDefault();
        console.log("attempting");
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: { name: cardHolderName.value }
                }
            }
            );
        if (error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            paymentMethodHandler(setupIntent.payment_method);
        }
    });
    function paymentMethodHandler(payment_method) {
        var form = document.getElementById('subscribe-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AeGGP9Rpj-cCJAjM-HVMSxY8waR8fyxXDktzvjyy3WqKHIPPkYrRUiY8d8dds-GvnRteUQbrtK58Ji8F"></script>
<script>

    paypal.Buttons({
        
        onClick() {
            
        },

        createOrder: function(data, actions) {
    var amount = $('.amount').val();
    if (!amount || isNaN(parseFloat(amount))) {
        console.error('Invalid amount value');
        return;
    }

    return actions.order.create({
        purchase_units: [{
            amount: {
                value: parseFloat(amount).toFixed(2),
                currency: 'USD',
            }
        }],

        redirect_urls: {
        cancel_url: "http://127.0.0.1:8000/dashboard"
    },
        application_context: {
            shipping_preference: 'NO_SHIPPING'
        }
    });
},


            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    //alert('Transaction '+ transaction.status + ': ' + transaction.id + '');

                    var fname = $('.fname').val();
                    var lname = $('.lname').val();
                    var number = $('.number').val();
                    var email = $('.email').val();
                    var amount = $('.amount').val();
                    $.ajax({
                        url: '/data',
                        method: 'post',
                        data: {
                            'amount': amount,
                            'fname': fname,
                            'lname':lname,
                            'number': number,
                            'email': email,
                            '_token':'{{ csrf_token() }}',
                            'payment_id': transaction.id
                        },
                        success: function(data) {
                            if(data.message){
                                //window.location.href='/dashboard';
                                $('#form')[0].reset();
                                $('.alert').text(data.message).addClass('alert-success');
                                
                            }
                             
           
                        }
                    })
                });
            },
        }).render('#paypal-button-container');
    </script>
    
</body>
</html>
@extends('layouts.app')
@section('content')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            height: 100vh;
            margin: 10px;
        }
        .main-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #card-element {
            margin-bottom: 16px;
        }

        #card-errors {
            color: #dc3545;
            margin-bottom: 16px;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .card-header {
            background-color: #28a745;
            color: #292424;
        }

        .subscription-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .billing-info {
            margin-bottom: 1rem;
        }

        #coupon-link {
            color: #007bff;
            cursor: pointer;
        }

        #coupon-link:hover {
            text-decoration: underline;
        }

        #coupon-input-container {
            margin-top: 1rem;
        }

        .shift {
            float: inline-end;
        }

        .discount {
            background: linear-gradient(to right, #198754 0%, #1976ffa3 100%);
            border: 1px solid #adb5bd;
            /*background-color: #28a745;*/
            color: white;
            border-radius: 10px;
            display: inline-block;
            padding: 2px 5px;
        }

        input {
            /* background-color: #fbffe7; */
            border-radius: 10px;
        }
    </style>

    <div class="container mt-2">
        <button class="btn btn-outline-primary btn-sm mb-2" onclick="goBack()"><i class="fa-solid fa-less-than mx-1"></i>Go
            Back</button>
        @if (!$hasSubscription)
            <div class="row">
                <!-- Left Card -->
                <div class="col-md-6">
                    <div class="card border-light-subtle   w-auto">
                        <div class="card-body">
                            <h1 class="card-header">Choose a plan</h1>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('subscribe') }}" class="main-form" method="post" id="subscription-form">
                                @csrf
                                <input type="hidden" name="selected_price_id" id="selected-price-id"
                                    value="price_1OU5PgSIHMYlbzPN7SCWtDWl">
                                <!-- Card Details -->
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                                <!-- Additional Billing Information (customize as needed) -->
                                <div class="icons mb-2">
                                    <img src="{{ asset('assets/images/mastercard.png') }}" width="30">
                                    <img src="{{ asset('assets/images/visa.png') }}" width="30">
                                </div>
                                <label for="name">Name on Card</label>
                                <input type="text" id="name" name="name" required>
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required>
                                <label for="billing_address_line1">Address line 1</label>
                                <input type="text" id="billing_address_line1" name="billing_address_line1" required>
                                <label for="billing_address_line2">Address line 2</label>
                                <input type="text" id="billing_address_line2" name="billing_address_line2" required>
                                <label for="billing_city">City</label>
                                <input type="City" id="billing_city" name="billing_city" required>
                                <label for="billing_state">State</label>
                                <input type="State" id="billing_state" name="billing_state" required>
                                <label for="billing_postal_code">Zip Code</label>
                                <input type="text" id="billing_postal_code" name="billing_postal_code" required>
                                <label for="zip">Select country</label>
                                <div>
                                    <select name="billing_country" class="form-control" id="billing_country">
                                        <option value="IN" selected="selected">India</option>
                                        @foreach (json_decode(file_get_contents(url('assets/countries.json'))) as $code => $country)
                                            <option value='{{ $code }}'>{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" id="save_card_btn" class="btn btn-dark mt-2">Save Card
                                    Details</button>
                                {{-- @if (Auth::user()->userDetail->stripe_subscription_id)
                                    <button type="button" class="btn btn-danger btn-sm mt-1" id="cancel-btn"
                                        onclick="cancelSubscription()">Cancel Subscription</button>
                                @endif --}}
                        </div>
                    </div>
                </div>

                <!-- Right Card -->
                <div class="col-md-6">
                    <div class="card border-light-subtle  ">
                        <div class="card-body" style="text-align: center;">
                            <!-- Content for the right card -->
                            <h5 class="card-header mb-2"><strong>Your Subscription</strong></h5>
                            <div class="card-title mb-2" id="subscription-plan">Linkodart Pro starter (monthly)</div>
                            <div id="billing-info">
                                3 USD per month, billed monthly
                            </div><br>
                            <div>
                                <div class="mb-1 mt-1 text-sm discount">Save 33% on premium plan</div>
                            </div>
                            <p class="card-text mb-2 mt-2">
                                <strong>Due Date:</strong> <span id="due-date">{{$user->userDetail->end_date}}</span><br>
                                <strong>Payable Amount:</strong> <span id="payable-amount">$3.00</span><br>
                            </p>
                            <!-- Subscribe Button -->
                            <button type="button" class="btn btn-dark btn-sm" id="premium-btn"
                                onclick="changePlan('premium')">Premium</button>
                            <button type="button" class="btn btn-dark btn-sm" id="pro-btn"
                                onclick="changePlan('pro')">Pro</button>
                            @push('scripts')
                                <script>
                                    // Assuming you pass the subscription ID from your controller to the view
                                    var subscriptionId = {{ $user->stripe_subscription_id ?? 'null' }};
                                    // console.log(subscriptionId);
                                </script>
                            @endpush
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <!-- Left Card -->
                <!--<div class="col-md-6">-->
                <!--    <div class="card border-light-subtle   w-auto">-->
                <!--        <div class="card-body">-->
                <!--            <h1 class="card-header"><strong>Your Plan Details</strong></h1>-->

                <!--            <h2 class="card-title mt-3">Billing Details</h2>-->
                <!--            <form action="" method="post" class="main-form" id="subscription-form">-->
                <!--                @csrf-->
                <!--                <label for="email">Email Address</label>-->
                <!--                <input type="email" id="email" value="{{ Auth::user()->email }}" name="email"-->
                <!--                    required>-->
                <!--                <label for="zip">Zip Code</label>-->
                <!--                <input type="text" id="zip" name="zip" required>-->
                <!--                <label for="zip">Select country</label>-->
                <!--                <div>-->
                <!--                    <select name="country" class="form-control" id="country">-->
                <!--                        <option value="IN" selected="selected">India</option>-->
                <!--                        @foreach (json_decode(file_get_contents(url('assets/countries.json'))) as $code => $country)-->
                <!--                            <option value='{{ $code }}'>{{ $country }}</option>-->
                <!--                        @endforeach-->
                <!--                    </select>-->
                <!--                </div>-->
                <!--            </form>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                <!-- Right Card -->
                @if($user->userDetail->user_type == 'pro')
                    <div class="col-md-6">
                        <div class="card border-light-subtle  ">
                            <div class="card-header">
                                <h5 class="mb-2"><strong>Active Subscription</strong></h5>
                            </div>
                            <div class="card-body" style="text-align: center;">
                                <div class="card-title mb-2" id="subscription-plan">Linkodart Pro starter (monthly)</div>
                                <div id="billing-info">
                                    3 USD per month, billed monthly
                                </div><br>
                                <p class="card-text mb-2 mt-2">
                                    <strong>Due Date:</strong> <span id="due-date">{{$user->userDetail->end_date}}</span><br>
                                    <strong>Amount Payable:</strong> <span id="payable-amount">$3.00</span><br>
                                <!--<div class="mt-2">-->
                                <!--    <a href="#" id="coupon-link" onclick="toggleCouponInput()">Add coupon code</a>-->
                                <!--    <span id="coupon-input-container" style="display: none;">-->
                                <!--        <input type="text" id="coupon-input" placeholder="Enter coupon code">-->
                                <!--        <button class="btn btn-secondary btn-sm" onclick="applyCoupon()">Apply</button>-->
                                <!--    </span>-->
                                <!--</div>-->
                                <!--</p>-->
                                <!-- Subscribe Button -->
                                <!--<button type="button" class="btn btn-dark btn-sm" id="premium-btn"-->
                                <!--    onclick="changePlan('premium')">Premium</button>-->
                                <!--<button type="button" class="btn btn-dark btn-sm" id="pro-btn"-->
                                <!--    onclick="changePlan('pro')">Pro</button>-->
                                @push('scripts')
                                    <script>
                                        // Assuming you pass the subscription ID from your controller to the view
                                        var subscriptionId = {{ $user->stripe_subscription_id ?? 'null' }};
                                        console.log(subscriptionId);
                                    </script>
                                @endpush
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-6">
                        <div class="card border-light-subtle  ">
                            <div class="card-header">
                                <h5 class="mb-2"><strong>Active Subscription</strong></h5>
                            </div>
                            <div class="card-body" style="text-align: center;">
                                <div class="card-title mb-2" id="subscription-plan">Linkodart Premium starter (monthly)</div>
                                <div id="billing-info">
                                    32 USD per month, billed monthly
                                </div><br>
                                <p class="card-text mb-2 mt-2">
                                    <strong>Due Date:</strong> <span id="due-date">{{$user->userDetail->end_date}}</span><br>
                                    <strong>Amount Payable:</strong> <span id="payable-amount">$32.00</span><br>
                                <!--<div class="mt-2">-->
                                <!--    <a href="#" id="coupon-link" onclick="toggleCouponInput()">Add coupon code</a>-->
                                <!--    <span id="coupon-input-container" style="display: none;">-->
                                <!--        <input type="text" id="coupon-input" placeholder="Enter coupon code">-->
                                <!--        <button class="btn btn-secondary btn-sm" onclick="applyCoupon()">Apply</button>-->
                                <!--    </span>-->
                                <!--</div>-->
                                <!--</p>-->
                                <!-- Subscribe Button -->
                                <!--<button type="button" class="btn btn-dark btn-sm" id="premium-btn"-->
                                <!--    onclick="changePlan('premium')">Premium</button>-->
                                <!--<button type="button" class="btn btn-dark btn-sm" id="pro-btn"-->
                                <!--    onclick="changePlan('pro')">Pro</button>-->
                                @push('scripts')
                                    <script>
                                        // Assuming you pass the subscription ID from your controller to the view
                                        var subscriptionId = {{ $user->stripe_subscription_id ?? 'null' }};
                                        console.log(subscriptionId);
                                    </script>
                                @endpush
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>


    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Create a Stripe instance with your publishable key
        var stripe = Stripe(
            'XXXXXXXXXXXXXXXXX'
        );
        // Create an instance of Elements
        var elements = stripe.elements();
        
        // Check if the element with id 'card-element' exists
        var cardElement = document.querySelector('#card-element');
        
        if (cardElement) {
            // If the element exists, create and mount the card
            var card = elements.create('card');
            card.mount('#card-element');
        
            // Handle real-time validation errors on the Card Element
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        }

        // Handle form submission
        var stripeForm = document.getElementById('save_card_btn');
        if(stripeForm){
            stripeForm.addEventListener('click', function(event) {
                console.log('test000', stripeForm);
                event.preventDefault();
                // Disable the submit button to prevent multiple submissions
                document.querySelector('button').disabled = true;
                // Create a PaymentMethod
                stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                    billing_details: {
                        name: document.getElementById('name').value,
                        email: document.getElementById('email').value,
                    },
                }).then(function(result) {
                    if (result.error) {
                        // Show error to your customer (e.g., insufficient funds, card declined, etc.)
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the PaymentMethod ID to your server
                        stripeTokenHandler(result.paymentMethod);
                    }
                });
            });
            // Submit the form with the PaymentMethod ID to your server
            function stripeTokenHandler(paymentMethod) {
                console.log('test1', paymentMethod);
                var stripeForm = document.getElementById('subscription-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'paymentMethod');
                hiddenInput.setAttribute('value', paymentMethod.id);
                stripeForm.appendChild(hiddenInput);
                // Submit the form
                stripeForm.submit();
            }
        }
        
        
        // Get query parameters from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const planParam = urlParams.get('plan');
        // Change plan based on the query parameter
        if (planParam === 'premium') {
            changePlan('premium');
        } else if (planParam === 'pro') {
            changePlan('pro');
        }

        // For changing plan
        function changePlan(plan) {
            var subscriptionPlan = document.getElementById('subscription-plan');
            var billingInfo = document.getElementById('billing-info');
            var premiumBtn = document.getElementById('premium-btn');
            var proBtn = document.getElementById('pro-btn');
            var dueDate = document.getElementById('due-date');
            var payableAmount = document.getElementById('payable-amount');
            var priceId = (plan === 'premium') ? 'price_1OU5YlSIHMYlbzPNSBDn1Zit' : 'price_1OU5PgSIHMYlbzPN7SCWtDWl';
            // console.log(priceId);
            document.getElementById('selected-price-id').value = priceId;
            // document.getElementById('subscription-form').action = "{{ route('subscribe') }}" + "?price_id=" + priceId;

            if (plan === 'premium') {
                subscriptionPlan.textContent = 'Linkodart Premium starter (monthly)';
                billingInfo.textContent = '32 USD per month, billed monthly';
                premiumBtn.disabled = true;
                proBtn.disabled = false;
                dueDate.textContent = '{{$user->userDetail->end_date}}';
                payableAmount.textContent = '$32.00';
            } else if (plan === 'pro') {
                subscriptionPlan.textContent = 'Linkodart Pro starter (monthly)';
                billingInfo.textContent = '3 USD per month, billed monthly';
                premiumBtn.disabled = false;
                proBtn.disabled = true;
                dueDate.textContent = '{{$user->userDetail->end_date}}';
                payableAmount.textContent = '$3.00';
            }
        }

        // Display coupon span
        function toggleCouponInput() {
            var couponInputContainer = document.getElementById('coupon-input-container');
            couponInputContainer.style.display = couponInputContainer.style.display === 'none' ? 'inline' : 'none';
        }

        // Warns if the Card details field is empty
        // var startTrialBtn = document.getElementById('start-trial-btn');
        // var nameInput = document.getElementById('name');
        // startTrialBtn.addEventListener('click', function() {
        //     if (nameInput.value.trim() === '') {
        //         alert('Fill out "The Card Details');
        //     } else {
        //         nameInput.focus();
        //     }
        // });

        // Cancel Subscription
        function cancelSubscription() {

            // Assuming you pass the subscription ID from your controller to the view
            var subscriptionId = "{{ Auth::user()->stripe_subscription_id ?? 'null' }}";
            console.log(subscriptionId);
            if (subscriptionId) {
                fetch('/cancel-subscription', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            subscription_id: subscriptionId
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle dark
                        console.log(data);
                        alert('Subscription canceled darkfully');
                    })
                    .catch(error => {
                        // Handle error
                        console.error(error);
                        alert('Error canceling subscription');
                    });
            } else {
                console.log('No subscription ID available');
            }
        }

        // Back button
        function goBack() {
            window.history.back();
        }
    </script>
@endsection

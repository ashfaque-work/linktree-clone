<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Subscription;
use Stripe\PaymentIntent;
use Stripe\Exception\InvalidRequestException;
use App\Models\UserDetail;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $user = $request->user();
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentMethodId = $request->input('paymentMethod');
        $selectedPriceId = $request->input('selected_price_id');
        
        $billingAddress = [
            'city' => $request->input('billing_city'),
            'country' => $request->input('billing_country'),
            'line1' => $request->input('billing_address_line1'),
            'line2' => $request->input('billing_address_line2'),
            'postal_code' => $request->input('billing_postal_code'),
            'state' => $request->input('billing_state'),
        ];
        
        $shippingAddress = $billingAddress;
        
        // Check if the user already has a Stripe customer ID
        if ($user->userDetail == null || !($user->userDetail->stripe_customer_id)) {
            // If not, create a new customer in Stripe
            $stripeCustomer = Customer::create([
                'email' => $user->email,
                'name' => $user->name,
                'payment_method' => $paymentMethodId, 
                
                'address' => $billingAddress,
                
                'shipping' => [
                    'name' => $user->name,
                    'address' => $shippingAddress,
                ],

            ]);
            
            // Save the Stripe customer ID to the user model
            $userDetail = UserDetail::where('user_id', $user->id)->first();

            if (!$userDetail) {
                UserDetail::create([
                    'user_id' => $user->id,
                    'stripe_customer_id' => $stripeCustomer->id,
                ]);
            } else {
                $user->userDetail()->update([
                    'stripe_customer_id' => $stripeCustomer->id,
                    'user_type' => 'pro',
                ]);
            }
        } else {
            // If the payment method is not already attached, attach it
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $user->userDetail->stripe_customer_id]);
        }
        $user = User::find($user->id);
        $customerId = $user->userDetail->stripe_customer_id;
        $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

        // Subscription
        $subscription = Subscription::create([
            'customer' => $customerId,
            'items' => [

                ['price' => $selectedPriceId],

            ],
            'default_payment_method' => $paymentMethod,
            'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
            'expand' => ['latest_invoice.payment_intent'],
        ]);
        $subscriptionItems = $subscription->items;
        $subscriptionItem = $subscriptionItems->first();
        $priceId = $subscriptionItem->price->id;
        $stripePrice = \Stripe\Price::retrieve($priceId);
        $subscriptionAmount = $stripePrice->unit_amount;
    
        if ($subscriptionAmount > 300) {
            $user->userDetail()->update(['user_type' => 'premium']);
        } else {
            $user->userDetail()->update(['user_type' => 'pro']);
        }
        $user->userDetail()->update([
            'stripe_subscription_id' => $subscription->id,
            'start_date' => date('Y-m-d', $subscription->start_date),
            'end_date' => date('Y-m-d', $subscription->current_period_end),
            'status' => $subscription->status,
            ]);
        $invoice = $subscription->latest_invoice;
        $paymentIntent = $invoice->payment_intent;

        try {
            // Confirm the PaymentIntent to charge the customer
            $paymentIntent->confirm();
        } catch (\Exception $e) {
            // Handle the exception (e.g., log error, show an error message)
            return redirect()->back()->with('error', 'Failed to confirm payment. Please try again.');
        }
        
        $subscriptionId = $subscription->id;
        $clientSecret = $subscription->latest_invoice->payment_intent->client_secret;

        return view('confirmPayment', compact('user','subscriptionId', 'clientSecret'));
    }
    public function proSubscribe(Request $request)
    {
        // Set your Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve necessary input data
        $paymentMethodId = $request->input('paymentMethod');
        $selectedPriceId = $request->input('selected_price_id');
        $enteredNumber = $request->session()->get('enteredNumber');
        $user = $request->user();

        try {
            // Check if the user already has a Stripe customer ID
            if (!$user->userDetail || !$user->userDetail->stripe_customer_id) {
                // If not, create a new customer in Stripe
                $stripeCustomer = Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'payment_method' => $paymentMethodId,
                ]);

                // Save the Stripe customer ID to the user model
                if (!$user->userDetail) {
                    UserDetail::create([
                        'user_id' => $user->id,
                        'stripe_customer_id' => $stripeCustomer->id,
                    ]);
                } else {
                    $user->userDetail()->update(['stripe_customer_id' => $stripeCustomer->id]);
                }
            } else {
                // If the payment method is not already attached, attach it
                $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
                $paymentMethod->attach(['customer' => $user->userDetail->stripe_customer_id]);
            }

            // Retrieve the user with the updated details
            $user = User::find($user->id);
            $customerId = $user->userDetail->stripe_customer_id;

            // Create a subscription
            $subscription = Subscription::create([
                'customer' => $customerId,
                'items' => [
                    [
                        'price' => $selectedPriceId,
                        'quantity' => $enteredNumber,
                    ],
                ],
                'payment_behavior' => 'default_incomplete',
            ]);

            // Update the user detail with the subscription ID
            $user->userDetail()->update(['stripe_subscription_id' => $subscription->id]);

            return redirect()->route('dashboard')->with('success', 'Subscription created successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., log the error, redirect with an error message)
            return redirect()->route('dashboard')->with('error', 'Error creating subscription: ' . $e->getMessage());
        }
    }

    public function plans()
    {
        $user = auth()->user();
        $userDetails = $user->userDetail;
        return view('payments.payment', compact('user', 'userDetails'));
    }

    public function payment()
    {
        $user = auth()->user();
        $userDetails = $user->userDetail;
        if ($userDetails != null) {
            $hasSubscription = $userDetails->stripe_subscription_id ? true : false;
            return view('payments.subscribe', compact('user', 'userDetails', 'hasSubscription'));
        } else {
            $hasSubscription = false;
            return view('payments.subscribe', compact('user', 'userDetails', 'hasSubscription'));
        }

    }
    public function proPayment()
    {
        $user = auth()->user();
        $userDetails = Auth::user()->userDetail;
        if ($userDetails != null) {
            $hasSubscription = $userDetails->stripe_subscription_id ? true : false;
            return view('proSubscribe', compact('user', 'hasSubscription'));
        } else {
            $hasSubscription = false;
            return view('proSubscribe', compact('user', 'hasSubscription'));
        }

    }
    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();
        try {

            Stripe::setApiKey(config('services.stripe.secret'));
            $stripeCustomerId = $user->stripe_customer_id;
            $subscriptionId = $user->stripe_subscription_id;
            // dd($subscriptionId);
            $subscription = Subscription::retrieve($subscriptionId);
            $subscription->cancel();
            // You can also update your local database to reflect the canceled subscription if needed.

            return response()->json(['message' => 'subscription cancelled successfully', 'subscriptionId' => $subscriptionId], 200);
        } catch (InvalidRequestException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function enteredNumber(Request $request)
    {
        $enteredNumber = $request->input('enteredNumber');
        $request->session()->put('enteredNumber', $enteredNumber);
    }

    public function updateSubscription(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve the current subscription
        $subscriptionId = Auth::user()->userDetail->stripe_subscription_id;
        $temp = $request->session()->get('enteredNumber');
        $subscription = Subscription::retrieve($subscriptionId);
        $subscriptionItem = $subscription->items->data[0];

        // Access the subscription_item_id
        $subscriptionItemId = $subscriptionItem->id;

        try {
            // Update the subscription quantity
            $stripe = Subscription::update(
                $subscriptionId,
                ['items' => [['id' => $subscriptionItemId, 'quantity' => $temp]]]
            );

            // Redirect or return a response as needed
            return redirect()->back()->with('success', 'Subscription updated successfully');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle the exception, log it, or return an error response
            return redirect()->back()->with('error', 'Error updating subscription: ' . $e->getMessage());
        }
    }

}

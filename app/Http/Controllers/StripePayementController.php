<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Session;
use Stripe;
use Stripe\Stripe as StripeStripe;

class StripePayementController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
       

        Stripe\Stripe::setApiKey("sk_test_51PRuTTCXXYQusRyCXnbHKApmCjE4VmkdSIiZAx7wpY40lI9ph1IGtTFxJX5TlhfiukMWNbfVGAVlx0dzyNAfxJRg00l6S4HoWL");
        
        Stripe\Charge::create([
            'amount' => 100*100,
            'currency'=>"usd",
            'source'=> $request->stripeToken,
            'description' =>'Test payment from louhab abderazzak'
        ]);
        Session::flash('success','Payment has been successfully');
        return back();
    }


}
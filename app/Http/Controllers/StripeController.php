<?php

namespace App\Http\Controllers;
require_once('../vendor/autoload.php');

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use \Stripe\Stripe;

class StripeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function showSubscription() {
        $user = Auth::user();
        
        return view('dashboard', [
            'user'=>$user,
            'intent' => $user->createSetupIntent(),
        ]);
    }

    public function singleCharge(Request $request){
        // return $request->all();
        
        $amount = $request->amount*100;
        $paymentmethod = $request->payment_method;
         
        $user = auth()->user();
        
        $user->createOrGetStripeCustomer();
       
        $paymentmethod = $user->addPaymentMethod($paymentmethod);
        // dd( $paymentmethod->id);
        // $user->charge($amount, $paymentmethod->id);

        
        $returnUrl ='http://127.0.0.1:8000/data';
        $user->charge($amount, $paymentmethod->id, [
            'return_url' => $returnUrl,
        ]);

        return redirect('data');
        

    }
}

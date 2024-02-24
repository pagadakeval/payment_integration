<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\Payment;

class paypalController extends Controller
{
   function payment(Request $request){
    $data = new Payment;
    $data->fname = $request->fname;
    $data->lname = $request->lname;
    $data->email = $request->email;
    $data->number = $request->number;
    $data->amount = $request->amount;
    $data->save();

    return redirect('data')->with(["message"=>"Payment Successfully"]);
   }
}
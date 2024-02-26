<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
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
    $data->payment_id = $request->payment_id;
    $data->token = $request->_token;
    $data->save();
   
      return response()->json(["message"=>"Payment Successfully"]);
   //  return redirect()->with(["message"=>"Payment Successfully"]);

   }
}
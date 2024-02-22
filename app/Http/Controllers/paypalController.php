<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class paypalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_SECRET')
            )
        );
    }

    public function createPayment(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        
        $amount = new Amount();
        $amount->setCurrency('USD')
        ->setTotal(intval($request->amount)); // Assuming you're receiving the amount from a form or API call

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Payment description');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('success'))
            ->setCancelUrl(route('cancel'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

            try {
                $payment->create($this->apiContext);
                $approvalLink = $payment->getApprovalLink();
                
                // Check if the approval link is a string
                if (is_string($approvalLink)) {
                    // Redirect the user to the approval link
                    return redirect($approvalLink);
                } else {
                    // Handle the response accordingly (e.g., display an error message)
                    return redirect()->back()->withErrors(['message' => 'Invalid approval link.']);
                }
            } catch (\Exception $ex) {
                // Handle error
                return redirect()->back()->withErrors(['message' => 'Payment creation failed.']);
            }
    }
}

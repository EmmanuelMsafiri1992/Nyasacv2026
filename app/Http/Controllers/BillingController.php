<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Omnipay\Omnipay;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        
        $user                    = $request->user();
        $packages                = Package::all();
        $subscribed              = $user->subscribed();
        
        $currency_code           = config('rb.CURRENCY_CODE');
        $currency_symbol         = config('rb.CURRENCY_SYMBOL');
        $subscription_title      = null;
        $subscription_expires_in = 0;
        

        if ($subscribed) {
            $subscription_title      = $user->package->title;
            $subscription_expires_in = $user->package_ends_at->diffInDays();
        }
       

        return view('billing.index', compact(
            'packages',
            'subscribed',
            'currency_code',
            'currency_symbol',
            'subscription_title',
            'subscription_expires_in'
        ));
    }

    public function package(Request $request, Package $package)
    {
        $currency_code   = config('rb.CURRENCY_CODE');
        $currency_symbol = config('rb.CURRENCY_SYMBOL');

        return view('billing.package', compact(
            'package',
            'currency_code',
            'currency_symbol'
        ));
    }

    public function activate(Request $request, Package $package)
    {
        // SECURITY: This method should NOT activate subscriptions without payment
        // Redirect to billing page with payment gateway selection
        return redirect()->route('billing.package', $package)
            ->with('error', __('Please select a payment method to complete your subscription.'));
    }

    public function gateway_purchase(Request $request, Package $package, $gateway)
    {
        // Create a payment
        $payment = Payment::create([
            'user_id'    => $request->user()->id,
            'package_id' => $package->id,
            'gateway'    => $gateway,
            'total'      => $package->price,
            'is_paid'    => false,
            'currency'   => config('rb.CURRENCY_CODE'),
        ]);
        

        
        switch ($gateway) {

            case 'stripe':

                $request->validate([
                    'stripeToken'     => 'required',
                    'stripeTokenType' => 'required',
                    'stripeEmail'     => 'required|email',
                ]);

                $stripe = Omnipay::create('Stripe_PaymentIntents');

                $stripe->initialize([
                    'apiKey' => setting('STRIPE_SECRET'),
                ]);

                try {

                    // Send purchase request
                    $response = $stripe->purchase([
                        'token'         => $request->stripeToken,
                        'transactionId' => $payment->id,
                        'amount'        => $payment->total,
                        'currency'      => $payment->currency,
                        'description'   => $package->title,
                        'cancelUrl'     => route('gateway.cancel', $payment),
                        'returnUrl'     => route('gateway.return', $payment),
                        'notifyUrl'     => route('gateway.notify', $payment),
                        'confirm'       => true,
                    ])->send();

                    // Process response
                    if ($response->isRedirect()) {

                        // Redirect to offsite payment gateway
                        return $response->redirect();

                    } elseif ($response->isSuccessful()) {

                        // Payment was successful
                        $payment->reference = $response->getTransactionReference();
                        $payment->is_paid   = true;
                        $payment->save();

                        // Update subscription
                        $payment->applyPayment();

                        return redirect()->route('billing.index')
                            ->with('success', __('Thank you for your payment! Your subscription is activated successfully.'));

                    } else {

                        // Payment failed
                        return redirect()->route('billing.package', $package)
                            ->with('error', $response->getMessage());

                    }

                } catch (\Exception $e) {
                    return redirect()->route('billing.package', $package)
                        ->with('error', __('Sorry, there was an error processing your payment. Please try again later.'));
                }

                break;

            case 'paypal':

                $paypal = Omnipay::create('PayPal_Rest');

                $paypal->initialize([
                    'clientId'  => setting('PAYPAL_CLIENT_ID'),
                    'secret'    => setting('PAYPAL_SECRET'),
                    'testMode'  => setting('PAYPAL_SANDBOX', false),
                ]);

                try {

                    // Send purchase request with brand name in experience profile
                    $response = $paypal->purchase([
                        'transactionId' => $payment->id,
                        'amount'        => $payment->total,
                        'currency'      => $payment->currency,
                        'description'   => $package->title,
                        'cancelUrl'     => route('gateway.cancel', $payment),
                        'returnUrl'     => route('gateway.return', $payment),
                        'notifyUrl'     => route('gateway.notify', $payment),
                        'brandName'     => config('app.name'),
                        'applicationContext' => [
                            'brand_name' => config('app.name'),
                            'shipping_preference' => 'NO_SHIPPING',
                        ],
                    ])->send();
                    
                    // Process response
                    if ($response->isRedirect()) {

                        // Redirect to offsite payment gateway
                        return $response->redirect();

                    } elseif ($response->isSuccessful()) {
                        
                        // Payment was successful
                        $payment->reference = $response->getTransactionReference();
                        $payment->is_paid   = true;
                        
                        $payment->save();

                        // Update subscription
                        $payment->applyPayment();

                        return redirect()->route('billing.index')
                            ->with('success', __('Thank you for your payment! Your subscription is activated successfully.'));

                    } else {

                        // Payment failed
                        return redirect()->route('billing.package', $package)
                            ->with('error', $response->getMessage());

                    }

                } catch (\Exception $e) {

                    return redirect()->route('billing.package', $package)
                        ->with('error', __('Sorry, there was an error processing your payment. Please try again later.'));
                }

                break;

            default:

                return redirect()->route('billing.package', $package)
                    ->with('error', __('Unsupported payment gateway'));

                break;
        }
    }

    public function gateway_return(Request $request, Payment $payment)
    {
        
        switch ($payment->gateway) {

            case 'stripe':

                $request->validate([
                    'payment_intent' => 'required',
                ]);

                $stripe = Omnipay::create('Stripe_PaymentIntents');

                $stripe->initialize([
                    'apiKey' => setting('STRIPE_SECRET'),
                ]);

                try {

                    // Complete purchase
                    $response = $stripe->completePurchase([
                        'paymentIntentReference' => $request->payment_intent,
                        'returnUrl'              => route('gateway.return', $payment),
                    ])->send();

                    // Process response
                    if ($response->isSuccessful()) {

                        // Payment was successful
                        $payment->reference = $response->getTransactionReference();
                        $payment->is_paid   = true;
                        $payment->save();

                        // Update subscription
                        $payment->applyPayment();

                        return redirect()->route('billing.index')
                            ->with('success', __('Thank you for your payment! Your subscription is activated successfully.'));

                    } else {

                        // Payment failed
                        return redirect()->route('billing.package', $payment->package)
                            ->with('error', $response->getMessage());

                    }

                } catch (\Exception $e) {

                    return redirect()->route('billing.package', $payment->package)
                        ->with('error', __('Sorry, there was an error processing your payment. Please try again later.'));
                }

                break;

            case 'paypal':

                $paypal = Omnipay::create('PayPal_Rest');

                $paypal->initialize([
                    'clientId'  => setting('PAYPAL_CLIENT_ID'),
                    'secret'    => setting('PAYPAL_SECRET'),
                    'testMode'  => setting('PAYPAL_SANDBOX', false),
                    'brandName' => config('app.name'),
                ]);
                
                
                try {

                    // Complete purchase
                    
                    
                    $response = $paypal->completePurchase([
                        'transactionReference' => $request->paymentId,
                        'PayerID' =>$request->PayerID,
                        'transactionId' => $payment->id,
                        'amount'        => $payment->total,
                        'currency'      => $payment->currency,
                        'description'   => $payment->package->title,
                        'cancelUrl'     => route('gateway.cancel', $payment),
                        'returnUrl'     => route('gateway.return', $payment),
                        'notifyUrl'     => route('gateway.notify', $payment),
                    ])->send();
                   
                    // Process responseq
                    if ($response->isSuccessful()) {

                        // Payment was successful
                        $payment->reference = $response->getTransactionReference();
                        $payment->is_paid   = true;
                        $payment->save();

                        // Update subscription
                        $payment->applyPayment();

                        return redirect()->route('billing.index')
                            ->with('success', __('Thank you for your payment! Your subscription is activated successfully.'));

                    } else {

                        // Payment failed
                        return redirect()->route('billing.package', $payment->package)
                            ->with('error', $response->getMessage());

                    }

                } catch (\Exception $e) {
                    return redirect()->route('billing.package', $payment->package)
                        ->with('error', __('Sorry, there was an error processing your payment. Please try again later.'));
                }

                break;

            default:

                return redirect()->route('billing.package', $payment->package)
                    ->with('error', __('Unsupported payment gateway'));

                break;
        }

    }

    public function gateway_cancel(Request $request, Payment $payment)
    {
        return redirect()->route('billing.index')
            ->with('error', __('You have cancelled your recent payment.'));

    }

    public function gateway_notify(Request $request, Payment $payment)
    {

    }

    public function cancel(Request $request)
    {
        $request->user()->update([
            'package_id'      => null,
            'package_ends_at' => null,
        ]);

        return redirect()->route('billing.index')
            ->with('success', __('You have cancelled your subscription.'));
    }

    public function payments(Request $request, Payment $payment)
    {
        $stats = DB::table('payments')
            ->selectRaw('count(id) AS total, is_paid')
            ->whereRaw('created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()')
            ->groupBy(DB::Raw('DAY(created_at), is_paid'))
            ->orderBy(DB::Raw('DAY(created_at)'))
            ->get();

        $chart['paid']     = $stats->where('is_paid', '1')->pluck('total')->join(',');
        $chart['not_paid'] = $stats->where('is_paid', '0')->pluck('total')->join(',');

        $data = Payment::with([
            'user',
            'package',
        ])->orderByDesc('id')->paginate(10);

        return view('billing.payments', compact(
            'data',
            'chart'
        ));
    }
}

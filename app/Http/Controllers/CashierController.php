<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('payments', [
            'intent' => Auth::user()->createSetupIntent(),
        ]);
    }

    public function savePaymentMethod(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->payment_method;
        $user->createOrGetStripeCustomer();
        if ($user->hasDefaultPaymentMethod()) {
            $user->addPaymentMethod($paymentMethod);
        } else $user->updateDefaultPaymentMethod($paymentMethod);

        return redirect(route('saved-card'))
            ->with('status', 'New card added successfully !');
    }

    public function cardDetails()
    {
        $user = Auth::user();
        $default = $user->defaultPaymentMethod();
        $data = $user->paymentMethods();
        return view('saved-cards', ['data' => $data, 'default' => $default]);
    }

    public function removePaymentMethod($id)
    {
        $user = Auth::user();
        $user->findPaymentMethod($id)->delete();
        return redirect(route('saved-card'))
            ->with('cardstatus', 'Card successfully removed !');
    }

    public function changeDefaultMethod($id)
    {
        $user = Auth::user();
        $user->updateDefaultPaymentMethod($id);
        return redirect(route('saved-card'))
            ->with('status', 'Changed default payment method !');
    }

    public function addBalance()
    {
        return view('recharge');
    }

    public function chargeUser($amount)
    {
        $user = Auth::user();
        if ($user->hasDefaultPaymentMethod()) {
            $paymentMethod = $user->defaultPaymentMethod();
            $stripeCharge = $user->charge(
                $amount * 100,
                $paymentMethod->id,
                [
                    'off_session' => true,
                    'description' => 'Account Recharge',
                ]
            );
            return redirect(route('add-balance'))
                ->with('status', 'Payment succeeded by ' . $stripeCharge->id);
        } else {
            return redirect(route('payments'))
                ->with('status', 'No default payment method found, please enter card details and go through the process again !');
        }
    }
}

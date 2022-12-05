<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }
    public function index()
    {
        $accounts = $this->stripe->accounts->allExternalAccounts(
            Auth::user()->stripeAccountId(),
            ['object' => 'bank_account']
        );
        return view('bank-accounts', ['external_accounts' => $accounts]);
    }

    public function addAccount()
    {
        return view('add-account');
    }

    public function storeAccount(Request $request)
    {
        $this->stripe->accounts->createExternalAccount(
            Auth::user()->stripeAccountId(),
            [
                'external_account' => [
                    "object" => "bank_account",
                    "country" => "US",
                    "currency" => "usd",
                    "account_holder_name" => $request->holder_name,
                    "account_number" => $request->account_no,
                    "routing_number" => $request->routing_no,
                ]
            ]
        );
        return Redirect::route('bank-accounts');
    }

    public function setDefault(Request $request)
    {
        dd($request->account);
    }
}

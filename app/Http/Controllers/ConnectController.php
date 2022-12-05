<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class ConnectController extends Controller
{
    public function getUserDetails()
    {
        $user = User::find(Auth::id())->firstOrFail();
        return view('user-listing', ['user' => $user]);
    }

    public function handleBoardingRedirect($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        // Redirect to dashboard if onboarding is already completed
        if ($user->hasStripeAccountId() && $user->hasCompletedOnboarding()) {
            return $this->transferPage($user->uuid);
        }

        // Fetch account if already exists or create new express account
        $user->createOrGetStripeAccount('custom', [
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true]
            ],
            ['tos_acceptance' => [
                'date' => Carbon::now()->timestamp,
                'ip' => \Request::ip()
            ]]
        ]);

        // Redirect to Stripe account onboarding, with both urls
        return $user->redirectToAccountOnboarding(
            URL::to('/transfer/' . $user->uuid), // return_url
            URL::to('/onboard/' . $user->uuid) // refresh_url
        );
    }

    public function transferPage($uuid)
    {
        return view('transfer', ['uuid' => $uuid]);
    }

    public function transferPayoutAmount(Request $request)
    {
        $user = User::where('uuid', $request->uuid)->firstOrFail();
        $user->transferToStripeAccount(($request->amount) * 100);
        // $user->payoutStripeAccount(500, Date::now()->addWeek());
        return Redirect::route('transfer', ['uuid' => $request->uuid])
            ->with('status', 'Successfully transfered the amount of $' . $request->amount);
    }
}

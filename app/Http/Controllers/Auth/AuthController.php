<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToKeycloak()
    {
        // Keycloak below v3.2 requires no scopes to be set. 
        // Later versions require the openid scope for all requests.
        // return Socialite::driver('keycloak')->scopes(['openid'])->redirect();
        // dd(Socialite::driver('keycloak'));
        return Socialite::driver('keycloak')->redirect();
    }

    public function handleKeycloakCallback()
    {
        $user = Socialite::driver('keycloak')->user();

        dd($user);

        // this line will be needed if you have an exist Eloquent database User
        // then you can user user data gotten from keycloak to query such table
        // and proceed
        $existingUser = User::where('email', $user->email)->first();

        // ... your desire implementation comes here

        return redirect()->intended('/whatever-your-route-look-like');
    }

    public function logout()
    {
        // Logout of your app.
        // Auth::logout();

        // The user will not be redirected back.
        return redirect(Socialite::driver('keycloak')->getLogoutUrl());

        // The URL the user is redirected to after logout.
        // $redirectUri = Config::get('app.url');

        // // Keycloak v18+ does support a post_logout_redirect_uri in combination with a
        // // client_id or an id_token_hint parameter or both of them.
        // // NOTE: You will need to set valid post logout redirect URI in Keycloak.
        // return redirect(Socialite::driver('keycloak')->getLogoutUrl($redirectUri, env('KEYCLOAK_CLIENT_ID')));
        // return redirect(Socialite::driver('keycloak')->getLogoutUrl($redirectUri, null, 'YOUR_ID_TOKEN_HINT'));
        // return redirect(Socialite::driver('keycloak')->getLogoutUrl($redirectUri, env('KEYCLOAK_CLIENT_ID'), 'YOUR_ID_TOKEN_HINT'));

        // // You may add additional allowed parameters as listed in
        // // https://openid.net/specs/openid-connect-rpinitiated-1_0.html
        // return redirect(Socialite::driver('keycloak')->getLogoutUrl($redirectUri, CLIENT_ID, null, ['state' => '...'], ['ui_locales' => 'de-DE']));

        // // Keycloak before v18 does support a redirect URL
        // // to redirect back to Keycloak.
        // return redirect(Socialite::driver('keycloak')->getLogoutUrl($redirectUri));
    }
}

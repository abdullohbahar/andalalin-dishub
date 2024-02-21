<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\V3\KeycloakService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToKeycloak()
    {
        // Keycloak below v3.2 requires no scopes to be set. 
        // Later versions require the openid scope for all requests.
        // return Socialite::driver('keycloak')->scopes(['openid'])->redirect();
        return Socialite::driver('keycloak')->redirect('http://localhost:8000/callback');
    }

    public function handleKeycloakCallback(Request $request)
    {
        $user = Socialite::driver('keycloak')->user();

        $email = $user->email;

        // cek user exist or not
        $existingUser = User::where('email', $email)->first();

        if ($existingUser == null) {
            User::create([
                'username' => $user->name ?? 'default',
                'email' => $user->email,
                'role' => '-'
            ]);
        }

        $user = User::where('email', $user->email)->first();

        // Otentikasi user tanpa password
        Auth::login($user);

        $request->session()->regenerate();

        return to_route('admin.dashboard');
    }

    public function logout()
    {
        // Logout of your app.
        Auth::logout();

        // The URL the user is redirected to after logout.
        $redirectUri = env('KEYCLOAK_REDIRECT_URI');

        return redirect(Socialite::driver('keycloak')->getLogoutUrl($redirectUri, env('KEYCLOAK_CLIENT_ID')));
    }
}

<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function index()
    {
        return view('guest.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => ':attribute harus diisi',
            'password.required' => ':attribute harus diisi',
        ]);

        $auth = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($auth)) {
            $request->session()->regenerate();

            switch (Auth::user()->role) {
                case 'pemohon':
                    return redirect()->route('pemohon.dashboard');
                    break;
                case 'admin':
                    return redirect()->route('admin.dashboard');
                    break;
                case 'penilai1':
                    return redirect()->route('penilai.dashboard');
                    break;
                case 'penilai2':
                    return redirect()->route('penilai.dashboard');
                    break;
                case 'penilai3':
                    return redirect()->route('penilai.dashboard');
                    break;
                case 'kasi':
                    return redirect()->route('kasi.dashboard');
                    break;
                case 'kabid':
                    return redirect()->route('kabid.dashboard');
                    break;
                case 'kadis':
                    return redirect()->route('kadis.dashboard');
                    break;
                default:
                    return redirect()->back()->with('error', 'Username atau password salah');
            }
        }

        return redirect()->back()->with([
            'error' => 'username atau password salah',
            'email' => $request->email
        ]);
    }
}

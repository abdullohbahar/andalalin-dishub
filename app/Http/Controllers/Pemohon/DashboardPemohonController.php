<?php

namespace App\Http\Controllers\Pemohon;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardPemohonController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $user = User::with('hasOneProfile')->where('id', $userID)->first();

        if ($user->hasOneProfile == null) {
            $hasProfile = false;
        } else {
            $hasProfile = true;
        }

        $data = [
            'active' => 'dashboard',
            'hasProfile' => $hasProfile
        ];

        return view('pemohon.dashboard.index', $data);
    }
}

<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PilihRoleController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role != '-') {
            return to_route('pemohon.dashboard');
        }

        return view('role.index');
    }

    public function store($role)
    {
        $userID = auth()->user()->id;
        $existRole = auth()->user()->role;

        if ($existRole == '-') {
            User::where('id', $userID)->update([
                'role' => $role
            ]);
        }

        return to_route('pemohon.dashboard');
    }
}

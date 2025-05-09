<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KontruksiController extends Controller
{
    public function index($pengajuanID)
    {
        $data = [
            'active' => 'pengajuan',
        ];

        // selanjutnya membuat template isi tahap operasional

        return view('admin.pengajuan.manajemen-rekayasa.index', $data);
    }
}

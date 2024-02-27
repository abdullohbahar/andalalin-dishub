<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('belongsToJenisRencana', 'hasOneDataPemohon', 'belongsToUser.hasOneProfile')
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            'active' => 'pengajuan-permohonan',
            'pengajuans' => $pengajuans
        ];

        return view('admin.pengajuan.index', $data);
    }
}

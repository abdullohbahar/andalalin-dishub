<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('belongsToJenisRencana', 'hasOneDataPemohon', 'belongsToUser.hasOneProfile')
            ->where('status', 'menunggu konfirmasi admin')
            ->orderBy('updated_at', 'desc')
            ->get();

        $pengajuanDirevisi = Pengajuan::with('belongsToJenisRencana', 'hasOneDataPemohon', 'belongsToUser.hasOneProfile')
            ->where('status', 'telah direvisi')
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            'active' => 'dashboard',
            'pengajuans' => $pengajuans,
            'pengajuanDirevisi' => $pengajuanDirevisi
        ];

        return view('admin.dashboard.index', $data);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuratKesanggupanAdminController extends Controller
{
    public function menungguSuratKesanggupan($pengajuanID)
    {
        $data = [
            'active' => 'pengajuan'
        ];

        return view('admin.pengajuan.surat-kesanggupan.menunggu-surat-kesanggupan', $data);
    }
}

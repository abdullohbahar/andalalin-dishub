<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;
use App\Models\TemplateBeritaAcara;
use Illuminate\Http\Request;

class TemplateBeritaAcaraController extends Controller
{
    public function index($jenisRencanaPembangunanID)
    {
        $jenisRencana = JenisRencanaPembangunan::with('hasOneTemplateBeritaAcara')->where('id', $jenisRencanaPembangunanID)->first();

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'jenisRencana' => $jenisRencana
        ];

        return view('admin.jenis-rencana-pembangunan.template-berita-acara.index', $data);
    }

    public function update(Request $request, $jenisRencanaPembangunanID)
    {
        TemplateBeritaAcara::updateorcreate([
            'jenis_rencana_id' => $jenisRencanaPembangunanID
        ], [
            'body' => $request->body
        ]);

        return redirect()->back()->with('success', 'Berhasil disimpan');
    }
}

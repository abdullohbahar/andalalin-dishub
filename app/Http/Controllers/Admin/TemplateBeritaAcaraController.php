<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;
use App\Models\SubJenisRencanaPembangunan;
use App\Models\SubSubJenisRencana;
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

    public function indexSub($subJenisRencanaPembangunanID, $jenis)
    {
        if ($jenis == 'sub') {
            $jenisRencana = SubJenisRencanaPembangunan::with('hasOneTemplateBeritaAcara')->where('id', $subJenisRencanaPembangunanID)->first();
        } else {
            $jenisRencana = SubSubJenisRencana::with('hasOneTemplateBeritaAcara')->where('id', $subJenisRencanaPembangunanID)->first();
        }

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'jenisRencana' => $jenisRencana,
            'jenis' => $jenis,
        ];

        return view('admin.jenis-rencana-pembangunan.template-berita-acara.index', $data);
    }

    public function update(Request $request, $jenisRencanaPembangunanID)
    {
        $updateData = [];

        if ($request->jenis === 'sub' || $request->jenis === 'subsub') {
            $updateData['parent_id'] = $jenisRencanaPembangunanID;
            $updateData['tipe'] = $request->jenis;
        } else {
            $updateData['jenis_rencana_id'] = $jenisRencanaPembangunanID;
        }

        TemplateBeritaAcara::updateorcreate($updateData, [
            'body' => $request->body,
            'tipe' => $request->jenis ?? '',
        ]);

        return redirect()->back()->with('success', 'Berhasil disimpan');
    }
}

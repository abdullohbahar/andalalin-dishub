<?php

namespace App\Http\Controllers\Pemohon\Ajax;

use App\Http\Controllers\Controller;
use App\Models\SubJenisRencanaPembangunan;
use Illuminate\Http\Request;

class ShowSubJenisRencana extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($idJenis)
    {
        $subJenisRencana = SubJenisRencanaPembangunan::where('jenis_rencana_id', $idJenis)->select('id', 'jenis_rencana_id', 'nama')->get();

        $data = [
            'data' => $subJenisRencana
        ];

        return response()->json($data, 201);
    }
}

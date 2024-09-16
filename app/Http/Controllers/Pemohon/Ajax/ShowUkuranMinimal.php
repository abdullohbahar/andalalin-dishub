<?php

namespace App\Http\Controllers\Pemohon\Ajax;

use App\Http\Controllers\Controller;
use App\Models\SubJenisRencanaPembangunan;
use App\Models\UkuranMinimal;
use Illuminate\Http\Request;

class ShowUkuranMinimal extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($jenis, $idSubJenisRencana)
    {
        // lakukan pengecekan apakah sub jenis rencana memiliki sub sub tidak
        // jika memiliki tampilkan sub sub nya terlebih dahulu
        if ($jenis == 'sub') {
            $ukuranMinimal = UkuranMinimal::where('sub_jenis_rencana_id', $idSubJenisRencana)->get();
            return $ukuranMinimal;
        } else {
            $ukuranMinimal = UkuranMinimal::where('sub_sub_jenis_rencana_id', $idSubJenisRencana)->get();

            $data = [
                'data' => $ukuranMinimal
            ];

            return response()->json($data, 201);
        }
    }
}

<?php

namespace App\Http\Controllers\Pemohon\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubJenisRencanaPembangunan;

class ShowSubSubJenisRencana extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($idSubJenisRencana)
    {
        // lakukan pengecekan apakah sub jenis rencana memiliki sub sub tidak
        // jika memiliki tampilkan sub sub nya terlebih dahulu
        $subJenisRencana = SubJenisRencanaPembangunan::with('hasManySubSubJenis', 'hasManyUkuranMinimal')->findOrFail($idSubJenisRencana);

        if (count($subJenisRencana->hasManySubSubJenis) != 0) {
            $data = [
                'data' => $subJenisRencana->hasManySubSubJenis,
                'has_sub_sub' => true,
            ];
        } else {
            $showUkuranMinimalController = new ShowUkuranMinimal();
            $ukuranMinimal = $showUkuranMinimalController->__invoke('sub', $idSubJenisRencana);

            $data = [
                'data' => $subJenisRencana->hasManyUkuranMinimal,
                'has_sub_sub' => false,
                'data_ukuran_minimal' => $ukuranMinimal,
            ];
        }

        return response()->json($data, 201);
    }
}

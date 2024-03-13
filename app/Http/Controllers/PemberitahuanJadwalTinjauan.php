<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemberitahuanJadwalTinjauan extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($pengajuanID)
    {
        return view('document-template.jadwal-tinjauan');
    }
}

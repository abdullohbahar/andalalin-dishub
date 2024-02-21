<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilePemohonController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $data = [
            'active' => 'profile',
            'userID' => $userID
        ];

        return view('pemohon.profile.index', $data);
    }

    public function edit($id)
    {
        $user = User::with('hasOneProfile')->findorfail($id);

        $data = [
            'active' => 'profile',
            'user' => $user
        ];

        return view('pemohon.profile.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'no_ktp' => 'required',
            'no_telepon' => 'required',
            'alamat' => 'required',
            'file_ktp' => 'required',
            'file_sertifikat_andalalin' => 'required',
            'file_cv' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_ktp.required' => 'Nomor KTP harus diisi',
            'no_telepon.required' => 'Nomor Telepon harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'file_ktp.required' => 'KTP harus diisi',
            'file_sertifikat_andalalin.required' => 'Sertifikat harus diisi',
            'file_cv.required' => 'CV harus diisi',
        ]);

        if ($request->hasFile('file_ktp')) {
            $file = $request->file('file_ktp');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/ktp', $filename);
            $fileKtp = $filename;
        } else {
            $fileKtp = null;
        }

        if ($request->hasFile('file_sertifikat_andalalin')) {
            $file = $request->file('file_sertifikat_andalalin');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/sertifikat-andalalin', $filename);
            $fileSertifikatAndalalin = $filename;
        } else {
            $fileSertifikatAndalalin = null;
        }

        if ($request->hasFile('file_cv')) {
            $file = $request->file('file_cv');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/cv', $filename);
            $fileCv = $filename;
        } else {
            $fileCv = null;
        }

        $data = [
            'user_id' => $id,
            'nama' => $request->nama,
            'no_ktp' => $request->no_ktp,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'file_ktp' => $fileKtp,
            'file_sertifikat_andalalin' => $fileSertifikatAndalalin,
            'file_cv' => $fileCv,
        ];

        Profile::updateorcreate([
            'user_id' => $id,
        ], $data);

        return to_route('pemohon.profile')->with('success', 'Berhasil Mengisi Profile');
    }
}

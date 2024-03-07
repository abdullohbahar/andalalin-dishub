<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8'
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_ktp.required' => 'Nomor KTP harus diisi',
            'no_telepon.required' => 'Nomor Telepon harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'file_ktp.required' => 'KTP harus diisi',
        ]);

        $role = auth()->user()->role;

        if ($role == 'konsultan') {
            $request->validate([
                'no_sertifikat' => 'required',
                'masa_berlaku_sertifikat' => 'required',
                'tingkatan' => 'required',
                'sekolah_terakhir' => 'required',
                'file_sertifikat' => 'required',
                'file_ijazah_terakhir' => 'required',
            ], [
                'no_sertifikat.required' => 'Nomor sertifikat harus diisi',
                'masa_berlaku_sertifikat.required' => 'Masa berlaku sertifikat harus diisi',
                'tingkat.required' => 'Tingkatan harus diisi',
                'sekolah_terakhir.required' => 'Sekolah terakhir harus diisi',
                'file_sertifikat.required' => 'Sertifikat harus diisi',
                'file_ijazah.required' => 'Ijazah Sertifikat harus diisi',
            ]);
        } else if ($role == 'pemohon') {
            $request->validate([
                'file_sertifikat_andalalin' => 'required',
                'file_cv' => 'required',
            ], [
                'file_sertifikat_andalalin.required' => 'Sertifikat andalalin harus diisi',
                'file_cv.required' => 'CV harus diisi',
            ]);
        } else if ($role == 'pemakarsa') {
            $request->validate([
                'file_sk_kepala_dinas' => 'required',
            ], [
                'file_sk_kepala_dinas.required' => 'SK Kepala Dinas harus diisi',
            ]);
        }

        $data = [
            'user_id' => $id,
            'nama' => $request->nama,
            'no_ktp' => $request->no_ktp,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'no_sertifikat' => $request->no_sertifikat,
            'masa_berlaku_sertifikat' => $request->masa_berlaku_sertifikat,
            'tingkatan' => $request->tingkatan,
            'sekolah_terakhir' => $request->sekolah_terakhir,
        ];

        if ($request->hasFile('file_ktp')) {
            $file = $request->file('file_ktp');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/ktp', $filename);
            $data['file_ktp'] = $filename;
        }

        if ($request->hasFile('file_sertifikat_andalalin')) {
            $file = $request->file('file_sertifikat_andalalin');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/sertifikat-andalalin', $filename);
            $data['file_sertifikat_andalalin'] = $filename;
        }

        if ($request->hasFile('file_cv')) {
            $file = $request->file('file_cv');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/cv', $filename);
            $data['file_cv'] = $filename;
        }

        if ($request->hasFile('file_sk_kepala_dinas')) {
            $file = $request->file('file_sk_kepala_dinas');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/sk-kepala-dinas', $filename);
            $data['file_sk_kepala_dinas'] = $filename;
        }

        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/sertifikat', $filename);
            $data['file_sertifikat'] = $filename;
        }

        if ($request->hasFile('file_ijazah_terakhir')) {
            $file = $request->file('file_ijazah_terakhir');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/file-uploads/ijazah-terakhir', $filename);
            $data['file_ijazah_terakhir'] = $filename;
        }

        Profile::updateorcreate([
            'user_id' => $id,
        ], $data);

        $dataUser = [
            'username' => $request->username
        ];

        if ($request->password) {
            $dataUser['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($dataUser);

        return to_route('pemohon.profile')->with('success', 'Berhasil Mengisi Profile');
    }
}

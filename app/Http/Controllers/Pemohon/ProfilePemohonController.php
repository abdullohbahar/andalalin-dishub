<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\TandaTangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilePemohonController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $user = User::with('hasOneProfile')->findorfail($userID);

        $data = [
            'active' => 'profile',
            'userID' => $userID,
            'user' => $user
        ];

        return view('pemohon.profile.index', $data);
    }

    public function edit($id)
    {
        $user = User::with('hasOneProfile', 'hasOneTtd')->findorfail($id);

        $data = [
            'active' => 'profile',
            'user' => $user
        ];

        return view('pemohon.profile.edit', $data);
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('file_ktp')) {
            $response = $this->handleFileUpload($request, 'file_ktp', 'ktp', $id);
            if ($response !== null) return $response;
        }

        if ($request->hasFile('file_sertifikat_andalalin')) {
            $response = $this->handleFileUpload($request, 'file_sertifikat_andalalin', 'sertifikat-andalalin', $id);
            if ($response !== null) return $response;
        }

        if ($request->hasFile('file_cv')) {
            $response = $this->handleFileUpload($request, 'file_cv', 'cv', $id);
            if ($response !== null) return $response;
        }

        if ($request->hasFile('file_sk_kepala_dinas')) {
            $response = $this->handleFileUpload($request, 'file_sk_kepala_dinas', 'sk-kepala-dinas', $id);
            if ($response !== null) return $response;
        }

        if ($request->hasFile('file_sertifikat')) {
            $response = $this->handleFileUpload($request, 'file_sertifikat', 'sertifikat', $id);
            if ($response !== null) return $response;
        }

        if ($request->hasFile('file_ijazah_terakhir')) {
            $response = $this->handleFileUpload($request, 'file_ijazah_terakhir', 'ijazah-terakhir', $id);
            if ($response !== null) return $response;
        }

        if ($request->hasFile('foto_profile')) {
            $response = $this->handleFileUpload($request, 'foto_profile', 'foto-profile', $id);
            if ($response !== null) return $response;
        }

        $user = User::with('hasOneTtd', 'hasOneProfile')->where('id', $id)->first();

        if ($request->hasFile('signed')) {
            $request->validate([
                'signed' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Sesuaikan aturan validasi
            ]);

            // Mengambil file dan mengubahnya ke base64
            $image = $request->file('signed');
            $imageBase64 = base64_encode(file_get_contents($image->getRealPath()));

            // Menyimpan data base64 ke dalam tabel TandaTangan
            TandaTangan::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'ttd' => 'data:image/png;base64, ' . $imageBase64,
            ]);

            return to_route('profile')->with('success', 'Berhasil Upload Tanda Tangan');
        }

        $request->validate([
            'nama' => 'required',
            'no_ktp' => 'required',
            'no_telepon' => 'required',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_ktp.required' => 'Nomor KTP harus diisi',
            'no_telepon.required' => 'Nomor Telepon harus diisi',
            'alamat.required' => 'Alamat harus diisi',
        ]);

        $role = auth()->user()->role;

        // if ($role == 'penilai1' || $role == 'penilai2' || $role == 'penilai3') {
        //     if (!$user->hasOneTtd) {
        //         $request->validate([
        //             'signed' => 'required'
        //         ], [
        //             'signed.required' => 'Tanda Tangan harus diisi'
        //         ]);
        //     }
        // }

        if ($user->username != $request->username) {
            $request->validate([
                'username' => 'required|unique:users,username',
            ], [
                'username.required' => 'Username harus diisi',
                'username.unique' => 'Username sudah dipakai'
            ]);
        }

        if ($request->password != null || $user->username == null) {
            $request->validate([
                'password' => 'required|confirmed|min:10|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ], [
                'password.required' => 'password harus diisi',
                'password.confirmed' => 'password tidak sama',
                'password.min' => 'password minimal 10 karakter',
                'password.regex' => 'password harus terdiri dari huruf besar, huruf kecil, dan angka',
            ]);
        }

        $role = auth()->user()->role;

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

        return to_route('profile')->with('success', 'Berhasil Mengisi Profile');
    }

    function handleFileUpload($request, $fieldName, $folderName, $id)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('file-uploads/' . $folderName, $filename, 'public');

            Profile::updateorcreate([
                'user_id' => $id,
            ], [
                $fieldName => $filename
            ]);

            return to_route('edit.profile', $id)->with('success', 'Berhasil Mengupload Dokumen');
        } else {
            return to_route('edit.profile', $id)->with('failed', 'Gagal Mengupload Dokumen');
        }

        return null;
    }
}

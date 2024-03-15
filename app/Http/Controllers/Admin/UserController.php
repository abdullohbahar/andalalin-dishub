<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = User::with([
                'hasOneProfile' => function ($query) {
                    $query->orderBy('nama', 'asc');
                }
            ])
                // ->where('role', '!=', 'admin')
                ->get();

            // return $query;
            return Datatables::of($query)
                ->addColumn('nama', function ($item) {
                    return $item->hasOneProfile?->nama;
                })
                ->addColumn('no_telepon', function ($item) {
                    return $item->hasOneProfile?->no_telepon;
                })
                // ->addColumn('aksi', function ($item) {
                //     return "
                //         <button data-id='$item->id' id='delete' data-nama='$item->username' class='btn btn-danger btn-sm'>Hapus</button>
                //     ";
                // })
                ->rawColumns(['nama', 'no_telepon'])
                ->make();
        }

        $data = [
            'active' => 'user'
        ];

        return view('admin.user.index', $data);
    }

    public function create()
    {
        $data = [
            'active' => 'user'
        ];

        return view('admin.user.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:10|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'role' => 'required'
        ], [
            'nama.required' => 'nama harus diisi',
            'username.required' => 'username harus diisi',
            'username.unique' => 'username sudah dipakai',
            'email.required' => 'email harus diisi',
            'email.email' => 'email tidak valid',
            'email.unique' => 'email sudah dipakai',
            'password.required' => 'password harus diisi',
            'password.confirmed' => 'password tidak sama',
            'password.min' => 'password minimal 10 karakter',
            'password.regex' => 'password harus terdiri dari huruf besar, huruf kecil, dan angka',
            'role.required' => 'role harus diisi'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        Profile::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'no_ktp' => '-',
            'alamat' => '-',
            'no_telepon' => '-',
        ]);

        return to_route('admin.user.index')->with('success', 'Berhasil menambah user');
    }

    public function destroy($id)
    {
        try {
            Profile::where('user_id', $id)->delete();
            User::findOrFail($id)->delete();

            // Mengembalikan respons JSON sukses dengan status 200
            return response()->json([
                'message' => 'Berhasil Menghapus',
                'status' => 200,
                'error' => false
            ]);
        } catch (\Exception $e) {
            // Menangkap exception jika terjadi kesalahan
            return response()->json([
                'message' => 'Gagal Menghapus' . $e,
                'status' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }
}

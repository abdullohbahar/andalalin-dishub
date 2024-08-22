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
                ->addColumn('aksi', function ($item) {
                    $route = route('admin.user.edit', $item->id);
                    $routeShow = route('admin.user.show', $item->id);

                    return "
                    <div class='btn-group' role='group' aria-label='Basic example'>
                        <a href='$route' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='$routeShow' class='btn btn-info btn-sm'>Profile</a>
                        <a data-id='$item->id' data-nama='{$item->hasOneProfile?->nama}' id='removeBtn' style='cursor: pointer !important;' class='btn btn-sm btn-danger'><b>Hapus</b></a>
                    </div>
                    ";
                })
                ->rawColumns(['nama', 'no_telepon', 'aksi'])
                ->make();
        }

        $data = [
            'active' => 'user'
        ];

        return view('admin.user.index', $data);
    }

    public function show($id)
    {
        $user = User::with('hasOneProfile')->findorfail($id);

        $data = [
            'active' => 'user',
            'user' => $user
        ];

        return view('admin.user.show', $data);
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
            // 'password' => 'required|confirmed|min:10|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
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
            'role' => $request->role,
        ]);

        Profile::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return to_route('admin.user.index')->with('success', 'Berhasil menambah user');
    }

    public function edit($id)
    {
        $user = User::with('hasOneProfile')->findorfail($id);

        $data = [
            'active' => 'user',
            'user' => $user
        ];

        return view('admin.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'username' => 'required',
            'role' => 'required'
        ], [
            'nama.required' => 'nama harus diisi',
            'email.required' => 'email harus diisi',
            'role.required' => 'role harus diisi',
            'username.required' => 'username harus diisi',
        ]);

        if ($request->password) {
            $request->validate([
                'password' => 'required|confirmed|min:10|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ], [
                'password.required' => 'password harus diisi',
                'password.confirmed' => 'password tidak sama',
                'password.min' => 'password minimal 10 karakter',
                'password.regex' => 'password harus terdiri dari huruf besar, huruf kecil, dan angka',
            ]);
        }

        $user = User::with('hasOneProfile')->findorfail($id);

        if ($request->username != $user->username) {
            $request->validate([
                'username' => 'unique:users,username',
            ], [
                'username.unique' => 'username sudah dipakai',
            ]);
        }

        if ($request->email != $user->email) {
            $request->validate([
                'email' => 'email|unique:users,email',
            ], [
                'email.email' => 'email tidak valid',
                'email.unique' => 'email sudah dipakai',
            ]);
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        $user->hasOneProfile->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return to_route('admin.user.index')->with('success', 'Berhasil mengubah user');
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $metrics = [
            'total'     => User::count(),
            'mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'admin'     => User::where('role', 'admin')->count(),
            'dewa'      => User::where('role', 'dewa')->count(),
        ];

        $users = User::orderBy('nama_lengkap', 'ASC')->paginate(10);

        return view('admin.users.index', compact('users', 'metrics'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nim'           => 'required|string|max:50|unique:users,nim,' . $user->id_user . ',id_user',
            'email'         => 'nullable|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'no_whatsapp'   => 'required|string|max:20',
            'fakultas'      => 'required|string|max:100',
            'role'          => 'required|in:dewa,admin,mahasiswa',
        ]);

        try {
            $user->update([
                'nama_lengkap'  => $request->nama_lengkap,
                'nim'           => $request->nim,
                'email'         => $request->email,
                'no_whatsapp'   => $request->no_whatsapp,
                'fakultas'      => $request->fakultas,
                'role'          => $request->role,
            ]);

            return redirect()->route('users.index')->with('success', 'Data profil pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan: ' . $e->getMessage());
        }
    }
}

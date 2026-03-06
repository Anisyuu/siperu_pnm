<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserController extends Controller
{
    public function listUser(request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $users = User::with('roles')->where(function($query) use ($search) {
            $query->where('nama_lengkap', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");

        })->when($status, function($query, $status) {
            return $query->where('is_active', $status);
        })->paginate(5);

        return view('layouts.kasubag.user.list_user', compact('users', 'search', 'status'));
    }

    public function tambahUser()
    {
        $roles = Role::all();
        return view('layouts.kasubag.user.tambah_user', compact('roles'));
    }

    public function simpanUser(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:user,email',
            'nomor_induk'  => 'required|string|max:50|unique:user,nomor_induk',
            'role'         => 'required|exists:role,nama',
        ]);

        // Simpan user
        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email'        => $validated['email'],
            'nomor_induk'  => $validated['nomor_induk'],
            'password'     => Hash::make($validated['nomor_induk']), // otomatis ke-hash oleh mutator
            'is_active'    => 'active', // default status
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        return redirect()
            ->route('kasubag.list-user')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function editUser($nomor_induk)
    {
        // Implementasi edit user
        $user = User::where('nomor_induk', $nomor_induk)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $roles = Role::all();
        return view('layouts.kasubag.user.edit_user', compact('user', 'roles'));
    }

    public function updateUser(Request $request, $nomor_induk)
    {
        // Implementasi update user
        $user = User::where('nomor_induk', $nomor_induk)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Validasi
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:user,email,' . $user->nomor_induk . ',nomor_induk',
            'role'         => 'required|exists:role,nama',
            'is_active'    => 'required|in:active,inactive',
        ]);

        // Update user
        $user->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email'        => $validated['email'],
            'is_active'    => $validated['is_active'],
        ]);

        // Sync role
        $user->syncRoles($validated['role']);

        return redirect()
            ->route('kasubag.list-user')
            ->with('success', 'User berhasil diperbarui!');
    }
}

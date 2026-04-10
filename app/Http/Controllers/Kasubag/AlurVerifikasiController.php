<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlurVerifikasi;
use App\Models\Role;

class AlurVerifikasiController extends Controller
{
    public function index() 
    {
        $alurVerifikasi = AlurVerifikasi::orderBy('urutan')
            ->get()
            ->groupBy('jenis_pemohon');

        $totalAlur = $alurVerifikasi->count();
        $role = Role::all();

        return view('layouts.kasubag.peminjaman.alur_verifikasi', compact('alurVerifikasi', 'role', 'totalAlur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pemohon' => 'required|string|max:25',
            'role_verifikator' => 'required|array',
        ]);

        // 🔥 Hapus alur lama (biar 1 jenis = 1 alur)
        AlurVerifikasi::where('jenis_pemohon', $request->jenis_pemohon)->delete();

        foreach ($request->role_verifikator as $index => $role) {
            AlurVerifikasi::create([
                'jenis_pemohon' => $request->jenis_pemohon,
                'urutan' => $index + 1, // auto urutan
                'role_verifikator' => $role,
            ]);
        }

        return back()->with('success', 'Alur berhasil disimpan');
    }

    public function show($jenis)
{
    return AlurVerifikasi::where('jenis_pemohon', $jenis)
        ->orderBy('urutan')
        ->get();
}

    public function destroy($jenis)
{
    AlurVerifikasi::where('jenis_pemohon', $jenis)->delete();

    return back()->with('success', 'Alur berhasil dihapus');
}
}

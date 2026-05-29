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
            'role_verifikator' => 'required|array|min:1',
            'mode' => 'nullable|string|in:create,edit',
        ]);

        AlurVerifikasi::where('jenis_pemohon', $request->jenis_pemohon)->delete();

        foreach ($request->role_verifikator as $index => $role) {
            AlurVerifikasi::create([
                'jenis_pemohon' => $request->jenis_pemohon,
                'urutan' => $index + 1,
                'role_verifikator' => $role,
            ]);
        }

        $message = $request->mode === 'edit'
            ? 'Alur verifikasi berhasil diedit'
            : 'Alur verifikasi berhasil ditambahkan';

        return back()->with('success', $message);
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

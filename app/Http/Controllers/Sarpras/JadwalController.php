<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // LIST (sesuai route kamu: sarpras.jadwal-ruangan)
    public function kelolaJadwal(Request $request)
    {
        $search    = $request->input('search');
        $ruanganId = $request->input('ruangan_id');
        $tanggal   = $request->input('tanggal');

        $jadwal = Jadwal::with('ruangan')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('mata_kuliah', 'like', "%{$search}%")
                       ->orWhere('dosen_pengampu', 'like', "%{$search}%");
                });
            })
            ->when($ruanganId, fn($q) => $q->where('ruangan_id', $ruanganId))
            ->when($tanggal, fn($q) => $q->whereDate('tanggal', $tanggal))
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'asc')
            ->paginate(10)
            ->withQueryString();

        $ruangan = Ruangan::orderBy('nama_ruang')->get();

        // sesuaikan path view sarpras kamu
        return view('layouts.sarpras.jadwal.kelola_jadwal', compact('jadwal', 'ruangan'));
    }

    public function tambahJadwal()
    {
        $ruangan = Ruangan::orderBy('nama_ruang')->get();
        return view('layouts.sarpras.jadwal.tambah_jadwal', compact('ruangan'));
    }

    public function simpanJadwal(Request $request)
    {
        $validated = $request->validate([
            'ruangan_id'     => 'required|exists:ruangan,id',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'required|date_format:H:i',
            'waktu_selesai'  => 'required|date_format:H:i|after:waktu_mulai',
            'mata_kuliah'    => 'required|string|max:100',
            'dosen_pengampu' => 'required|string|max:100',
            'catatan'        => 'nullable|string',
        ]);

        Jadwal::create($validated);

        return redirect()
            ->route('sarpras.kelola-jadwal')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function editJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $ruangan = Ruangan::orderBy('nama_ruang')->get();

        return view('layouts.sarpras.jadwal.edit_jadwal', compact('jadwal', 'ruangan'));
    }

    public function updateJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $validated = $request->validate([
            'ruangan_id'     => 'required|exists:ruangan,id',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'required|date_format:H:i',
            'waktu_selesai'  => 'required|date_format:H:i|after:waktu_mulai',
            'mata_kuliah'    => 'required|string|max:100',
            'dosen_pengampu' => 'required|string|max:100',
            'catatan'        => 'nullable|string',
        ]);

        $jadwal->update($validated);

        return redirect()
            ->route('sarpras.kelola-jadwal')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function hapusJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()
            ->route('sarpras.kelola-jadwal')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}

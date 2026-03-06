<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use App\Models\JenisRuang;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaRuanganController extends Controller
{

    public function masterRuangan()
    {
        $jenisRuangan = JenisRuang::all();
        $gedung = Gedung::all();

        $user = User::whereHas('roles', function ($q) {
            $q->where('nama', 'sarpras');
        })->get();

        return view(
            'layouts.kasubag.ruangan.master_ruangan',
            compact('jenisRuangan','gedung','user')
        );
    }
    public function simpanJenisRuang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        JenisRuang::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Jenis Ruangan berhasil disimpan.');
    }

    public function simpanGedung(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_user' => 'required|exists:user,nomor_induk',
        ]);

        Gedung::create([
            'nama' => $request->nama,
            'id_user' => $request->id_user,
        ]);

        return redirect()->back()->with('success', 'Gedung berhasil disimpan.');
    }

    public function hapusJenisRuang($id)
    {
        $jenisRuang = JenisRuang::findOrFail($id);
        $jenisRuang->delete();

        return redirect()->back()->with('success', 'Jenis Ruangan berhasil dihapus.');
    }

    public function hapusGedung($id)
    {
        $gedung = Gedung::findOrFail($id);
        $gedung->delete();

        return redirect()->back()->with('success', 'Gedung berhasil dihapus.');
    }


    public function KelolaRuangan(Request $request)
    {
        $search   = $request->input('search');
        $gedungId = $request->input('gedung');

    $ruangan = Ruangan::with(['jenisRuangan', 'gedung'])
        ->when($search, function ($q) use ($search) {
            $q->where('nama_ruang', 'like', "%{$search}%");
        })
        ->when($gedungId, function ($q) use ($gedungId) {
            $q->where('id_gedung', $gedungId);
        })
        ->paginate(5)
        ->withQueryString();

        $gedung = Gedung::all();
        return view('layouts.kasubag.ruangan.kelola_ruangan', compact('ruangan', 'gedung'));
    }

    public function tambahRuangan()
    {
        $gedung = Gedung::all();
        $jenisRuang = JenisRuang::all();
        return view('layouts.kasubag.ruangan.tambah_ruangan', compact('gedung', 'jenisRuang'));
    }

    public function simpanRuangan(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_jenis_ruang' => 'required|exists:jenis_ruang,id',
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required|integer|min:1',
            'nomor_ruang' => 'required|string|max:5',
            'nama_ruang' => 'required|string|max:25',
        ]);

        // Simpan data ruangan
        Ruangan::create([
            'id_jenis_ruang' => $request->id_jenis_ruang,
            'id_gedung' => $request->id_gedung,
            'lantai' => $request->lantai,
            'nomor_ruang' => $request->nomor_ruang,
            'nama_ruang' => $request->nama_ruang,
        ]);

        return redirect()->route('kasubag.kelola-ruangan')->with('success', 'Ruangan berhasil disimpan.');
    }

    public function editRuangan($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $gedung = Gedung::all();
        $jenisRuang = JenisRuang::all();
        return view('layouts.kasubag.ruangan.edit_ruangan', compact('ruangan', 'gedung', 'jenisRuang'));
    }

    public function updateRuangan(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_jenis_ruang' => 'required|exists:jenis_ruang,id',
            'id_gedung' => 'required|exists:gedung,id',
            'lantai' => 'required|integer|min:1',
            'nomor_ruang' => 'required|string|max:5',
            'nama_ruang' => 'required|string|max:25',
        ]);

        // Cari ruangan berdasarkan ID
        $ruangan = Ruangan::findOrFail($id);

        // Update data ruangan
        $ruangan->update([
            'id_jenis_ruang' => $request->id_jenis_ruang,
            'id_gedung' => $request->id_gedung,
            'lantai' => $request->lantai,
            'nomor_ruang' => $request->nomor_ruang,
            'nama_ruang' => $request->nama_ruang,
        ]);

        return redirect()->route('kasubag.kelola-ruangan')->with('success', 'Ruangan berhasil diperbarui.');
    }

}

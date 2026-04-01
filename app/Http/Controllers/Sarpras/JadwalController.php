<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Kampus;
use App\Models\Gedung;
use App\Models\JenisRuang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalController extends Controller
{
    public function kelolaJadwal(Request $request)
    {
        $search        = $request->input('search');
        $ruanganId     = $request->input('ruangan_id');
        $tanggal       = $request->input('tanggal');
        $kampusId      = $request->input('kampus_id');
        $gedungSlug    = $request->input('gedung_slug');
        $jenisRuangId  = $request->input('jenis_ruang_id');

        $jadwal = Jadwal::with([
                'ruangan.jenisRuangan',
                'ruangan.gedung.kampus'
            ])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('mata_kuliah', 'like', "%{$search}%")
                       ->orWhere('dosen_pengampu', 'like', "%{$search}%");
                });
            })
            ->when($ruanganId, fn($q) => $q->where('ruangan_id', $ruanganId))
            ->when($tanggal, fn($q) => $q->whereDate('tanggal', $tanggal))
            ->when($kampusId, function ($q) use ($kampusId) {
                $q->whereHas('ruangan.gedung.kampus', function ($qq) use ($kampusId) {
                    $qq->where('id', $kampusId);
                });
            })
            ->when($gedungSlug, function ($q) use ($gedungSlug) {
                $q->whereHas('ruangan.gedung', function ($qq) use ($gedungSlug) {
                    $qq->where('slug', $gedungSlug);
                });
            })
            ->when($jenisRuangId, function ($q) use ($jenisRuangId) {
                $q->whereHas('ruangan.jenisRuangan', function ($qq) use ($jenisRuangId) {
                    $qq->where('id', $jenisRuangId);
                });
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'asc')
            ->paginate(10)
            ->withQueryString();

        $kampus = Kampus::orderBy('nama_kampus')->get();
        $gedung = Gedung::with('kampus')->orderBy('nama')->get();
        $jenisRuang = JenisRuang::orderBy('nama')->get();
        $ruangan = Ruangan::with(['gedung.kampus', 'jenisRuangan'])->orderBy('nama_ruang')->get();

        return view('layouts.sarpras.jadwal.kelola_jadwal', compact(
            'jadwal',
            'kampus',
            'gedung',
            'jenisRuang',
            'ruangan'
        ));
    }

    public function tambahJadwal()
    {
        $kampus = Kampus::orderBy('nama_kampus')->get();
        $gedung = Gedung::with('kampus')->orderBy('nama')->get();
        $jenisRuang = JenisRuang::orderBy('nama')->get();

        $ruangan = Ruangan::with(['gedung.kampus', 'jenisRuangan'])
            ->orderBy('nama_ruang')
            ->get();

        return view('layouts.sarpras.jadwal.tambah_jadwal', compact(
            'kampus',
            'gedung',
            'jenisRuang',
            'ruangan'
        ));
    }

    public function simpanJadwal(Request $request)
    {
        // Gabung jam + menit
        // $request->merge([
        //     'waktu_mulai'   => $request->jam_mulai . ':' . str_pad($request->menit_mulai, 2, '0', STR_PAD_LEFT),
        //     'waktu_selesai' => $request->jam_selesai . ':' . str_pad($request->menit_selesai, 2, '0', STR_PAD_LEFT),
        // ]);

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

        Alert::success('Berhasil', 'Jadwal berhasil ditambahkan');

        return redirect()
            ->route('sarpras.kelola-jadwal')
            ->with('success', 'Jadwal berhasil ditambahkan.');
        }

    public function editJadwal($id)
    {
        $jadwal = Jadwal::with(['ruangan.gedung.kampus', 'ruangan.jenisRuangan'])->findOrFail($id);

        $kampus = Kampus::orderBy('nama_kampus')->get();
        $gedung = Gedung::with('kampus')->orderBy('nama')->get();
        $jenisRuang = JenisRuang::orderBy('nama')->get();
        $ruangan = Ruangan::with(['gedung.kampus', 'jenisRuangan'])
            ->orderBy('nama_ruang')
            ->get();

        return view('layouts.sarpras.jadwal.edit_jadwal', compact(
            'jadwal',
            'kampus',
            'gedung',
            'jenisRuang',
            'ruangan'
        ));
    }

    public function updateJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

    $request->merge([
        'waktu_mulai'   => $request->jam_mulai . ':' . str_pad($request->menit_mulai, 2, '0', STR_PAD_LEFT),
        'waktu_selesai' => $request->jam_selesai . ':' . str_pad($request->menit_selesai, 2, '0', STR_PAD_LEFT),
    ]);

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

    Alert::success('Berhasil', 'Jadwal berhasil diperbarui');

    return redirect()
        ->route('sarpras.kelola-jadwal')
        ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function hapusJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        Alert::success('Berhasil', 'Jadwal berhasil dihapus');

        return redirect()
            ->route('sarpras.kelola-jadwal')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}

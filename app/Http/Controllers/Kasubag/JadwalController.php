<?php

namespace App\Http\Controllers\Kasubag;

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
        $search          = $request->input('search');
        $ruanganId       = $request->input('ruangan_id');
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');
        $kampusId        = $request->input('kampus_id');
        $gedungSlug      = $request->input('gedung_slug');
        $jenisRuangId    = $request->input('jenis_ruang_id');

        $jadwal = Jadwal::with([
                'ruangan.jenisRuangan',
                'ruangan.gedung.kampus'
            ])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('kegiatan', 'like', "%{$search}%")
                       ->orWhere('penanggung_jawab', 'like', "%{$search}%")
                       ->orWhere('catatan', 'like', "%{$search}%");
                });
            })
            ->when($ruanganId, fn ($q) => $q->where('ruangan_id', $ruanganId))

            // Filter kalau tanggal mulai dan tanggal selesai diisi
            ->when($tanggalMulai && $tanggalSelesai, function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereDate('tanggal_mulai', '<=', $tanggalSelesai)
                  ->whereDate('tanggal_selesai', '>=', $tanggalMulai);
            })

            // Filter kalau hanya tanggal mulai yang diisi
            ->when($tanggalMulai && !$tanggalSelesai, function ($q) use ($tanggalMulai) {
                $q->whereDate('tanggal_mulai', '<=', $tanggalMulai)
                  ->whereDate('tanggal_selesai', '>=', $tanggalMulai);
            })

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
            ->orderBy('tanggal_mulai', 'desc')
            ->orderBy('waktu_mulai', 'asc')
            ->paginate(10)
            ->withQueryString();

        $kampus = Kampus::orderBy('nama_kampus')->get();
        $gedung = Gedung::with('kampus')->orderBy('nama')->get();
        $jenisRuang = JenisRuang::orderBy('nama')->get();

        $ruangan = Ruangan::with(['gedung.kampus', 'jenisRuangan'])
            ->orderBy('nama_ruang')
            ->get();

        return view('layouts.kasubag.jadwal.kelola_jadwal', compact(
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

        return view('layouts.kasubag.jadwal.tambah_jadwal', compact(
            'kampus',
            'gedung',
            'jenisRuang',
            'ruangan'
        ));
    }

    public function simpanJadwal(Request $request)
    {
        $validated = $request->validate([
            'ruangan_id'         => 'required|exists:ruangan,id',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'        => 'required|date_format:H:i',
            'waktu_selesai'      => 'required|date_format:H:i|after:waktu_mulai',
            'kegiatan'           => 'required|string|max:150',
            'penanggung_jawab'   => 'nullable|string|max:100',
            'catatan'            => 'nullable|string',
        ]);

        $bentrok = Jadwal::where('ruangan_id', $validated['ruangan_id'])
            ->whereDate('tanggal_mulai', '<=', $validated['tanggal_selesai'])
            ->whereDate('tanggal_selesai', '>=', $validated['tanggal_mulai'])
            ->whereTime('waktu_mulai', '<', $validated['waktu_selesai'])
            ->whereTime('waktu_selesai', '>', $validated['waktu_mulai'])
            ->exists();

        if ($bentrok) {
            return back()
                ->withInput()
                ->withErrors([
                    'waktu_mulai' => 'Ruangan sudah memiliki jadwal pada tanggal dan jam tersebut.'
                ]);
        }

        Jadwal::create($validated);

        Alert::success('Berhasil', 'Jadwal penggunaan ruangan berhasil ditambahkan');

        return redirect()
            ->route('kasubag.kelola-jadwal')
            ->with('success', 'Jadwal penggunaan ruangan berhasil ditambahkan.');
    }

    public function editJadwal($id)
    {
        $jadwal = Jadwal::with([
            'ruangan.gedung.kampus',
            'ruangan.jenisRuangan'
        ])->findOrFail($id);

        $kampus = Kampus::orderBy('nama_kampus')->get();
        $gedung = Gedung::with('kampus')->orderBy('nama')->get();
        $jenisRuang = JenisRuang::orderBy('nama')->get();

        $ruangan = Ruangan::with(['gedung.kampus', 'jenisRuangan'])
            ->orderBy('nama_ruang')
            ->get();

        return view('layouts.kasubag.jadwal.edit_jadwal', compact(
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

        $validated = $request->validate([
            'ruangan_id'         => 'required|exists:ruangan,id',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'        => 'required|date_format:H:i',
            'waktu_selesai'      => 'required|date_format:H:i|after:waktu_mulai',
            'kegiatan'           => 'required|string|max:150',
            'penanggung_jawab'   => 'nullable|string|max:100',
            'catatan'            => 'nullable|string',
        ]);

        $bentrok = Jadwal::where('id', '!=', $jadwal->id)
            ->where('ruangan_id', $validated['ruangan_id'])
            ->whereDate('tanggal_mulai', '<=', $validated['tanggal_selesai'])
            ->whereDate('tanggal_selesai', '>=', $validated['tanggal_mulai'])
            ->whereTime('waktu_mulai', '<', $validated['waktu_selesai'])
            ->whereTime('waktu_selesai', '>', $validated['waktu_mulai'])
            ->exists();

        if ($bentrok) {
            return back()
                ->withInput()
                ->withErrors([
                    'waktu_mulai' => 'Ruangan sudah memiliki jadwal pada tanggal dan jam tersebut.'
                ]);
        }

        $jadwal->update($validated);

        Alert::success('Berhasil', 'Jadwal penggunaan ruangan berhasil diperbarui');

        return redirect()
            ->route('kasubag.kelola-jadwal')
            ->with('success', 'Jadwal penggunaan ruangan berhasil diperbarui.');
    }

    public function hapusJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        Alert::success('Berhasil', 'Jadwal penggunaan ruangan berhasil dihapus');

        return redirect()
            ->route('kasubag.kelola-jadwal')
            ->with('success', 'Jadwal penggunaan ruangan berhasil dihapus.');
    }
}

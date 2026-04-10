<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Kampus;
use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanController extends Controller
{
    public function listPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung'])
            ->where('pemohon_id', Auth::user()->nomor_induk);

        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('layouts.mahasiswa.peminjaman.list_peminjaman', compact('peminjaman'));
    }

    public function ajukanPeminjaman()
    {
        $kampus  = Kampus::orderBy('nama_kampus')->get();
        $gedung  = Gedung::with('kampus')->orderBy('nama')->get();
        $ruangan = Ruangan::with(['gedung.kampus'])->orderBy('nama_ruang')->get();

        return view('layouts.mahasiswa.peminjaman.ajukan_peminjaman',
            compact('kampus', 'gedung', 'ruangan')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id'    => 'required|exists:ruangan,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'kegiatan'      => 'required|string|max:1000',
            'dokumen_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'tanggal_mulai.after_or_equal'   => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'waktu_selesai.after'            => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        // Cek bentrok jadwal
        $bentrok = Peminjaman::where('ruangan_id', $request->ruangan_id)
            ->where('status', '!=', 'ditolak')
            ->where(function ($q) use ($request) {
                $q->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                  ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai]);
            })
            ->where(function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('waktu_mulai', '<', $request->waktu_selesai)
                       ->where('waktu_selesai', '>', $request->waktu_mulai);
                });
            })
            ->exists();

        if ($bentrok) {
            Alert::error('Gagal', 'Ruangan sudah dipesan pada waktu tersebut. Pilih waktu atau ruangan lain.');
            return back()
                ->withInput()
                ->withErrors(['ruangan_id' => 'Ruangan sudah dipesan pada waktu tersebut. Pilih waktu atau ruangan lain.']);
        }

        $dokumen = null;
        if ($request->hasFile('dokumen_bukti')) {
            $dokumen = $request->file('dokumen_bukti')
                ->store('dokumen_peminjaman', 'public');
        }

        DB::transaction(function () use ($request, $dokumen) {
            $last = Peminjaman::lockForUpdate()->latest('id')->first();
            $no   = 'PMJ-' . str_pad(($last ? (int) substr($last->no_peminjaman, 4) + 1 : 1), 5, '0', STR_PAD_LEFT);

            Peminjaman::create([
                'no_peminjaman'   => $no,
                'pemohon_id'      => Auth::user()->nomor_induk,
                'ruangan_id'      => $request->ruangan_id,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_mulai'     => $request->waktu_mulai,
                'waktu_selesai'   => $request->waktu_selesai,
                'kegiatan'        => $request->kegiatan,
                'dokumen_bukti'   => $dokumen,
                'status'          => 'pending',
            ]);
        });

        return redirect()->route('mahasiswa.list-peminjaman')
            ->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function detailPeminjaman($id)
    {
        $peminjaman = Peminjaman::with(['ruangan.gedung.kampus', 'verifikasi'])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->findOrFail($id);

        $jenisPemohon = $peminjaman->pemohon->roles->pluck('nama')->first() ?? $peminjaman->pemohon->role;
        // ATAU kalau ambil dari user:
        // $jenisPemohon = Auth::user()->role;

        $alur = \App\Models\AlurVerifikasi::where('jenis_pemohon', $jenisPemohon)
            ->orderBy('urutan')
            ->get();

        // relasi ke tabel verifikasi (misal: verifikasi_peminjaman)
        $riwayat = $peminjaman->verifikasi ?? collect();

        return view('layouts.mahasiswa.peminjaman.detail_peminjaman', compact('peminjaman', 'alur', 'riwayat'));
    }

    public function batalkanPeminjaman($id)
    {
        $peminjaman = Peminjaman::where('pemohon_id', Auth::user()->nomor_induk)
            ->where('status', 'pending')
            ->findOrFail($id);

        if ($peminjaman->dokumen_bukti && Storage::disk('public')->exists($peminjaman->dokumen_bukti)) {
            Storage::disk('public')->delete($peminjaman->dokumen_bukti);
        }

        $peminjaman->delete();

        return redirect()->route('mahasiswa.list-peminjaman')->with('success', 'Pengajuan berhasil dibatalkan');
    }

    public function riwayatPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung'])
            ->where('pemohon_id', Auth::user()->nomor_induk);

        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('layouts.mahasiswa.riwayat.riwayat_peminjaman', compact('peminjaman'));
    }
}

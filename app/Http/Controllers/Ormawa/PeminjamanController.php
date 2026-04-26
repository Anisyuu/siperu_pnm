<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Kampus;
use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanController extends Controller
{
    public function listPeminjaman(Request $request) // Menampilkan daftar pengajuan yang masih pending
    {
        $query = Peminjaman::with(['ruangan.gedung'])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->where('status', 'pending');

        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('layouts.ormawa.peminjaman.list_peminjaman', compact('peminjaman'));
    }

    // Menampilkan form pengajuan peminjaman
    public function ajukanPeminjaman()
    {
        $kampus  = Kampus::orderBy('nama_kampus')->get(); // Ambil data kampus, gedung, dan ruangan untuk dropdown
        $gedung  = Gedung::with('kampus')->orderBy('nama')->get();
        $ruangan = Ruangan::with(['gedung.kampus'])->orderBy('nama_ruang')->get();

        return view('layouts.ormawa.peminjaman.ajukan_peminjaman',
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
            // Pesan error custom
            'tanggal_mulai.after_or_equal'   => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'waktu_selesai.after'            => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        // Cek bentrok jadwal
        // Mengecek apakah ruangan sudah dipakai di waktu yang sama
        $bentrok = Peminjaman::where('ruangan_id', $request->ruangan_id)
            ->where('status', 'pending') // cek yang pending
            ->where(function ($q) use ($request) {
                // Cek bentrok tanggal
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

        // Jika bentrok, tampilkan alert dan kembalikan ke form dengan error
        if ($bentrok) {
            Alert::error('Jadwal Bentrok', 'Ruangan sudah dipesan pada waktu tersebut. Pilih waktu atau ruangan lain.');
            return back()
                ->withInput()
                ->withErrors(['ruangan_id' => 'Ruangan sudah dipesan pada waktu tersebut. Pilih waktu atau ruangan lain.']);
        }

        // Upload dokumen (jika ada)
        $dokumen = null;
        if ($request->hasFile('dokumen_bukti')) {
            $dokumen = $request->file('dokumen_bukti')
                ->store('dokumen_peminjaman', 'public');
        }

        // Simpan data dalam transaction (biar aman kalau gagal di tengah jalan)
        DB::transaction(function () use ($request, $dokumen) {
            do {
                    $no = strtoupper(Str::random(6));
                } while (Peminjaman::where('no_peminjaman', $no)->exists());

            // Simpan ke database
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

        return redirect()->route('ormawa.list-peminjaman')
            ->with('success', 'Pengajuan berhasil dikirim.');
    }

    //menampilkan detail peminjaman beserta alur verifikasi dan riwayatnya
    public function detailPeminjaman($id)
    {
        $peminjaman = Peminjaman::with(['ruangan.gedung.kampus', 'verifikasi'])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->findOrFail($id);

        // Menentukan jenis pemohon (untuk menentukan alur verifikasi)
        $jenisPemohon = $peminjaman->pemohon->roles->pluck('nama')->first() ?? $peminjaman->pemohon->role;
        // ATAU kalau ambil dari user:
        // $jenisPemohon = Auth::user()->role;

         // Ambil alur verifikasi sesuai jenis pemohon (misal: dosen, ormawa, dll)
        $alur = \App\Models\AlurVerifikasi::where('jenis_pemohon', $jenisPemohon)
            ->orderBy('urutan')
            ->get();

        // relasi ke tabel verifikasi (misal: verifikasi_peminjaman)
        $riwayat = $peminjaman->verifikasi ?? collect();

        return view('layouts.ormawa.peminjaman.detail_peminjaman', compact('peminjaman', 'alur', 'riwayat'));
    }

    //membatalkan pengajuan peminjaman yang masih pending (bisa dibatalkan oleh pemohon)
    public function batalkanPeminjaman($id)
    {
        // Ambil hanya data milik user + status masih pending
        $peminjaman = Peminjaman::where('pemohon_id', Auth::user()->nomor_induk)
            ->where('status', 'pending')
            ->findOrFail($id);

        // Hapus file dokumen jika ada
        if ($peminjaman->dokumen_bukti && Storage::disk('public')->exists($peminjaman->dokumen_bukti)) {
            Storage::disk('public')->delete($peminjaman->dokumen_bukti);
        }

        // Hapus data peminjaman
        $peminjaman->delete();

        return redirect()->route('ormawa.list-peminjaman')->with('success', 'Pengajuan berhasil dibatalkan');
    }

    // Menampilkan riwayat peminjaman (yang sudah selesai diproses)
    public function riwayatPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung'])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->whereIn('status', ['disetujui', 'ditolak']); // hanya riwayat (bukan pending)

        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('layouts.ormawa.riwayat.riwayat_peminjaman', compact('peminjaman'));
    }
}

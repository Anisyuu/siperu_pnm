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

        return view('layouts.ormawa.peminjaman.list_peminjaman', compact('peminjaman'));
    }

    public function ajukanPeminjaman()
    {
        $kampus = Kampus::orderBy('nama_kampus')->get();

    $gedung = Gedung::with('kampus')
        ->orderBy('nama')
        ->get();

    $ruangan = Ruangan::with(['gedung.kampus'])
        ->orderBy('nama_ruang')
        ->get();

    return view('layouts.ormawa.peminjaman.ajukan_peminjaman', compact(
        'kampus',
        'gedung',
        'ruangan'
    ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangan,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'kegiatan' => 'required|string',
            'dokumen_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $dokumen = null;

        if ($request->hasFile('dokumen_bukti')) {
            $dokumen = $request->file('dokumen_bukti')->store('dokumen_peminjaman', 'public');
        }

        // ==============================
        // 🔥 GENERATE NO PEMINJAMAN
        // ==============================
        DB::transaction(function () use ($request, $dokumen) {

            $last = Peminjaman::orderBy('id', 'desc')->lockForUpdate()->first();

            if ($last && $last->no_peminjaman) {
                $lastNumber = (int) substr($last->no_peminjaman, 4);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $no_peminjaman = 'PMJ-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

            Peminjaman::create([
                'no_peminjaman' => $no_peminjaman,
                'pemohon_id' => Auth::user()->nomor_induk,
                'ruangan_id' => $request->ruangan_id,
                'tanggal' => $request->tanggal,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'kegiatan' => $request->kegiatan,
                'dokumen_bukti' => $dokumen,
                'status' => 'pending',
                'catatan' => null,
            ]);

        });

        return redirect()->route('ormawa.list-peminjaman')->with('success', 'Pengajuan berhasil dikirim');
    }

    public function detailPeminjaman($id)
    {
        $peminjaman = Peminjaman::with(['ruangan.gedung.kampus'])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->findOrFail($id);

        return view('layouts.ormawa.peminjaman.detail_peminjaman', compact('peminjaman'));
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

        return redirect()->route('ormawa.list-peminjaman')->with('success', 'Pengajuan berhasil dibatalkan');
    }
}

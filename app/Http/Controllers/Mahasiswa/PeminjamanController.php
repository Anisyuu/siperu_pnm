<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Kampus;
use App\Models\Gedung;
use App\Models\Ruangan;
use App\Models\Jadwal;
use App\Models\AlurVerifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use App\Traits\ExportRiwayatCsv;
use App\Notifications\PengajuanPeminjamanNotification;

class PeminjamanController extends Controller
{
    use ExportRiwayatCsv;

    private function ambilAlurVerifikasi(Peminjaman $peminjaman)
    {
        $peminjaman->loadMissing([
            'pemohon.roles',
            'ruangan.jenisRuangan',
        ]);

        $jenisPemohon = $peminjaman->pemohon
            ->roles
            ->pluck('nama')
            ->map(fn ($role) => strtolower(trim($role)))
            ->first();

        $jenisRuangSlug = strtolower(trim($peminjaman->ruangan->jenisRuangan->slug ?? ''));
        $jenisRuangNama = strtolower(trim($peminjaman->ruangan->jenisRuangan->nama ?? ''));

        $isLab = str_contains($jenisRuangSlug, 'lab') || str_contains($jenisRuangNama, 'lab');

        return AlurVerifikasi::whereRaw('LOWER(TRIM(jenis_pemohon)) = ?', [$jenisPemohon])
            ->when(!$isLab, fn ($q) => $q->whereRaw('LOWER(TRIM(role_verifikator)) != ?', ['kalab']))
            ->orderBy('urutan')
            ->get()
            ->values();
    }

    private function kirimNotifikasiKeRole(string $role, Peminjaman $peminjaman): void
    {
        $role = strtolower(trim($role));

        $peminjaman->loadMissing([
            'ruangan.user.roles',
            'ruangan.gedung.user.roles',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Khusus Kalab
        |--------------------------------------------------------------------------
        | Kalab diambil dari penanggung jawab ruangan/lab:
        | ruangan.id_user = user.nomor_induk
        */
        if ($role === 'kalab') {
            $kalabRuangan = $peminjaman->ruangan?->user;

            if (!$kalabRuangan) {
                Log::warning('[notifikasi peminjaman] kalab ruangan tidak ditemukan', [
                    'peminjaman_id' => $peminjaman->id,
                    'ruangan_id'    => $peminjaman->ruangan_id,
                    'ruangan_nama'  => $peminjaman->ruangan->nama_ruang ?? null,
                    'id_user'       => $peminjaman->ruangan->id_user ?? null,
                ]);

                return;
            }

            if (!$kalabRuangan->roles->contains(fn ($r) => strtolower(trim($r->nama)) === 'kalab')) {
                Log::warning('[notifikasi peminjaman] user penanggung jawab ruangan bukan role kalab', [
                    'peminjaman_id'     => $peminjaman->id,
                    'ruangan_id'        => $peminjaman->ruangan_id,
                    'ruangan_nama'      => $peminjaman->ruangan->nama_ruang ?? null,
                    'id_user_ruangan'   => $peminjaman->ruangan->id_user ?? null,
                    'user_nomor_induk'  => $kalabRuangan->nomor_induk,
                    'user_nama_lengkap' => $kalabRuangan->nama_lengkap,
                    'roles_user'        => $kalabRuangan->roles->pluck('nama')->toArray(),
                ]);

                return;
            }

            $kalabRuangan->notify(new PengajuanPeminjamanNotification($peminjaman));

            Log::info('[notifikasi peminjaman] dikirim ke kalab ruangan', [
                'peminjaman_id'      => $peminjaman->id,
                'ruangan_id'         => $peminjaman->ruangan_id,
                'ruangan_nama'       => $peminjaman->ruangan->nama_ruang ?? null,
                'kalab_nomor_induk'  => $kalabRuangan->nomor_induk,
                'kalab_nama_lengkap' => $kalabRuangan->nama_lengkap,
            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Khusus Sarpras
        |--------------------------------------------------------------------------
        | Sarpras diambil dari penanggung jawab gedung:
        | gedung.id_user = user.nomor_induk
        */
        if ($role === 'sarpras') {
            $gedung = $peminjaman->ruangan?->gedung;

            if (!$gedung) {
                Log::warning('[notifikasi peminjaman] gedung ruangan tidak ditemukan', [
                    'peminjaman_id' => $peminjaman->id,
                    'ruangan_id'    => $peminjaman->ruangan_id,
                ]);

                return;
            }

            $sarprasGedung = $gedung->user;

            if (!$sarprasGedung) {
                Log::warning('[notifikasi peminjaman] sarpras gedung tidak ditemukan', [
                    'peminjaman_id' => $peminjaman->id,
                    'ruangan_id'    => $peminjaman->ruangan_id,
                    'gedung_id'     => $gedung->id,
                    'gedung_nama'   => $gedung->nama ?? null,
                    'id_user'       => $gedung->id_user,
                ]);

                return;
            }

            if (!$sarprasGedung->roles->contains(fn ($r) => strtolower(trim($r->nama)) === 'sarpras')) {
                Log::warning('[notifikasi peminjaman] user penanggung jawab gedung bukan role sarpras', [
                    'peminjaman_id'     => $peminjaman->id,
                    'gedung_id'         => $gedung->id,
                    'gedung_nama'       => $gedung->nama ?? null,
                    'id_user_gedung'    => $gedung->id_user,
                    'user_nomor_induk'  => $sarprasGedung->nomor_induk,
                    'user_nama_lengkap' => $sarprasGedung->nama_lengkap,
                    'roles_user'        => $sarprasGedung->roles->pluck('nama')->toArray(),
                ]);

                return;
            }

            $sarprasGedung->notify(new PengajuanPeminjamanNotification($peminjaman));

            Log::info('[notifikasi peminjaman] dikirim ke sarpras gedung', [
                'peminjaman_id'        => $peminjaman->id,
                'ruangan_id'           => $peminjaman->ruangan_id,
                'ruangan_nama'         => $peminjaman->ruangan->nama_ruang ?? null,
                'gedung_id'            => $gedung->id,
                'gedung_nama'          => $gedung->nama ?? null,
                'sarpras_nomor_induk'  => $sarprasGedung->nomor_induk,
                'sarpras_nama_lengkap' => $sarprasGedung->nama_lengkap,
            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Role Umum
        |--------------------------------------------------------------------------
        | Kasubag, pimpinan, dan role umum lain dikirim berdasarkan role.
        */
        $users = User::whereHas('roles', function ($q) use ($role) {
            $q->whereRaw('LOWER(TRIM(nama)) = ?', [$role]);
        })->get();

        Log::info('[notifikasi peminjaman] kirim ke role umum', [
            'role'          => $role,
            'jumlah_user'   => $users->count(),
            'peminjaman_id' => $peminjaman->id,
        ]);

        foreach ($users as $user) {
            $user->notify(new PengajuanPeminjamanNotification($peminjaman));
        }
    }

    public function listPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung', 'verifikasi'])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->where('status', 'pending');

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
            'ruangan_id'       => 'required|exists:ruangan,id',
            'tanggal_mulai'    => 'required|date|after_or_equal:today',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'      => 'required|date_format:H:i',
            'waktu_selesai'    => 'required|date_format:H:i|after:waktu_mulai',
            'kegiatan'         => 'required|string|max:1000',
            'dokumen_bukti'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'tanggal_mulai.after_or_equal'   => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'waktu_selesai.after'            => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        $ruanganBentrokPeminjaman = Peminjaman::where('ruangan_id', $request->ruangan_id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where(function ($q) use ($request) {
                $q->whereDate('tanggal_mulai', '<=', $request->tanggal_selesai)
                    ->whereDate('tanggal_selesai', '>=', $request->tanggal_mulai);
            })
            ->where(function ($q) use ($request) {
                $q->whereTime('waktu_mulai', '<', $request->waktu_selesai)
                    ->whereTime('waktu_selesai', '>', $request->waktu_mulai);
            })
            ->exists();

        $ruanganBentrokJadwal = Jadwal::where('ruangan_id', $request->ruangan_id)
            ->where(function ($q) use ($request) {
                $q->whereDate('tanggal_mulai', '<=', $request->tanggal_selesai)
                    ->whereDate('tanggal_selesai', '>=', $request->tanggal_mulai);
            })
            ->where(function ($q) use ($request) {
                $q->whereTime('waktu_mulai', '<', $request->waktu_selesai)
                    ->whereTime('waktu_selesai', '>', $request->waktu_mulai);
            })
            ->exists();

        if ($ruanganBentrokPeminjaman || $ruanganBentrokJadwal) {
            return back()
                ->withInput()
                ->withErrors([
                    'ruangan_id' => 'Ruangan sudah tidak tersedia pada tanggal dan jam tersebut.'
                ]);
        }

        $dokumen = null;

        if ($request->hasFile('dokumen_bukti')) {
            $dokumen = $request->file('dokumen_bukti')
                ->store('dokumen_peminjaman', 'public');
        }

        try {
            $peminjaman = DB::transaction(function () use ($request, $dokumen) {
                do {
                    $no = strtoupper(Str::random(6));
                } while (Peminjaman::where('no_peminjaman', $no)->exists());

                return Peminjaman::create([
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

            $peminjaman->load([
                'pemohon.roles',
                'ruangan.jenisRuangan',
                'ruangan.user.roles',
                'ruangan.gedung.user.roles',
            ]);

            $alur = $this->ambilAlurVerifikasi($peminjaman);

            if ($alur->isEmpty()) {
                return back()
                    ->withInput()
                    ->with('error', 'Alur verifikasi untuk pemohon ini belum diatur.');
            }

            $alurPertama = $alur->first();

            $this->kirimNotifikasiKeRole(
                $alurPertama->role_verifikator,
                $peminjaman
            );

            return redirect()->route('mahasiswa.list-peminjaman')
                ->with('success', 'Pengajuan berhasil dikirim.');

        } catch (\Exception $e) {
            Log::error('[store peminjaman mahasiswa] error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengajukan peminjaman: ' . $e->getMessage());
        }
    }

    public function detailPeminjaman($id)
    {
        $peminjaman = Peminjaman::with([
                'ruangan.gedung',
                'ruangan.jenisRuangan',
                'verifikasi.verifikator',
                'pemohon.roles',
            ])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->findOrFail($id);

        $jenisPemohon = strtolower(trim(
            $peminjaman->pemohon->roles->pluck('nama')->first() ?? $peminjaman->pemohon->role
        ));

        $jenisRuangSlug = strtolower(trim($peminjaman->ruangan->jenisRuangan->slug ?? ''));
        $jenisRuangNama = strtolower(trim($peminjaman->ruangan->jenisRuangan->nama ?? ''));
        $isLab = str_contains($jenisRuangSlug, 'lab') || str_contains($jenisRuangNama, 'lab');

        $alur = \App\Models\AlurVerifikasi::whereRaw('LOWER(TRIM(jenis_pemohon)) = ?', [$jenisPemohon])
            ->when(!$isLab, fn($q) => $q->whereRaw('LOWER(TRIM(role_verifikator)) != ?', ['kalab']))
            ->orderBy('urutan')
            ->get()
            ->values();

        $riwayat = $peminjaman->verifikasi ?? collect();

        return view('layouts.mahasiswa.peminjaman.detail_peminjaman', compact(
            'peminjaman',
            'alur',
            'riwayat'
        ));
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

        return redirect()->route('mahasiswa.list-peminjaman')
            ->with('success', 'Pengajuan berhasil dibatalkan');
    }

    public function riwayatPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung'])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->whereIn('status', ['disetujui', 'ditolak']);

        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('layouts.mahasiswa.riwayat.riwayat_peminjaman', compact('peminjaman'));
    }

    public function exportRiwayatPeminjaman(Request $request)
    {
        $user = Auth::user();

        $query = Peminjaman::query()
            ->with([
                'ruangan.gedung.kampus',
                'pemohon',
                'verifikasi' => fn ($q) => $q->orderBy('urutan'),
            ])
            ->where('pemohon_id', '=', $user->nomor_induk);

        $this->applyRiwayatFilters($query, $request);

        $peminjaman = $query->latest()->get();

        $fileName = 'riwayat-peminjaman-mahasiswa-' . now()->format('Ymd_His') . '.csv';

        return $this->downloadRiwayatCsv($peminjaman, $fileName, $user->nomor_induk);
    }

    public function ruanganTersedia(Request $request)
    {
        $request->validate([
            'kampus_id'        => 'required|exists:kampus,id',
            'gedung_slug'      => 'required|exists:gedung,slug',
            'lantai'           => 'required|integer|min:1',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'      => 'required|date_format:H:i',
            'waktu_selesai'    => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        $tanggalMulai   = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $waktuMulai     = $request->waktu_mulai;
        $waktuSelesai   = $request->waktu_selesai;

        $ruanganBentrokPeminjaman = Peminjaman::whereIn('status', ['pending', 'disetujui'])
            ->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereDate('tanggal_mulai', '<=', $tanggalSelesai)
                    ->whereDate('tanggal_selesai', '>=', $tanggalMulai);
            })
            ->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                $q->whereTime('waktu_mulai', '<', $waktuSelesai)
                    ->whereTime('waktu_selesai', '>', $waktuMulai);
            })
            ->pluck('ruangan_id')
            ->toArray();

        $ruanganBentrokJadwal = Jadwal::where(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereDate('tanggal_mulai', '<=', $tanggalSelesai)
                    ->whereDate('tanggal_selesai', '>=', $tanggalMulai);
            })
            ->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                $q->whereTime('waktu_mulai', '<', $waktuSelesai)
                    ->whereTime('waktu_selesai', '>', $waktuMulai);
            })
            ->pluck('ruangan_id')
            ->toArray();

        $ruanganBentrok = array_unique(array_merge(
            $ruanganBentrokPeminjaman,
            $ruanganBentrokJadwal
        ));

        $ruangan = Ruangan::with(['gedung.kampus'])
            ->whereHas('gedung', function ($q) use ($request) {
                $q->where('slug', $request->gedung_slug)
                    ->where('kampus_id', $request->kampus_id);
            })
            ->where('lantai', $request->lantai)
            ->whereNotIn('id', $ruanganBentrok)
            ->orderBy('nama_ruang')
            ->get()
            ->map(function ($r) {
                return [
                    'id'          => $r->id,
                    'nama_ruang'  => $r->nama_ruang,
                    'lantai'      => $r->lantai,
                    'gedung'      => $r->gedung->nama ?? '-',
                    'gedung_slug' => $r->gedung->slug ?? '-',
                    'kampus_id'   => $r->gedung->kampus_id ?? null,
                ];
            });

        return response()->json($ruangan);
    }
}

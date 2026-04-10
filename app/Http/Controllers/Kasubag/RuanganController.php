<?php

namespace App\Http\Controllers\Kasubag;

use App\Models\Gedung;
use App\Models\JenisRuang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class RuanganController extends Controller
{
    public function index(Request $request, $gedungSlug = null, $lantai = null)
    {
        $jenisRuang = JenisRuang::all();
        $gedungList = Gedung::with(['kampus'])->get();

        $query = Ruangan::with(['gedung.kampus', 'jenisRuangan']);

        if ($gedungSlug) {
            $query->whereHas('gedung', fn($q) => $q->where('slug', $gedungSlug));
        }

        if ($lantai) {
            $query->where('lantai', $lantai);
        }

        if (!$gedungSlug && $request->filled('slug_gedung')) {
            $query->whereHas('gedung', fn($q) => $q->where('slug', $request->slug_gedung));
        }

        if (!$lantai && $request->filled('lantai')) {
            $query->where('lantai', $request->lantai);
        }

        // Filter jenis ruang — tidak bentrok, boleh tetap ada
        if ($request->filled('slug_jenis_ruang')) {
            $query->whereHas('jenisRuangan', fn($q) => $q->where('slug', $request->slug_jenis_ruang));
        }

        $ruangan = $query->latest()->paginate(10)->withQueryString();

        return view('layouts.kasubag.ruangan.ruang', compact(
            'ruangan',
            'gedungList',
            'gedungSlug',   // slug dari URL untuk filter & breadcrumb
            'lantai',
            'jenisRuang'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenis_ruang' => 'required|exists:jenis_ruang,id',
            'gedung_slug'    => 'required|exists:gedung,slug',
            'lantai'         => 'required|integer|min:1',
            'nomor_ruang'    => 'required|string|max:5',
            'nama_ruang'     => 'required|string|max:25|unique:ruangan,nama_ruang',
        ], [
            'nama_ruang.unique' => 'Nama ruang sudah digunakan.',
        ]);

        if( Ruangan::where('nama_ruang', $request->nama_ruang)->exists() ) {
            Alert::error('Gagal', 'Nama ruang sudah ada. Silakan gunakan nama lain.');
            return back()->withErrors([
                'nama_ruang' => 'Nama ruang sudah ada. Silakan gunakan nama lain.',
            ])->withInput();
        }

        // Ambil gedung berdasarkan slug
        $gedung = Gedung::where('slug', $request->gedung_slug)->firstOrFail();



        if ($request->lantai > $gedung->lantai) {
            Alert::error('Gagal', "Lantai {$request->lantai} tidak tersedia. Gedung ini hanya memiliki {$gedung->lantai} lantai.");
            return back()->withErrors([
                'lantai' => "Lantai {$request->lantai} tidak tersedia. Gedung ini hanya memiliki {$gedung->lantai} lantai.",
            ])->withInput();
        }

        $exists = Ruangan::where('id_gedung', $gedung->id)
                         ->where('lantai', $request->lantai)
                         ->where('nomor_ruang', strtoupper($request->nomor_ruang))
                         ->exists();

        if ($exists) {
            Alert::error('Gagal', 'Nomor ruang sudah ada di lantai dan gedung tersebut.');
            return back()->withErrors([
                'nomor_ruang' => 'Nomor ruang sudah ada di lantai dan gedung tersebut.',
            ])->withInput();
        }

        $slug = Str::slug($request->nama_ruang);

        Ruangan::create([
            'id_jenis_ruang' => $request->id_jenis_ruang,
            'id_gedung'      => $gedung->id,
            'lantai'         => $request->lantai,
            'nomor_ruang'    => strtoupper($request->nomor_ruang),
            'nama_ruang'     => $request->nama_ruang,
            'slug'           => $slug,
        ]);

        Alert::success('Berhasil', 'Ruangan berhasil ditambahkan');
        return redirect()->route('kasubag.ruangan.index', [
            'slug' => $request->gedung_slug,
            'lantai'     => $request->lantai,
        ])->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'id_jenis_ruang' => 'required|exists:jenis_ruang,id',
            'gedung_slug'    => 'required|exists:gedung,slug',
            'lantai'         => 'required|integer|min:1',
            'nomor_ruang'    => 'required|string|max:5',
            'nama_ruang'     => 'required|string|max:25',
        ]);

        $gedung = Gedung::where('slug', $request->gedung_slug)->firstOrFail();

        if ($request->lantai > $gedung->lantai) {
            Alert::error('Gagal', "Lantai {$request->lantai} tidak tersedia. Gedung ini hanya memiliki {$gedung->lantai} lantai.");
            return back()->withErrors([
                'lantai' => "Lantai {$request->lantai} tidak tersedia. Gedung ini hanya memiliki {$gedung->lantai} lantai.",
            ])->withInput();
        }

        $exists = Ruangan::where('id_gedung', $gedung->id)
                         ->where('lantai', $request->lantai)
                         ->where('nomor_ruang', strtoupper($request->nomor_ruang))
                         ->where('id', '!=', $ruangan->id)
                         ->exists();

        if ($exists) {
            Alert::error('Gagal', 'Nomor ruang sudah ada di lantai dan gedung tersebut.');
            return back()->withErrors([
                'nomor_ruang' => 'Nomor ruang sudah ada di lantai dan gedung tersebut.',
            ])->withInput();
        }

        $slug = $ruangan->slug; // default pakai slug lama

        if( $request->nama_ruang != $ruangan->nama_ruang ) {
            $slug = Str::slug($request->nama_ruang);
        }

        $ruangan->update([
            'id_jenis_ruang' => $request->id_jenis_ruang,
            'id_gedung'      => $gedung->id,
            'lantai'         => $request->lantai,
            'nomor_ruang'    => strtoupper($request->nomor_ruang),
            'nama_ruang'     => $request->nama_ruang,
            'slug'           => $slug, // tetap pakai slug lama jika nama_ruang tidak berubah
        ]);

        Alert::success('Berhasil', 'Ruangan berhasil diperbarui');
        return redirect()->route('kasubag.ruangan.index', [
            'slug' => $request->gedung_slug,
            'lantai'     => $request->lantai,
        ])->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        // Simpan info untuk redirect kembali ke halaman yang sama
        $gedungSlug = $ruangan->gedung?->slug;
        $lantai     = $ruangan->lantai;

        $ruangan->delete();

        Alert::success('Berhasil', 'Ruangan berhasil dihapus');

        return redirect()->route('kasubag.ruangan.index', [
            'slug' => $gedungSlug,
            'lantai'     => $lantai,
        ])->with('success', 'Ruangan berhasil dihapus.');
    }
}

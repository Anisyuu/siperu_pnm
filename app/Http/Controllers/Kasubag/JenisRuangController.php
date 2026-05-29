<?php

namespace App\Http\Controllers\Kasubag;

use App\Models\JenisRuang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JenisRuangController extends Controller
{
    public function index()
    {
        // withCount('ruangan') untuk tampilkan jumlah ruangan per jenis
        // + info bar visual di blade
        $jenisRuang = JenisRuang::withCount('ruangan')->latest()->get();

        return view('layouts.kasubag.ruangan.jenisruang', compact('jenisRuang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:25|unique:jenis_ruang,nama',
        ]);

        $slug = Str::slug($request->nama);

        JenisRuang::create([
            'nama' => $request->nama,
            'slug' => $slug
        ]);

        Alert::success('Berhasil', 'Jenis ruang berhasil ditambahkan');

        return redirect()->back();
    }


    public function update(Request $request, $slug)
{
    $jenisRuang = JenisRuang::where('slug', $slug)->firstOrFail();

    $validated = $request->validate([
        'nama' => [
            'required',
            'string',
            'max:25',
            Rule::unique('jenis_ruang', 'nama')->ignore($jenisRuang->id),
        ],
    ]);

    $newSlug = $validated['nama'] !== $jenisRuang->nama
        ? Str::slug($validated['nama'])
        : $jenisRuang->slug;

    $jenisRuang->update([
        'nama' => $validated['nama'],
        'slug' => $newSlug,
    ]);

    Alert::success('Berhasil', 'Jenis ruang berhasil diperbarui');

    return redirect()->back();
}

    public function destroy($slug)
    {
        $jenisRuang = JenisRuang::where('slug', $slug)->firstOrFail();

        if ($jenisRuang->ruangan()->exists()) {

            Alert::error(
                'Tidak bisa dihapus',
                'Jenis ruang masih digunakan ruangan'
            );

            return redirect()->back();
        }

        $nama = $jenisRuang->nama;

        $jenisRuang->delete();

        Alert::success(
            'Berhasil',
            "Jenis ruang {$nama} berhasil dihapus"
        );

        return redirect()->back();
    }
}

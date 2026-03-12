<?php

namespace App\Http\Controllers\Kasubag;

use App\Models\JenisRuang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

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

    public function update(Request $request, JenisRuang $jenisRuang)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:25',
                \Illuminate\Validation\Rule::unique('jenis_ruang','nama')
                    ->ignore($jenisRuang->id),
            ],
        ]);

        $slug = $request->nama !== $jenisRuang->nama
            ? Str::slug($request->nama)
            : $jenisRuang->slug;

        $jenisRuang->update([
            'nama' => $request->nama,
            'slug' => $slug
        ]);

        Alert::success('Berhasil', 'Jenis ruang berhasil diperbarui');

        return redirect()->back();
    }

    public function destroy(JenisRuang $jenisRuang)
    {
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

        return redirect()->route('kasubag.jenis-ruang.index', compact('nama'));
    }
}
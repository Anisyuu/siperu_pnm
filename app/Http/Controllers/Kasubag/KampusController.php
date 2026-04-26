<?php

namespace App\Http\Controllers\Kasubag;

use App\Models\Kampus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class KampusController extends Controller
{
    public function index()
    {
        $kampus = Kampus::withCount('gedung')->latest()->get();
        return view('layouts.kasubag.ruangan.kampus', compact('kampus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kampus' => 'required|string|max:50|unique:kampus,nama_kampus',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = Str::slug($request->nama_kampus);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kampus', 'public');
        }

        Kampus::create([
            'nama_kampus' => $request->nama_kampus,
            'slug' => $slug,
            'foto' => $fotoPath
            ]);

        Alert::success('Berhasil', 'Kampus berhasil ditambahkan');
        return redirect()->route('kasubag.kampus.index')->with('success', 'Kampus berhasil ditambahkan.');
    }

    public function update(Request $request, Kampus $kampus)
    {
        $request->validate([
            'nama_kampus' => 'required|string|max:50|unique:kampus,nama_kampus,' . $kampus->id,
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->nama_kampus !== $kampus->nama_kampus) {
            $exists = Kampus::where('nama_kampus', $request->nama_kampus)->exists();
            if ($exists) {
                Alert::error('Gagal', 'Kampus dengan nama tersebut sudah ada.');
                return back()->withErrors([
                    'nama_kampus' => 'Kampus dengan nama tersebut sudah ada.'
                ]);
            }
        }

        $slug = Str::slug($request->nama_kampus);

        if ($kampus->nama_kampus !== $request->nama_kampus) {
            $kampus->update(['nama_kampus' => $request->nama_kampus, 'slug' => $slug]);
        } else {
            $kampus->update(['slug' => $slug]);
        }

        if ($request->hasFile('foto')) {
            if ($kampus->foto) {
                Storage::disk('public')->delete($kampus->foto);
            }
            $fotoPath = $request->file('foto')->store('kampus', 'public');
            $kampus->update(['foto' => $fotoPath]);
        }

        Alert::success('Berhasil', 'Kampus berhasil diperbarui');
        return redirect()->route('kasubag.kampus.index')->with('success', 'Kampus berhasil diperbarui.');
    }

    public function destroy(Kampus $kampus)
    {

        if ($kampus->foto) {
            Storage::disk('public')->delete($kampus->foto);
        }

        $kampus->delete();

        Alert::success('Berhasil', 'Kampus berhasil dihapus');
        return redirect()->route('kasubag.kampus.index')->with('success', 'Kampus berhasil dihapus.');
    }


}

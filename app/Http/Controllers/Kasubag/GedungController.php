<?php

namespace App\Http\Controllers\Kasubag;

use App\Models\Gedung;
use App\Models\Kampus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class GedungController extends Controller
{
    public function index( Request $request, $slug )
    {
        $kampus = Kampus::where('slug', $slug)->firstOrFail();

        $gedungList = Gedung::with(['kampus', 'user'])->withCount('ruangan')
                    ->where('kampus_id', $kampus->id)
                    ->latest()->get();

        $gedung  = Gedung::with(['kampus', 'user'])->withCount('ruangan')
                    ->where('kampus_id', $kampus->id)
                    ->latest()->get();

        $users   = User::with('roles')->where(function($query) {
            $query->whereHas('roles', function($q) {
                $q->whereIn('nama', ['sarpras']);
            });
        })->get();

        return view('layouts.kasubag.ruangan.gedung', compact('gedung','gedungList', 'kampus', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kampus_id' => 'required|exists:kampus,id',
            'nama'      => 'required|string|max:25',
            'id_user'   => 'required|exists:user,nomor_induk',
            'lantai'    => 'required|integer|min:1|max:200',
        ]);

        $exists = Gedung::where('kampus_id', $request->kampus_id)
                        ->where('nama', $request->nama)
                        ->exists();

        if ($exists) {
                Alert::error('Gagal', 'Gedung dengan nama tersebut sudah ada di kampus ini.');
            return back()->withErrors([
                'nama' => 'Gedung dengan nama tersebut sudah ada di kampus ini.'
            ]);
        }

        $slug = Str::slug($request->nama);

        $gedung = Gedung::create([
            'kampus_id' => $request->kampus_id,
            'nama'      => $request->nama,
            'slug'      => $slug,
            'id_user'   => $request->id_user,
            'lantai'    => $request->lantai,
        ]);

        $kampusSlug = $gedung->kampus->slug;

        Alert::success('Berhasil', 'Gedung berhasil ditambahkan');
        return redirect()->route('kasubag.gedung.index', [
            'slug' => $kampusSlug
        ])->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function update(Request $request, Gedung $gedung)
    {
        $request->validate([
            'kampus_id' => 'required|exists:kampus,id',
            'nama'      => 'required|string|max:25',
            'id_user'   => 'required|exists:user,nomor_induk',
            'lantai'    => 'required|integer|min:1|max:200',
        ]);

        $exists = Gedung::where('kampus_id', $request->kampus_id)
                         ->where('nama', $request->nama)
                         ->where('id', '!=', $gedung->id)
                         ->exists();

        if ($exists) {
            Alert::error('Gagal', 'Gedung dengan nama tersebut sudah ada di kampus ini.');
            return back()->withErrors([
                'nama' => 'Gedung dengan nama tersebut sudah ada di kampus ini.'
            ])->withInput();
        }

        $gedung->update($request->only('kampus_id', 'nama', 'id_user', 'lantai'));
        $gedung->load(['kampus', 'user']);

        Alert::success('Berhasil', 'Gedung berhasil diperbarui');
        return redirect()->route('kasubag.gedung.index', [
            'slug' => $gedung->kampus->slug
        ])->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();

        Alert::success('Berhasil', 'Gedung berhasil dihapus');
        return redirect()->route('kasubag.gedung.index', [
            'slug' => $gedung->kampus->slug
        ])->with('success', 'Gedung berhasil dihapus.');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\BahanBakuModel;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $query = BahanBakuModel::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        $bahanBakus = $query->latest()->get();

        return view('gudang.bahanbaku.index', compact('bahanBakus'));
    }

    public function create()
    {
        return view('gudang.bahanbaku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:120',
            'kategori' => 'nullable|string|max:60',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_masuk',
        ]);

        BahanBakuModel::create($validated);

        return redirect()->route('gudang.bahan-baku.index')->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    public function edit(BahanBakuModel $bahanBaku)
    {
        return view('gudang.bahanbaku.edit', compact('bahanBaku'));
    }

    public function update(Request $request, BahanBakuModel $bahanBaku)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:120',
            'kategori' => 'nullable|string|max:60',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_masuk',
        ]);
        
        $bahanBaku->update($validated);

        return redirect()->route('gudang.bahan-baku.index')->with('success', 'Data bahan baku berhasil diupdate!');
    }

    public function destroy(BahanBakuModel $bahanBaku)
    {
        if ($bahanBaku->status != 'kadaluarsa') {
            return back()->with('error', 'Gagal! Hanya bahan baku yang sudah kadaluarsa yang boleh dihapus.');
        }

        $bahanBaku->delete();
        return redirect()->route('gudang.bahan-baku.index')->with('success', 'Bahan baku kadaluarsa berhasil dihapus.');
    }
}
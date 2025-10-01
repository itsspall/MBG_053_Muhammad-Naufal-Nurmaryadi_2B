<?php

namespace App\Http\Controllers;

use App\Models\BahanBakuModel as BahanBaku;
use App\Models\PermintaanModel as Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermintaanDapurController extends Controller
{
    public function index()
    {
        $permintaans = Permintaan::where('pemohon_id', auth()->id())
                                ->with('pemohon', 'details.bahanBaku')
                                ->latest()
                                ->get();
        return view('dapur.permintaan.index', compact('permintaans'));
    }

    public function create()
    {
        $bahanTersedia = BahanBaku::where('jumlah', '>', 0)
                                ->get()
                                ->filter(fn($bahan) => $bahan->status !== 'kadaluarsa');
                                
        return view('dapur.permintaan.create', compact('bahanTersedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_masak' => 'required|date|after_or_equal:today',
            'menu_makan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'bahan' => 'required|array|min:1',
            'bahan.*.id' => 'required|exists:bahan_baku,id',
            'bahan.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat data utama permintaan
            $permintaan = Permintaan::create([
                'pemohon_id' => auth()->id(),
                'tgl_masak' => $request->tgl_masak,
                'menu_makan' => $request->menu_makan,
                'jumlah_porsi' => $request->jumlah_porsi,
                'status' => 'menunggu',
            ]);

            // 2. Simpan detail bahan yang diminta
            foreach ($request->bahan as $bahan) {
                $permintaan->details()->create([
                    'bahan_id' => $bahan['id'],
                    'jumlah_diminta' => $bahan['jumlah'],
                ]);
            }
        });

        return redirect()->route('dapur.permintaan.index')->with('success', 'Permintaan berhasil dibuat!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\PermintaanModel as Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermintaanGudangController extends Controller
{
    public function index()
    {
        $permintaans = Permintaan::with('pemohon', 'details.bahanBaku')->latest()->get();
        return view('gudang.permintaan.index', compact('permintaans'));
    }

    // Memproses persetujuan/penolakan permintaan
    public function proses(Request $request, Permintaan $permintaan)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        if ($request->status == 'disetujui') {
            try {
                DB::transaction(function () use ($permintaan) {
                    foreach ($permintaan->details as $detail) {
                        $bahan = $detail->bahanBaku;
                        if ($bahan->jumlah < $detail->jumlah_diminta) {
                            // munculkan exception jika stok tidak mencukupi
                            throw new \Exception('Stok ' . $bahan->nama . ' tidak mencukupi.');
                        }
                        $bahan->decrement('jumlah', $detail->jumlah_diminta);
                    }
                    $permintaan->update(['status' => 'disetujui']);
                });

            } catch (\Exception $e) {
                // mengambil exception, lalu menampilkan pesan error
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            $permintaan->update(['status' => 'ditolak']);
        }

        return redirect()->route('gudang.permintaan.index')->with('success', 'Permintaan berhasil diproses!');
    }
}
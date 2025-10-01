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
            DB::transaction(function () use ($permintaan) {
                foreach ($permintaan->details as $detail) {
                    $bahan = $detail->bahanBaku;
                    if ($bahan->jumlah < $detail->jumlah_diminta) {
                        // Error handling: jika stok tidak cukup = batalkan transaksi
                        throw new \Exception('Stok ' . $bahan->nama . ' tidak mencukupi.');
                    }
                    $bahan->decrement('jumlah', $detail->jumlah_diminta);
                }
                $permintaan->update(['status' => 'disetujui']);
            });
        } else {
            // Error handling: jika ditolak = update status
            $permintaan->update(['status' => 'ditolak']);
        }

        return redirect()->route('gudang.permintaan.index')->with('success', 'Permintaan berhasil diproses!');
    }
}
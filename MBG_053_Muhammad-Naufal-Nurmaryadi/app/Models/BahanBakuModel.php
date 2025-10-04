<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanBakuModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bahan_baku';

    protected $fillable = [
        'nama',
        'kategori',
        'jumlah',
        'satuan',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'status',
    ];
    
    public function getStatusAttribute($value)
    {
        $today = Carbon::now()->startOfDay();
        $expiredDate = Carbon::parse($this->tanggal_kadaluarsa);

        if ($this->jumlah == 0) {
            return 'habis';
        }
        if ($today->gt($expiredDate)) {
            return 'kadaluarsa';
        }
        if ($today->addDays(3)->gte($expiredDate)) {
            return 'segera_kadaluarsa';
        }
        return 'tersedia';
    }

    public function permintaanDetails()
    {
        return $this->hasMany(PermintaanDetail::class, 'bahan_id');
    }
}
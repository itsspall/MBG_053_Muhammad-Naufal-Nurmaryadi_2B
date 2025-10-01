<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PermintaanModel;
use App\Models\BahanBakuModel;

class PermintaanDetailModel extends Model
{
    use HasFactory;
    
    protected $table = 'permintaan_detail';
    
    public $timestamps = false;

    protected $fillable = [
        'permintaan_id',
        'bahan_id',
        'jumlah_diminta',
    ];
    
    public function permintaan()
    {
        return $this->belongsTo(PermintaanModel::class, 'permintaan_id');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBakuModel::class, 'bahan_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckHarian extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'check_harian';  // Pastikan nama tabel sesuai di database

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'user_id',
        'tanggal',
        'suhu',
        'suhu_tubuh',
        'berat',
        'berat_badan',
        'nafsu_makan',
        'minum_obat',
        'status_minum_obat',
        'alasan_tidak_minum',
        'frekuensi_batuk',
        'berkeringat_malam',
        'catatan_pete',
        'catatan_bebas',
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


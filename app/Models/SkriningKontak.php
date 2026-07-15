<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkriningKontak extends Model
{
    use HasFactory;

    protected $table = 'skrining_kontak';

    protected $fillable = [
        'user_id',
        'nama_anggota_keluarga',
        'status_gejala',
        'rekomendasi_tindakan',
    ];

    protected function casts(): array
    {
        return [
            'status_gejala' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
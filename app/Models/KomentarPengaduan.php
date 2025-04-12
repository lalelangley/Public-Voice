<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarPengaduan extends Model
{
    protected $table = 'komentar_pengaduan';

    protected $fillable = [
        'pengaduan_id', 'masyarakat_id', 'isi'
    ];

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'masyarakat_id');
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 'pengaduan'; // Paksa Laravel pakai tabel 'pengaduan'
    protected $fillable = [
        'id_masyarakat',
        'judul',
        'isi_laporan',
        'foto',
        'tanggal_kejadian',
        'lokasi_kejadian',
        'anonim',
        'status',
        'divisi',
    ];    
    
        public function masyarakat(){
        return $this->belongsTo(Masyarakat::class, 'id_masyarakat');
    }   
    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class, 'pengaduan_id');
    }    
    public function likes()
    {
        return $this->hasMany(LikePengaduan::class, 'pengaduan_id');
    }
    public function komentar()
    {
        return $this->hasMany(\App\Models\KomentarPengaduan::class, 'pengaduan_id');
    }
}

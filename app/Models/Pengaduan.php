<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 'pengaduan';
    protected $fillable = [
        'id_masyarakat',
        'judul',
        'isi_laporan',
        'kategori',
        'foto',
        'status',
    ];    
        public function masyarakat(){
        return $this->belongsTo(Masyarakat::class, 'id_masyarakat', 'id_masyarakat');
    }   
    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class);
    }
}

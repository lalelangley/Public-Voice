<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    use HasFactory;

    protected $table = 'tanggapan'; // Pastikan pakai nama tabel yang benar
    protected $fillable = ['pengaduan_id', 'tgl_tanggapan', 'tanggapan', 'id_petugas'];

    public $timestamps = true;
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }    
}

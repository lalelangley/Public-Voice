<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikePengaduan extends Model
{
    protected $table = 'likes_pengaduan';
    protected $fillable = ['pengaduan_id', 'masyarakat_id'];

    public function likes()
    {
        return $this->hasMany(LikePengaduan::class, 'pengaduan_id');
    }
}

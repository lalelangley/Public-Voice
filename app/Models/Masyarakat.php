<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Masyarakat extends Authenticatable
{
    use Notifiable;

    protected $table = 'masyarakat';
    protected $primaryKey = 'id_masyarakat';
    public $timestamps = true;

    protected $fillable = [
        'nik',
        'nama',
        'username',
        'password',
        'telp',
        'tempat_tinggal',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'disabilitas',
        'email',
        'token',
        'google_id',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    public function findByEmail($email)
    {
     return Masyarakat::where('email', $email)->first();
    }
    public function getAuthIdentifierName()
    {
        return 'id_masyarakat';
    }

}

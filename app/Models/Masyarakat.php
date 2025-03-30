<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Masyarakat extends Authenticatable
{
    protected $table = 'masyarakat';
    protected $primaryKey = 'id_masyarakat';

    protected $fillable = [
        'nik', 'nama', 'username', 'password', 'telp',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}


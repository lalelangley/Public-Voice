<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; // Tambahkan ini untuk fitur notifikasi Laravel

class Petugas extends Authenticatable
{
    use HasFactory, Notifiable; // Tambahkan Notifiable untuk fitur seperti reset password

    protected $table = 'petugas'; // Pastikan ini sesuai dengan nama tabel di database

    protected $fillable = [
        'nama',
        'username',
        'password',
        'telp',
        'email',
        'level',
        'divisi',
    ];

    protected $hidden = [
        'password', 
        'remember_token', // Tambahkan ini biar token tidak terlihat
    ];

    protected $casts = [
        'password' => 'hashed', // Laravel 10+ support hashing otomatis
    ];
}

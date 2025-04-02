<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Masyarakat extends Authenticatable
{
    use Notifiable;

    protected $table = 'masyarakat';
    protected $primaryKey = 'id_masyarakat'; // Pastikan primary key benar
    public $timestamps = true;

    protected $fillable = [
        'nama', 'nik', 'email', 'password', 'username', 'telp', 'foto', 'google_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

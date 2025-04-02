<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
class Masyarakat extends Authenticatable
{
    protected $table = 'masyarakat';
    protected $primaryKey = 'id_masyarakat'; 
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nama', 'nik', 'email', 'password',  'username','telp', 'foto', 'google_id', 'email']; 

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

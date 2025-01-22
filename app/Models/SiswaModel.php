<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class SiswaModel extends Model implements JWTSubject
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nama_siswa', 'alamat', 'telp', 'foto', 'id_users'];
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

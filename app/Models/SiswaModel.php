<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nama_siswa', 'alamat', 'telp', 'foto', 'id_users'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['tanggal', 'id_stan', 'id_siswa', 'status'];
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_siswa');
    }
}

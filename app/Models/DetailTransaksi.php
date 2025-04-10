<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id_transaksi', 'id_menu', 'qty', 'harga_beli'];
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}

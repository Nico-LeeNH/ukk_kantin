<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;
    protected $table = 'diskon';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nama_diskon', 'persentase_diskon', 'tanggal_awal', 'tanggal_akhir', 'id_stan'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_diskon', 'id',  'id_diskon');
    }
}



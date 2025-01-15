<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nama_makanan', 'harga', 'jenis', 'foto', 'deskripsi', 'id_stan'];
    public function diskons()
    {
        return $this->belongsToMany(Diskon::class, 'menu_diskon','id',  'id_diskon');
    }
}


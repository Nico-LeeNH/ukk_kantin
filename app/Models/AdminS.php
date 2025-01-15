<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminS extends Model
{
    use HasFactory;
    protected $table = 'stan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nama_stan', 'nama_pemilik', 'telp', 'id_users'];
}

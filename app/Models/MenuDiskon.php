<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuDiskon extends Model
{
    use HasFactory;
    protected $table = 'menu_diskon';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id_menu', 'id_diskon'];
}

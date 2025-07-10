<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'tbbarang';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['id_barang', 'nm_barang', 'kategori', 'stok', 'status', 'foto', 'kondisi'];
    public $timestamps = false;
    protected $keyType = 'string';
}

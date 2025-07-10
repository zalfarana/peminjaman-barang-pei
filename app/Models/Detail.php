<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    protected $table = 'tbdetail';
    protected $primaryKey = 'id_detail';
    protected $fillable = ['id_detail', 'id_peminjaman', 'id_barang', 'jumlah'];
    public $timestamps = false;
    protected $keyType = 'string';
}

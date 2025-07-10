<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serahterima extends Model
{
    use HasFactory;
    protected $table = 'tbserahterima';
    protected $primaryKey = 'id_serahterima';
    protected $fillable = ['id_serahterima', 'id_peminjaman', 'id_detail', 'tgl_pengambilan', 'tgl_pengembalian'];
    public $timestamps = false;
    protected $keyType = 'string';
}

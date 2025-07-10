<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'tbpeminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['id_peminjaman', 'id_user', 'tgl_pengajuan', 'tgl_mulai', 'tgl_selesai', 'ktm', 'statusp', 'tujuan'];
    public $timestamps = false;
    protected $keyType = 'string';
}

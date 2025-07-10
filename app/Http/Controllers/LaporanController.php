<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Detail;
use App\Models\Serahterima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $rekapBarang = [];
        if ($bulan) {
            $rekapBarang = DB::table('tbdetail')
                ->join('tbpeminjaman', 'tbdetail.id_peminjaman', '=', 'tbpeminjaman.id_peminjaman')
                ->join('tbbarang', 'tbdetail.id_barang', '=', 'tbbarang.id_barang')
                ->whereMonth('tbpeminjaman.tgl_selesai', $bulan)
                ->select('tbbarang.nm_barang', DB::raw('SUM(tbdetail.jumlah) as total_dipinjam'))
                ->groupBy('tbbarang.nm_barang')
                ->get();
        }
        $peminjaman = Peminjaman::join('users', 'tbpeminjaman.id_user', '=', 'users.id_user')
            ->select('tbpeminjaman.*', 'users.nama')
            ->get();

        return view('laporan.laporan', [
            'peminjaman' => $peminjaman,
            'rekapBarang' => $rekapBarang,
            'bulan' => $bulan
        ]);
    }
}

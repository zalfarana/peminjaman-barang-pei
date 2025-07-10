<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Detail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $jumlahPeminjaman = Peminjaman::where('statusp', 'dipinjam')->count();
        $jumlahBarang = Barang::count();
        $menungguAdmin = Peminjaman::where('statusp', 'pending')->count();
        $terlamabat = Peminjaman::where('statusp', 'overdue')->count();
        $menungguWadir = Peminjaman::where('statusp', 'menunggu approval')->count();
        $peminjaman = Peminjaman::join('users', 'tbpeminjaman.id_user', '=', 'users.id_user')
            ->where('tbpeminjaman.id_user', $user->id_user)
            ->select('tbpeminjaman.*', 'users.nama')
            ->get(['users.*', 'tbpeminjaman.*']); 
        // Ambil 5 barang paling banyak dipinjam
        $barangPopuler = DB::table('tbdetail')
            ->join('tbbarang', 'tbdetail.id_barang', '=', 'tbbarang.id_barang')
            ->select('tbbarang.nm_barang', 'tbbarang.kondisi', 'tbbarang.stok', 'tbbarang.foto', DB::raw('SUM(tbdetail.jumlah) as total_dipinjam'))
            ->groupBy('tbbarang.id_barang', 'tbbarang.nm_barang', 'tbbarang.kondisi', 'tbbarang.stok', 'tbbarang.foto')
            ->orderByDesc('total_dipinjam')
            ->limit(5)
            ->get();
        return view('dashboard', ['jumlahPeminjaman' => $jumlahPeminjaman,
                                 'jumlahBarang' => $jumlahBarang,
                                 'menungguAdmin' => $menungguAdmin,
                                 'terlamabat' => $terlamabat,
                                 'menungguWadir' => $menungguWadir,
                                 'peminjaman' => $peminjaman,
                                 'barangPopuler' => $barangPopuler]);
    }
}

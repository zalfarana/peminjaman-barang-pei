<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Detail;
use Carbon\Carbon;
use App\Models\Serahterima;

use Illuminate\Http\Request;

class SerahterimaController extends Controller
{
    public function index()
    {
        $serahterima = Serahterima::leftjoin('tbpeminjaman', 'tbserahterima.id_peminjaman', '=', 'tbpeminjaman.id_peminjaman')
        ->leftjoin('users', 'tbpeminjaman.id_user', '=', 'users.id_user') 
        ->select('tbserahterima.*', 'tbpeminjaman.*', 'users.nama')
        ->get();

        foreach ($serahterima as $st) {
            if (
                $st->statusp == 'Dipinjam' &&
                empty($st->tgl_pengembalian) &&
                Carbon::now()->gt(Carbon::parse($st->tgl_selesai)->addDay())
            ) {
                $st->statusp = 'Overdue';
                // Update ke database juga
                Peminjaman::where('id_peminjaman', $st->id_peminjaman)
                    ->update(['statusp' => 'Overdue']);
            }
        }

        return view('serahterima.serah-terima',  ['serahterima' => $serahterima]);
    }
    public function simpan(Request $idSerahterima)
    {
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus angka',
            'email' => ':attribute tidak valid',
            'string' => ':attribute harus berupa string',
            'max' => ':attribute tidak boleh lebih dari :max karakter',
            'min' => ':attribute tidak boleh kurang dari :min karakter',
            'unique' => ':attribute sudah terdaftar',
            'image' => ':attribute harus berupa gambar',
        ];
        $validasiData = $idSerahterima->validate([
            'id_serahterima' => 'required',
            'id_peminjaman' => 'required',
            'tgl_pengambilan' => 'required',
        ], $message);

        Serahterima::create(
            [
                'id_serahterima' => $validasiData['id_serahterima'],
                'id_peminjaman' => $validasiData['id_peminjaman'],
                'tgl_pengambilan' => $validasiData['tgl_pengambilan'],
            ]
        );
        // Update status peminjaman
        Peminjaman::where('id_peminjaman', $validasiData['id_peminjaman'])
                ->update(['statusp' => 'Dipinjam']);
        return redirect('/serah-terima')->with('success', 'Data Serah terima Berhasil Ditambahkan');
    }
    public function update(Request $st, $idSerahterima)
    {
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus angka',
            'email' => ':attribute tidak valid',
            'string' => ':attribute harus berupa string',
            'max' => ':attribute tidak boleh lebih dari :max karakter',
            'min' => ': attribute tidak boleh kurang dari :min karakter',
            'unique' => ':attribute sudah terdaftar',
            'image' => ':attribute harus berupa gambar',
        ];
        
        $validasiData = $st->validate([
            'tgl_pengembalian' => 'required',
            'id_peminjaman' => 'required'
        ], $message);

        $data_st = Serahterima::find($idSerahterima);
        $data_st->update([
            'tgl_pengembalian' => $validasiData['tgl_pengembalian'],
        ]);
        // Update status peminjaman
        Peminjaman::where('id_peminjaman', $validasiData['id_peminjaman'])
                ->update(['statusp' => 'Selesai']);

        // Kembalikan stok barang
        $details = \App\Models\Detail::where('id_peminjaman', $validasiData['id_peminjaman'])->get();
        foreach ($details as $detail) {
            $barang = \App\Models\Barang::find($detail->id_barang);
            if ($barang) {
                $barang->stok += $detail->jumlah;
                $barang->save();
            }
        }
        return redirect('/serah-terima');
    }
}

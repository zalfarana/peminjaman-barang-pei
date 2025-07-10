<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Detail;
use App\Models\Serahterima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Mail\NotifikasiMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::join('users', 'tbpeminjaman.id_user', '=', 'users.id_user')
            ->select('tbpeminjaman.*', 'users.nama')
            ->get(['users.*', 'tbpeminjaman.*']);
        $lastSerahTerima = Serahterima::orderBy('id_serahterima', 'desc')->first();
        if ($lastSerahTerima) {
            $lastId = $lastSerahTerima->id_serahterima; 
            $number = (int) substr($lastId, 2); 
            $lastSerahTerima = 'ST' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $lastSerahTerima = 'ST000001';
        }

        return view('peminjaman.peminjaman', [
            'peminjaman' => $peminjaman,
            'lastSerahTerima' => $lastSerahTerima,
        ]);
    }

    public function tambahPeminjaman()
    {
        $lastPeminjaman = Peminjaman::orderBy('id_peminjaman', 'desc')->first();

        if ($lastPeminjaman) {
            $lastId = $lastPeminjaman->id_peminjaman;
            $number = (int) substr($lastId, 3);
            $lastPeminjaman = 'PMJ' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $lastPeminjaman = 'PMJ000001';
        }
        
        $barang = Barang::all();
        return view('peminjaman.tambah-peminjaman', ['lastPeminjaman' => $lastPeminjaman, 'barang' => $barang]);
    }
    
    public function simpan(Request $idPinjam)
    {
        $user = Auth::user();

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
        $validasiData = $idPinjam->validate([
            'id_peminjaman' => 'required',
            'tgl_pengajuan' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'ktm' => 'required',
            'tujuan' => 'required',
            'nama_barang' => 'required|array',
            'jumlah' => 'required|array',
        ], $message);
        
        $data_ktm = $idPinjam->file('ktm');
        $ktm = time() . "-" . $data_ktm->getClientOriginalName();
        $namaFolder = 'ktm';
        $data_ktm->move($namaFolder, $ktm);
        $pathPublic = $namaFolder . "/" . $ktm;

        // Cek stok barang
        foreach ($idPinjam->nama_barang as $index => $id_barang) {
            $barang = \App\Models\Barang::find($id_barang);
            $jumlahPinjam = $idPinjam->jumlah[$index];

            if (!$barang || $barang->stok < $jumlahPinjam) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Stok barang "' . ($barang->nm_barang ?? 'Tidak Ditemukan') . '" tidak mencukupi!');
            }
        }
        Peminjaman::create(
            [
                'id_peminjaman' => $validasiData['id_peminjaman'],
                'id_user' => $user->id_user,
                'tgl_pengajuan' => $validasiData['tgl_pengajuan'],
                'tgl_mulai' => $validasiData['tgl_mulai'],
                'tgl_selesai' => $validasiData['tgl_selesai'],
                'ktm' => $pathPublic,
                'statusp' => "Pending",
                'tujuan' => $validasiData['tujuan'],
            ]
        
        );
        foreach ($idPinjam->nama_barang as $index => $id_barang) {
            $lastDetail = Detail::orderBy('id_detail', 'desc')->first();

            if ($lastDetail) {
                $lastId = $lastDetail->id_detail;
                $number = (int) substr($lastId, 3);
                $lastDetail = 'DTL' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $lastDetail = 'DTL000001';
            }

            Detail::create([
                'id_detail' => $lastDetail,
                'id_peminjaman' => $idPinjam->id_peminjaman,
                'id_barang' => $id_barang,
                'jumlah' => $idPinjam->jumlah[$index],
            ]);
            // Kurangi stok barang
            $barang = Barang::find($id_barang);
            if ($barang) {
                $barang->stok = $barang->stok - $idPinjam->jumlah[$index];
                $barang->save();
            }
        }
        return redirect('/')->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function updateStatusAdm($idPinjam)
    {
        $pinjam = Peminjaman::find($idPinjam);
        $pinjam->statusp = 'Menunggu Approval';
        $pinjam->save();
        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }
    public function updateStatusWd($idPinjam)
    {
        $pinjam = Peminjaman::find($idPinjam);
        $pinjam->statusp = 'Disetujui';
        $pinjam->save();
        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }
    public function updateStatusSt($idPinjam)
    {
        $pinjam = Peminjaman::find($idPinjam);
        $pinjam->statusp = 'Dipinjam';
        $pinjam->save();
        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }
    public function delete($idPinjam)
    {
        $pinjam = Peminjaman::find($idPinjam);
        $pinjam->statusp = 'Tidak disetujui';
        $pinjam->save();

         // Kembalikan stok barang
        $details = Detail::where('id_peminjaman', $idPinjam)->get();
        foreach ($details as $detail) {
            $barang = Barang::find($detail->id_barang);
            if ($barang) {
                $barang->stok += $detail->jumlah;
                $barang->save();
            }
        }

        $users = User::find($pinjam->id_user);
        $email = $users->email;
        Mail::to($email)->send(new NotifikasiMail());
        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }
    
}

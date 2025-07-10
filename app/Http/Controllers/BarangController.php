<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BarangController extends Controller
{
    public function index()
    {
         $barang = Barang::all();
        return view('barang.barang', ['barang' => $barang]);
    }
    public function tambahBarang()
    {
        $lastBarang = Barang::orderBy('id_barang', 'desc')->first();

        if ($lastBarang) {
            $lastId = $lastBarang->id_barang;
            $number = (int) substr($lastId, 3);
            $lastBarang = 'B' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $lastBarang = 'B0001';
        }
        $barang = Barang::all();
        return view('barang.tambah-barang', ['lastBarang' => $lastBarang, 'barang' => $barang]);
    }
    public function simpan(Request $idBrg)
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
        $validasiData = $idBrg->validate([
            'id_barang' => 'required',
            'nm_barang' => 'required|string',
            'kategori' => 'required|string',
            'stok' => 'required|numeric',
            'status' => 'required|string',
            'foto' => 'required',
            'kondisi' => 'required|string',
        ], $message);
        
        $data_foto = $idBrg->file('foto');
        $foto = time() . "-" . $data_foto->getClientOriginalName();
        $namaFolder = 'foto';
        $data_foto->move($namaFolder, $foto);
        $pathPublic = $namaFolder . "/" . $foto;

        Barang::create(
            [
                'id_barang' => $validasiData['id_barang'],
                'nm_barang' => $validasiData['nm_barang'],
                'kategori' => $validasiData['kategori'],
                'stok' => $validasiData['stok'],
                'status' => $validasiData['status'],
                'foto' => $pathPublic,
                'kondisi' => $validasiData['kondisi'],
            ]
        );
        
        return redirect('/barang')->with('success', 'Data Barang Berhasil Ditambahkan');
    }
    public function edit($idBrg)
    {
        $data_brg = Barang::find($idBrg);
        return view('barang.edit-barang', ['brg' => $data_brg]);
    }
    public function update(Request $brg)
    {
        $data_foto = $brg->file('foto');
        if ($data_foto) {
            $foto = time() . "-" . $data_foto->getClientOriginalName();
            $namaFolder = 'foto';
            $data_foto->move($namaFolder, $foto);
            $pathPublic = $namaFolder . "/" . $foto;
        } else {
            $pathPublic = $brg->foto_lama; // pastikan name input hidden = foto_lama
        }
        
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
        
        $validasiData = $brg->validate([
            'id_barang' => 'required',
            'nm_barang' => 'required',
            'kategori' => 'required',
            'stok' => 'required',
            'status' => 'required',
            'kondisi' => 'required',
        ], $message);

        $data_brg = Barang::find($validasiData['id_barang']);
        $data_brg->update([
            'nm_barang' => $validasiData['nm_barang'],
            'kategori' => $validasiData['kategori'],
            'stok' => $validasiData['stok'],
            'status' => $validasiData['status'],
            'foto' => $pathPublic,
            'kondisi' => $validasiData['kondisi'],
        ]);
        return redirect('/barang');
    }
      public function delete($idBrg)
    {
        $data_brg = Barang::find($idBrg);
        $data_brg->delete();
        File::delete(public_path($data_brg->foto));
        return redirect('/barang')->with('success', 'Data Barang Berhasil Dihapus');
    }
}
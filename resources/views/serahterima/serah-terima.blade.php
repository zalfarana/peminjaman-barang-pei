@extends('layout')

@section('title')
    Serah Terima
@endsection

@section('content')
  <style>
    .arrow::before {
      content: "▼";
      display: inline-block;
      margin-right: 8px;
    }
    .arrow.collapsed::before {
      content: "▶";
    }
    tr[role="button"] td {
      user-select: none;
    }
  </style>
<!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <h1 class="mb-0 text-uppercase">Data Serah terima</h1>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Serah Terima</th>
                                    <th>Nama Peminjam</th>
                                    <th>Tanggal Pengambilan</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>KTM</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($serahterima as $st)
                                @if($st->statusp == 'Dipinjam' || $st->statusp == 'Overdue')
                                <tr>
                                    <td>{{$st->id_serahterima}}</td>
                                    <td>{{$st->nama}}</td>
                                    <td>{{$st->tgl_pengambilan}}</td>
                                    <td>{{$st->tgl_pengembalian}}</td>
                                    <td><img src="{{ $st->ktm }}" width="80px" height="50px" style="object-fit:cover; border-radius:6px;"></td>
                                    <td>
                                        <span class="badge {{ $st->statusp == 'Dipinjam' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $st->statusp }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#{{ $st->id_peminjaman }}Modal" data-tujuan="{{ $st->tujuan }}"><i class="bx bx-show"></i></button>
                                        <a href="#" class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editSerahTerimaModal{{ $st->id_serahterima }}">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                <!-- Tambah baris lain di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Barang -->
    @foreach($serahterima as $st)
        <div class="modal fade" id="{{ $st->id_peminjaman }}Modal" tabindex="-1" aria-labelledby="{{ $st->id_peminjaman }}ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Barang Peminjaman {{ $st->nama }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom: 5px;"><strong>Tujuan Pinjam: </strong>{{ $st->tujuan }}</p>
                    <p style="margin-bottom: 5px;"><strong>Detail Barang: </strong></p>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Detail</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $detailBarang = DB::table('tbdetail')
                                        ->join('tbbarang', 'tbdetail.id_barang', '=', 'tbbarang.id_barang')
                                        ->where('tbdetail.id_peminjaman', $st->id_peminjaman)
                                        ->select('tbdetail.*', 'tbbarang.*')
                                        ->get();
                                @endphp
                                @foreach($detailBarang as $barang)
                                    <tr>
                                        <td>{{ $barang->id_detail }}</td>
                                        <td>{{ $barang->nm_barang }}</td>
                                        <td>{{ $barang->jumlah }}</td>
                                        <td><span class="badge bg-success">{{ $barang->kondisi }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit Serah Terima --}}
    @foreach($serahterima as $st)
    <div class="modal fade" id="editSerahTerimaModal{{ $st->id_serahterima }}" tabindex="-1" aria-labelledby="editSerahTerimaModalLabel{{ $st->id_serahterima }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSerahTerimaModalLabel{{ $st->id_serahterima }}">Edit Data Serah Terima</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('serah-terima.update', $st->id_serahterima) }}" method="POST">
                        @csrf
                        @method('POST') {{-- Ganti ke PUT jika pakai route resource --}}
                        <div class="mb-3">
                            <label class="form-label">ID Serah Terima</label>
                            <input type="text" class="form-control" name="id_serahterima" value="{{ $st->id_serahterima }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ID Peminjaman</label>
                            <input type="text" class="form-control" name="id_peminjaman" value="{{ $st->id_peminjaman }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengambilan</label>
                            <input type="date" class="form-control" name="tgl_pengambilan" value="{{ $st->tgl_pengambilan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" name="tgl_pengembalian" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
<!--end page wrapper -->
@endsection

@section('scripts')
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
        } );
</script>
<!--app JS-->
<script src="assets/js/app.js"></script>
@endsection
@extends('layout')

@section('title')
    Peminjaman
@endsection

@section('content')
<!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <h1 class="mb-0 text-uppercase">Data Peminjaman</h1>
            <hr/>
            @if(Auth::user()->role == 'Admin')
            @if (Request::path()=='persetujuan-admin')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Peminjaman</th>
                                    <th>Nama</th>
                                    <th>KTM</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjaman as $pinjam)
                                @if($pinjam->statusp == 'Pending')
                                <tr>
                                    <td>{{ $pinjam->id_peminjaman }}</td>
                                    <td>{{ $pinjam->nama }}</td>
                                    <td><img src="{{ $pinjam->ktm }}" width="80px" height="50px" style="object-fit:cover; border-radius:6px;"></td>
                                    <td>{{ $pinjam->tgl_mulai }}</td>
                                    <td>{{ $pinjam->tgl_selesai }}</td>
                                    <td><span class="badge bg-warning">{{ $pinjam->statusp }}</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#{{ $pinjam->id_peminjaman }}Modal" data-tujuan="{{ $pinjam->tujuan }}"><i class="bx bx-show"></i></button>
                                        <a href="/update-status-peminjamanA/{{ $pinjam->id_peminjaman }}" class="btn btn-sm btn-success ">
                                            <i class="bx bx-check-circle"></i>
                                        </a>
                                        <a href="/hapus-peminjaman/{{ $pinjam->id_peminjaman }}" class="btn btn-sm btn-danger " title="Hapus" onclick="return confirm('Yakin ingin Menolak Pinjaman?')">
                                            <i class='bx bx-x-circle'></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @endif

            @if(Auth::user()->role == 'Wadir')
            @if (Request::path()=='persetujuan-wadir')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Peminjaman</th>
                                    <th>Nama</th>
                                    <th>KTM</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjaman as $pinjam)
                                @if($pinjam->statusp == 'Menunggu Approval')
                                <tr>
                                    <td>{{ $pinjam->id_peminjaman }}</td>
                                    <td>{{ $pinjam->nama }}</td>
                                    <td><img src="{{ $pinjam->ktm }}" width="80px" height="50px" style="object-fit:cover; border-radius:6px;"></td>
                                    <td>{{ $pinjam->tgl_mulai }}</td>
                                    <td>{{ $pinjam->tgl_selesai }}</td>
                                    <td><span class="badge bg-warning">{{ $pinjam->statusp }}</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#{{ $pinjam->id_peminjaman }}Modal" data-tujuan="{{ $pinjam->tujuan }}"><i class="bx bx-show"></i></button>
                                        <a href="/update-status-peminjamanW/{{ $pinjam->id_peminjaman }}" class="btn btn-sm btn-success ">
                                            <i class="bx bx-check-circle"></i>
                                        </a>
                                        <a href="/hapus-peminjaman/{{ $pinjam->id_peminjaman }}" class="btn btn-sm btn-danger " title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class='bx bx-x-circle'></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @endif

            @if(Auth::user()->role == 'Admin')
            @if (Request::path()=='pengambilan-barang')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Peminjaman</th>
                                    <th>Nama</th>
                                    <th>KTM</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjaman as $pinjam)
                                @if($pinjam->statusp == 'Disetujui')
                                <tr>
                                    <td>{{ $pinjam->id_peminjaman }}</td>
                                    <td>{{ $pinjam->nama }}</td>
                                    <td><img src="{{ $pinjam->ktm }}" width="80px" height="50px" style="object-fit:cover; border-radius:6px;"></td>
                                    <td>{{ $pinjam->tgl_mulai }}</td>
                                    <td>{{ $pinjam->tgl_selesai }}</td>
                                    <td><span class="badge bg-warning">{{ $pinjam->statusp }}</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#{{ $pinjam->id_peminjaman }}Modal" data-tujuan="{{ $pinjam->tujuan }}"><i class="bx bx-show"></i></button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#serahTerimaModal{{ $pinjam->id_peminjaman }}">
                                            Serah Terima
                                        </button>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @endif
            
        </div>
    </div>

    <!-- Modal Detail Barang -->
    @foreach($peminjaman as $pinjam)
        <div class="modal fade" id="{{ $pinjam->id_peminjaman }}Modal" tabindex="-1" aria-labelledby="{{ $pinjam->id_peminjaman }}ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Barang Peminjaman {{ $pinjam->nama }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom: 5px;"><strong>Tujuan Pinjam: </strong>{{ $pinjam->tujuan }}</p>
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
                                        ->where('tbdetail.id_peminjaman', $pinjam->id_peminjaman)
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

    <!-- Modal Serah Terima untuk setiap peminjaman -->
    @foreach($peminjaman as $pinjam)
    @if($pinjam->statusp == 'Disetujui')
    <div class="modal fade" id="serahTerimaModal{{ $pinjam->id_peminjaman }}" tabindex="-1" aria-labelledby="serahTerimaModalLabel{{ $pinjam->id_peminjaman }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serahTerimaModalLabel{{ $pinjam->id_peminjaman }}">Tambah Data Serah Terima</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah-serahterima') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="idSerahTerima{{ $pinjam->id_peminjaman }}" class="form-label">ID Serah Terima</label>
                            <input type="text" class="form-control" id="idSerahTerima{{ $pinjam->id_peminjaman }}" name="id_serahterima" value="{{$lastSerahTerima}}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="idPeminjaman{{ $pinjam->id_peminjaman }}" class="form-label">ID Peminjaman</label>
                            <input type="text" class="form-control" id="idPeminjaman{{ $pinjam->id_peminjaman }}" name="id_peminjaman" value="{{ $pinjam->id_peminjaman }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="namaPeminjam{{ $pinjam->id_peminjaman }}" class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control" id="namaPeminjam{{ $pinjam->id_peminjaman }}" name="nama" value="{{ $pinjam->nama }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tanggalPengambilan{{ $pinjam->id_peminjaman }}" class="form-label">Tanggal Pengambilan</label>
                            <input type="date" class="form-control" id="tanggalPengambilan{{ $pinjam->id_peminjaman }}" name="tgl_pengambilan" value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tanggalPengembalian{{ $pinjam->id_peminjaman }}" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="tanggalPengembalian{{ $pinjam->id_peminjaman }}" name="tgl_pengembalian" 
                                value="Input Setelah Barang Dikembalikan" readonly>
                        </div>
                        
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">
                                TAMBAH
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
@endsection

@section('scripts')
<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#example1').DataTable();
        } );
    $(document).ready(function() {
        $('#example2').DataTable();
        } );
    $(document).ready(function() {
        $('#example3').DataTable();
        } );
</script>
<!--app JS-->
<script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
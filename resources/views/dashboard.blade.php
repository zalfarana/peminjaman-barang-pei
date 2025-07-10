@extends('layout')

@section('title')
    Dashboard
@endsection

@section('content')
<!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--punya mhs-->
                @if(Auth::user()->role == 'Mahasiswa')
                    <div class="col">
						<div class="card">
							<img src="{{ asset('assets/images/gallery/04.png') }}" class="card-img-top" alt="..." style="max-height: 180px; object-fit: cover;">
							<div class="card-body">
								<h5 class="card-title">Selamat Datang</h5>
								<p class="card-text">Silakan ajukan peminjaman barang sesuai yang anda inginkan.</p>	
                                <a href="/tambah-peminjaman" class="btn btn-warning">Pinjam Barang</a>
							</div>
						</div>
					</div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
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
                                        <tr>
                                            <td>{{ $pinjam->id_peminjaman }}</td>
                                            <td>{{ $pinjam->nama }}</td>
                                            <td><img src="{{ $pinjam->ktm }}" width="80px" height="50px" style="object-fit:cover; border-radius:6px;"></td>
                                            <td>{{ $pinjam->tgl_mulai }}</td>
                                            <td>{{ $pinjam->tgl_selesai }}</td>
                                            <td>
                                                @if($pinjam->statusp == 'Tidak disetujui')
                                                <span class="badge rounded-pill bg-light-danger text-danger w-100">{{ $pinjam->statusp }}</span>
                                                @elseif($pinjam->statusp == 'Disetujui')
                                                    <span class="badge rounded-pill bg-light-success text-success w-100">{{ $pinjam->statusp }}</span>
                                                @elseif($pinjam->statusp == 'Overdue')
                                                    <div class="d-flex align-items-center text-danger">	<i class='bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1'></i>
                                                    <span>{{ $pinjam->statusp }}</span>
                                                    </div>
                                                @elseif($pinjam->statusp == 'Selesai')
                                                    <span class="badge rounded-pill bg-light-success text-success w-100">{{ $pinjam->statusp }}</span>
                                                @else
                                                    <span class="badge rounded-pill bg-light-warning text-warning w-100">{{ $pinjam->statusp }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#{{ $pinjam->id_peminjaman }}Modal" data-tujuan="{{ $pinjam->tujuan }}"><i class="bx bx-show"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Wadir')
                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5">
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3"><i class='bx bxs-group'></i>
                                    </div>
                                    <h4 class="my-1">{{ $jumlahPeminjaman }}</h4>
                                    <p class="mb-0 text-secondary">Peminjaman Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light-danger text-danger mb-3"><i class='bx bx-box'></i>
                                    </div>
                                    <h4 class="my-1">{{ $jumlahBarang }}</h4>
                                    <p class="mb-0 text-secondary">Total Barang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light-info text-info mb-3"><i class='bx bx-time-five'></i>
                                    </div>
                                    <h4 class="my-1">{{ $menungguAdmin }}</h4>
                                    <p class="mb-0 text-secondary">Menunggu Admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i class='bx bx-error'></i>
                                    </div>
                                    <h4 class="my-1">{{ $terlamabat }}</h4>
                                    <p class="mb-0 text-secondary">Terlambat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light-warning text-warning mb-3"><i class='bx bx-user-check'></i>
                                    </div>
                                    <h4 class="my-1">{{$menungguWadir}}</h4>
                                    <p class="mb-0 text-secondary">Menunggu Wadir</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-xl-2">
                    <div class="col-xl-8 d-flex">
                        <div class="card radius-10 w-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-1">Daftar Peminjaman</h5>
                                        <p class="mb-0 font-13 text-secondary"><i class='bx bxs-calendar'></i>in last 30 days revenue</p>
                                    </div>
                                    <div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                </div>
                                <div class="table-responsive mt-4">
                                    <table class="table align-middle mb-0 table-hover" id="Transaction-History">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Peminjam</th>
                                                <th>Tenggat Pengembalian</th>
                                                <th>Detail</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($peminjaman as $pinjam)
                                            @if($pinjam->statusp == 'Dipinjam' || $pinjam->statusp == 'Overdue')
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="">
                                                            <img src="{{ asset('assets/images/default-user.jpg') }}" class="rounded-circle" width="46" height="46" alt="" />
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">{{ $pinjam->nama }}</h6>
                                                            <p class="mb-0 font-13 text-secondary">Id {{ $pinjam->id_peminjaman }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $pinjam->tgl_selesai }}</td>
                                                <td>
                                                    <a href="serah-terima">Lihat</a>
                                                </td>
                                                <td>
                                                    <div class="badge rounded-pill bg-success w-100">{{ $pinjam->statusp }}</div>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-flex">
                        <div class="card radius-10 w-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-1">Barang Populer</h5>
                                        <p class="mb-0 font-13 text-secondary"><i class='bx bxs-calendar'></i>in last 30 days revenue</p>
                                    </div>
                                    <div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                </div>
                                <div class="product-list p-3 mb-3" style="height: 539px;">
                                @foreach($barangPopuler as $barang)
                                <div class="row border mx-0 mb-3 py-2 radius-10 cursor-pointer">
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center">
                                            <div class="product-img">
                                                <img src="{{ asset('/' . $barang->foto) }}" style="width:40px; height:40px; object-fit:cover; border-radius:6px;">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1">{{ $barang->nm_barang }}</h6>
                                                <p class="mb-0">{{ $barang->kondisi }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <h6 class="mb-1">{{ $barang->total_dipinjam }} kali dipinjam</h6>
                                        <p class="mb-0">stok {{ $barang->stok }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            @endif
        </div>
    </div>
<!--end page wrapper -->

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
@endsection


@section('scripts')
<!-- jQuery (paling awal) -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<!-- Bootstrap Bundle -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Plugin umum -->
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>

<!-- Plugin Chart & Map -->
<script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-knob/excanvas.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>

<script>
$(function () {
    $(".knob").knob();
    $('#menu').metisMenu();
});
</script>
<!-- Plugin Datatables -->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('#Transaction-History').DataTable({
    lengthMenu: [[6, 10, 20, -1], [6, 10, 20, 'Todos']]
    });

    $('#example').DataTable();

    var table = $('#example2').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'print']
    });

    table.buttons().container()
    .appendTo('#example2_wrapper .col-md-6:eq(0)');
});
</script>

<!-- Plugin Apexcharts (kalau dipakai) -->
<script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>

<!-- Script halaman spesifik -->
<script src="{{ asset('assets/js/index.js') }}"></script>
<script src="{{ asset('assets/js/dashboard-eCommerce.js') }}"></script>

<!-- App utama -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- Perfect Scrollbar tambahan -->
<script>
new PerfectScrollbar('.product-list');
new PerfectScrollbar('.customers-list');
</script>
@endsection
@extends('layout')

@section('title')
    Input Peminjaman
@endsection

@section('content')
@php use Carbon\Carbon; @endphp
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">Ajukan Peminjaman</h6>
        <hr/>
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body p-5">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="row g-3" action="/simpan-peminjaman" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5 class="mb-3 text-primary">Daftar Barang Yang Ingin Dipinjam *</h5>
                    <div id="barang-container">
                        <!-- ITEM BARANG PERTAMA -->
                        <div class="row mb-3 barang-item">
                            <div class="col-md-6">
                                <label class="form-label">Nama Barang *</label>
                                <select class="form-select" name="nama_barang[]" required>
                                    <option value="" selected disabled>Pilih Barang</option>
                                    @foreach ($barang as $brg)
                                        <option value="{{ $brg->id_barang }}">{{ $brg->nm_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jumlah *</label>
                                <input type="number" class="form-control" name="jumlah[]" required min="1" max="10" value="1">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-hapus-barang"><i class='bx bx-trash'></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL TAMBAH -->
                    <div class="mb-3">
                        <span class="text-primary cursor-pointer" id="tambah-barang"><i class="bx bx-plus"></i> Tambah Barang</span>
                    </div>

                    <!-- TANGGAL & TUJUAN -->
                    <div class="col-md-6">
                        <label class="form-label">ID Peminjaman</label>
                        <input type="text" class="form-control" value="{{ $lastPeminjaman }}" name="id_peminjaman" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tujuan Peminjaman *</label>
                        <input type="text" class="form-control" name="tujuan" required>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Pengajuan</label>
                                <input type="text" class="form-control" name="tgl_pengajuan" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                            <div class="col-md-4 mt-3 mt-md-0">
                                <label class="form-label">Tanggal Mulai *</label>
                                <input type="date" class="form-control" name="tgl_mulai"
                                min="{{ date('Y-m-d') }}"
                                max="{{ \Carbon\Carbon::now()->addDay()->format('d-m-Y') }}"
                                required>
                            </div>
                            <div class="col-md-4 mt-3 mt-md-0">
                                <label class="form-label">Tanggal Selesai *</label>
                                <input type="date" class="form-control" name="tgl_selesai"
                                min="{{ date('Y-m-d') }}"
                                max="{{ \Carbon\Carbon::now()->addDay()->format('d-m-Y') }}"
                                required>
                            </div>
                        </div>
                    </div>

                    <!-- UNGGAH KTM -->
                    <div class="col-12">
                        <label class="form-label">Unggah Foto KTM *</label>
                        <input type="file" class="form-control" name="ktm" required>
                    </div>

                    <!-- TOMBOL KIRIM -->
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5">KIRIM</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
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
    $(document).ready(function () {
        $('#tambah-barang').click(function (e) {
            e.preventDefault();
            let barangItem = `
            <div class="row mb-3 barang-item">
                <div class="col-md-6">
                    <select class="form-select" name="nama_barang[]" required>
                        <option value="" selected disabled>Pilih Barang</option>
                        @foreach ($barang as $brg)
                            <option value="{{ $brg->id_barang }}">{{ $brg->nm_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
					<input type="number" class="form-control" name="jumlah[]" required min="1" max="10" value="1">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-hapus-barang"><i class='bx bx-trash'></i></button>
                </div>
            </div>`;

            $('#barang-container').append(barangItem);
        });

        // Aksi hapus item
        $(document).on('click', '.btn-hapus-barang', function () {
            $(this).closest('.barang-item').remove();
        });
    });
</script>
@endsection

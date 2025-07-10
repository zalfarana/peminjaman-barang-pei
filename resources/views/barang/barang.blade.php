@extends('layout')

@section('title')
    Barang
@endsection

@section('content')
<!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            @if(Auth::user()->role == 'Admin')
            <a href="/tambah-barang" class="btn btn-outline-primary px-5">
                <i class='bx bx-plus mr-1'></i>Tambah Barang
            </a>
            @endif
            <h3>Data Barang</h3>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Foto</th>
                                    <th>Kondisi</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    @if(Auth::user()->role == 'Admin')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barang as $brg)
                                <tr>
                                    <td>{{ $brg->id_barang }}</td>
                                    <td>{{ $brg->nm_barang }}</td>
                                    <td><img src="{{ $brg->foto }}" width="50px"  height="50px" style="border-radius: 50%"></td>
                                    <td>{{ $brg->kondisi }}</td>
                                    <td>{{$brg->stok}}</td>
                                    <td>{{$brg->status}}</td>
                                    @if(Auth::user()->role == 'Admin')
                                    <td>
                                    <a href="/edit-barang/{{ $brg->id_barang }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <a href="/hapus-barang/{{ $brg->id_barang }}" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--end page wrapper -->
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
        $('#example').DataTable();
        } );
</script>

<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
        
        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    } );
</script>
<!--app JS-->
<script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
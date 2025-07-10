@extends('layout')

@section('title')
    Tambah Barang
@endsection

@section('content')
<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<h6 class="mb-0 text-uppercase">Tambah Data Barang</h6>
						<hr/>
						<div class="card border-top border-0 border-4 border-primary">
							<div class="card-body p-5">
								<div class="card-title d-flex align-items-center">
									<div><i class="bx bxs-box me-1 font-22 text-primary"></i>
									</div>
									<h5 class="mb-0 text-primary">Tambah Data Barang</h5>
								</div>
								<hr>
								<form class="row g-3" action="/simpan-barang" method="POST" enctype="multipart/form-data">
									@csrf
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-6">
												<label for="inputFirstName" class="form-label">ID Barang</label>
												<input type="text" class="form-control" name="id_barang" value="{{ $lastBarang }}" readonly>
												@error('id_barang')
												<div class="alert alert-danger mt-2">
													{{ $message }}
												</div>
												@enderror
											</div>
											<div class="col-md-6">
												<label for="inputLastName" class="form-label">Nama Barang</label>
												<input type="text" class="form-control" name="nm_barang" value="{{ old('nm_barang') }}">
												@error('nm_barang')
												<div class="alert alert-danger mt-2">
													{{ $message }}	
												</div>
												@enderror
											</div>

										</div>
									</div>
									<div class="col-md-6">
										<label for="inputState" class="form-label">Kategori</label>
										<select id="inputState" class="form-select" name="kategori" value="{{ old('kategori') }}">
                                    		<option selected disabled>Choose...</option>
											<option>Elektronik</option>
                                            <option>Aksesoris</option>
										</select>
										@error('kategori')
										<div class="alert alert-danger mt-2">
											{{ $message }}
										</div>
										@enderror
									</div>
									<div class="col-md-6">
										<label for="inputEmail" class="form-label">Foto</label>
										<input type="file" class="form-control" name="foto">
										@error('foto')
										<div class="alert alert-danger mt-2">
											{{ $message }}
										</div>
										@enderror
									</div>
									<div class="col-md-6">
										<label for="inputPassword" class="form-label">Kondisi</label>
										<select id="inputState" class="form-select" name="kondisi" value="{{ old('kondisi') }}">
                                    		<option selected disabled>Choose...</option>
											<option>Baik</option>
                                            <option>Rusak</option>
											<option>Perbaikan</option>
										</select>
										@error('kondisi')
										<div class="alert alert-danger mt-2">
											{{ $message }}				
										</div>
										@enderror
									</div>
									<div class="col-md-6">
										<label for="inputPassword" class="form-label">Stok</label>
										<input type="text" class="form-control" name="stok" value="{{ old('stok') }}">
										@error('stok')
										<div class="alert alert-danger mt-2">
											{{ $message }}				
										</div>
										@enderror
									</div>
									<div class="col-md-6">
										<label for="inputState" class="form-label">Status</label>
										<select id="inputState" class="form-select" name="status" value="{{ old('status') }}">
                                    		<option selected disabled>Choose...</option>
											<option>Tersedia</option>
                                            <option>Tidak tersedia</option>
										</select>
										@error('status')
										<div class="alert alert-danger mt-2">
											{{ $message }}
										</div>
										@enderror
									</div>
                                    <div class="col-12 d-flex justify-content-end gap-2">
                                        <a href="/barang" class="btn btn-secondary">
                                            <i class="bx bx-arrow-back"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary px-5">Kirim</button>
                                    </div>
								</form>
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
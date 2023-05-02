<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1><?= $title; ?></h1>
		</div>

		<div class="section-body">

			<!-- main -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped" id="table-1">
									<thead>
										<tr>
											<th class="text-center">
												#
											</th>
											<th>Nama Customer</th>
											<th>Kode Barang</th>
											<th>Nama Barang</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach ($orders as $data) : ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $data->name; ?></td>
												<td><?= $data->kodeBarang; ?></td>
												<td><?= $data->namaBarang; ?></td>
												<td>
													<div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a href="javascript:void(0)" class="dropdown-item progres_btn" data-toggle="modal" data-target="#progresPesanan" data-iduser="<?= $data->idUser; ?>" data-idkhusus="<?= $data->idKhusus; ?>"><i class="fas fa-arrow-left"></i> Progres</a>
															<a href="<?= base_url('admin/orders/delete/' . $data->idKhusus); ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end main -->
		</div>
	</section>
</div>

<!-- modal progres pesanan -->
<div class="modal fade" id="progresPesanan" tabindex="-1" role="dialog" aria-labelledby="progresPesananTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Progres Pesanan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 mb-3">
						<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addProgres">Tambah Progres</a>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<div id="tampil-progres" class="d-none">
								<div class="table-responsive" style="overflow-y: auto; max-height: 500px;">
									<table class="table table-bordered table-hover table-vcenter" id="tabel-progres">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>Status</th>
												<th>Tanggal</th>
												<th>Keterangan</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="isi_table-progres">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- modal add -->
<div class="modal fade" id="addProgres" tabindex="-1" role="dialog" aria-labelledby="addProgres" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Progres</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('admin/orders/addProgres'); ?>" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="idUser" id="idUser">
							<input type="hidden" name="idKhusus" id="idKhusus">
							<div class="form-group">
								<label>Status</label>
								<select name="status" class="form-control">
									<option value="">-- Pilih Status --</option>
									<option value="Menunggu">Menunggu</option>
									<option value="Proses">Proses</option>
									<option value="Sudah Sampai">Sudah Sampai</option>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Tanggal</label>
								<input type="date" class="form-control" name="tanggal">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Keterangan</label>
								<textarea name="ket" cols="30" rows="10" class="form-control"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	let progres_btn = $('.progres_btn');

	$(progres_btn).each(function(i) {
		$(progres_btn[i]).click(function() {
			let idUser = $(this).data('iduser');
			let idKhusus = $(this).data('idkhusus');

			$('#idUser').val(idUser);
			$('#idKhusus').val(idKhusus);

			$.ajax({
				url: `<?= base_url('admin/orders/getListProgres'); ?>`,
				type: 'get',
				dataType: 'json',
				data: {
					idUser,
					idKhusus
				},
				async: true,
				beforeSend: function(e) {
					$('#tampil-progres').addClass('d-none');
				},
				success: function(res) {
					$('#tampil-progres').removeClass('d-none');
					$('.tr_isi-progres').remove();

					if (res.data != null) {
						$(res.data).each(function(i) {
							$("#tabel-progres").append(
								`<tr class='tr_isi-progres'>
                                <td class='text-center'>${i + 1}</td>
                                <td>${res.data[i].status}</td>
                                <td>${(res.data[i].tanggal != null) ? res.data[i].tanggal : ''}</td>
                                <td>${(res.data[i].ket != null) ? res.data[i].ket : ''}</td>
                                <td><a href="<?= base_url('admin/orders/deleteProgres/'); ?>${res.data[i].id}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')" class="badge badge-danger">Delete</a></td>
                                <tr>`
							);
						});

					} else {
						$("#tabel-progres").append(
							"<tr class='tr_isi-progres'>" +
							"<td colspan='3' class='text-center'>Kosong</td>" +
							"<tr>");
					}
				},
				complete: function() {
					$('#tampil-progres').removeClass('d-none');
				}
			});
		});
	});
</script>
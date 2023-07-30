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
											<th class="text-center">No</th>
											<th>Total Biaya</th>
											<th>Bank Transfer</th>
											<th>Pengiriman</th>
											<th>Nama Customer</th>
											<th>Nama Perusahan</th>
											<th>No. HP</th>
											<th>Alamat</th>
											<th>Status Pembayaran</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach ($orders as $data) : ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= 'Rp. ' . number_format($data->totalBiaya, 0, ',', '.'); ?></td>
												<td><?= $data->namaBank . ' - ' . $data->noRek; ?></td>
												<td><?= $data->kota; ?></td>
												<td><?= $data->name; ?></td>
												<td><?= $data->namaPT; ?></td>
												<td><?= $data->nohp; ?></td>
												<td><?= $data->alamat; ?></td>
												<td>
													<?php if ($data->statusPembayaran == 3) : ?>
														<span class="badge badge-warning">Menunggu</span>
													<?php elseif ($data->statusPembayaran == 2) : ?>
														<span class="badge badge-danger">Ditolak</span>
													<?php elseif ($data->statusPembayaran == 1) : ?>
														<span class="badge badge-success">Lunas</span>
													<?php elseif ($data->statusPembayaran == 0) : ?>
														<span class="badge badge-info">Belum Dibayarkan</span>
													<?php endif; ?>
												</td>
												<td>
													<div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a href="javascript:void(0)" class="dropdown-item buktiBtn" data-toggle="modal" data-target="#buktiTf" data-iduser="<?= $data->idUser; ?>" data-idkhusus="<?= $data->idKhusus; ?>" data-bank="<?= $data->namaBank . ' - ' . $data->noRek; ?>" data-statuspembayaran="<?= $data->statusPembayaran; ?>" data-bukti="<?= base_url('uploads/bukti/' . $data->bukti); ?>"><i class="fas fa-arrow-up"></i> Bukti Transfer</a>
															<a href="javascript:void(0)" class="dropdown-item list_btn" data-toggle="modal" data-target="#listBarang" data-iduser="<?= $data->idUser; ?>" data-idkhusus="<?= $data->idKhusus; ?>"><i class="fas fa-arrow-left"></i> List Barang</a>
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

<div class="modal fade" id="buktiTf" tabindex="-1" role="dialog" aria-labelledby="buktiTfTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Bukti Transfer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('admin/orders/editStatusPembayaran'); ?>" method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="idUser" id="iduser">
							<input type="hidden" name="idKhusus" id="idkhusus">
							<div class="form-group">
								<label>Bank Transfer</label>
								<input type="text" name="bank" class="form-control" readonly id="bank">
							</div>
							<div class="form-group">
								<label>Gambar</label>
								<img src="" alt="File Bukti Transfer" class="img-thumbnail" width="100%" id="bukti">
							</div>
							<div class="form-group">
								<label>Status</label>
								<select name="statusPembayaran" class="form-control" id="statuspembayaran">
									<option value="">-- Pilih Status --</option>
									<option value="0">Belum DIbayarkan</option>
									<option value="1">Lunas</option>
									<option value="2">Ditolak</option>
									<option value="3">Menunggu</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="listBarang" tabindex="-1" role="dialog" aria-labelledby="listBarangTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">List Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div id="tampil-list" class="d-none">
								<div class="table-responsive" style="overflow-y: auto; max-height: 500px;">
									<table class="table table-bordered table-hover table-vcenter" id="tabel-list">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>Kode Barang</th>
												<th>Nama Barang</th>
												<th>Gambar</th>
												<th>Harga</th>
												<th>Jumlah</th>
												<th>Subtotal</th>
											</tr>
										</thead>
										<tbody id="isi_table-list">

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
												<th class="text-center">No</th>
												<th>Tanggal</th>
												<th>Status</th>
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
	let buktiBtn = $('.buktiBtn');

	$(buktiBtn).each(function(i) {
		$(buktiBtn[i]).click(function() {
			let iduser = $(this).data('iduser');
			let idkhusus = $(this).data('idkhusus');
			let bank = $(this).data('bank');
			let bukti = $(this).data('bukti');
			let statuspembayaran = $(this).data('statuspembayaran');

			$('#iduser').val(iduser);
			$('#idkhusus').val(idkhusus);
			$('#bank').val(bank);
			$('#bukti').attr('src', bukti);
			$('#statuspembayaran').val(statuspembayaran);
		});
	});

	let list_btn = $('.list_btn');

	$(list_btn).each(function(i) {
		$(list_btn[i]).click(function() {
			let idUser = $(this).data('iduser');
			let idKhusus = $(this).data('idkhusus');

			$.ajax({
				url: `<?= base_url('admin/orders/getListBarang'); ?>`,
				type: 'get',
				dataType: 'json',
				data: {
					idUser,
					idKhusus
				},
				async: true,
				beforeSend: function(e) {
					$('#tampil-list').addClass('d-none');
				},
				success: function(res) {
					$('#tampil-list').removeClass('d-none');
					$('.tr_isi-list').remove();
					$('.tr_total').remove();
					$('.tr_ongkir').remove();

					let subTotal = 0;

					let rupiah = new Intl.NumberFormat('id-ID', {
						style: 'currency',
						currency: 'IDR'
					});

					if (res.data != null) {
						$(res.data).each(function(i) {
							subTotal += (res.data[i].harga * res.data[i].jumlah);

							$("#tabel-list").append(
								`<tr class='tr_isi-list'>
                                <td class='text-center'>${i + 1}</td>
                                <td>${res.data[i].kodeBarang}</td>
                                <td>${res.data[i].namaBarang}</td>
                                <td><img src="<?= base_url('uploads/gambar/'); ?>${res.data[i].gambar}" width="100" class="img-fluid img-thumbnail" alt="${res.data[i].namaBarang}"></td>
								<td>${rupiah.format(res.data[i].harga)}</td>
								<td>${res.data[i].jumlah}</td>
								<td>${rupiah.format((res.data[i].harga * res.data[i].jumlah))}</td>
                                <tr>`
							);
						});

						$("#tabel-list").append(
							"<tr class='tr_ongkir'>" +
							"<td colspan='5' class='text-center'>Pengiriman</td>" +
							"<td>" + res.data[0].kota + "</td>" +
							"<td>" + rupiah.format(res.data[0].hargaOngkir) + "</td>" +
							"<tr>"
						);

						$("#tabel-list").append(
							"<tr class='tr_total'>" +
							"<td colspan='6' class='text-center'>Total</td>" +
							"<td>" + rupiah.format((parseInt(res.data[0].hargaOngkir) + parseInt(subTotal))) + "</td>" +
							"<tr>"
						);

					} else {
						$("#tabel-list").append(
							"<tr class='tr_isi-list'>" +
							"<td colspan='4' class='text-center'>Kosong</td>" +
							"<tr>");
					}
				},
				complete: function() {
					$('#tampil-list').removeClass('d-none');
				}
			});
		});
	});

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
                                <td>${(res.data[i].tanggal != null) ? res.data[i].tanggal : ''}</td>
                                <td>${res.data[i].status}</td>
                                <td>${(res.data[i].ket != null) ? res.data[i].ket : ''}</td>
                                <td><a href="<?= base_url('admin/orders/deleteProgres/'); ?>${res.data[i].id}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')" class="badge badge-danger">Delete</a></td>
                                <tr>`
							);
						});

					} else {
						$("#tabel-progres").append(
							"<tr class='tr_isi-progres'>" +
							"<td colspan='5' class='text-center'>Kosong</td>" +
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